<?php

namespace Maslennikov\Authorizator;

use Illuminate\Support\Facades\Gate;
use Laminas\Permissions\Rbac\Rbac;
use Laminas\Permissions\Rbac\RoleInterface;
use Maslennikov\Authorizator\Models\Role;

class Authorizator
{
    /** @var Rbac */
    private static $rbac;

    public function __construct()
    {
    }

    /**
     * @return Rbac
     */
    public static function getRbac(): Rbac
    {
        if (null === self::$rbac) {
            self::setRbac();
        }
        return self::$rbac;
    }

    /**
     * @param Rbac|null $rbac
     * @return void
     */
    public static function setRbac(Rbac $rbac = null): void
    {
        if ($rbac == null) {
            $rbac = new Rbac();
            foreach (Role::all() as $r) {
                $role = self::insureRole($rbac, $r->slug);
                foreach ($r->children ?? [] as $child) {
                    $role->addChild(self::insureRole($rbac, $child));
                }
                foreach ($r->permissions ?? [] as $permission) {
                    $$role->addPermission($permission);
                }
                $rbac->addRole($role);
            }
        }
        self::$rbac = $rbac;
    }

    /**
     * @param string $slug
     * @param string $permission
     * @return void
     */
    public function hasPermission(string $slug, string $permission)
    {
        return $this->getRbac()->getRole($slug)->hasPermission($permission);
    }

    public function checkCircularReferences(string $slug, array $children): array
    {
        $circularReferences = [];
        $rbac = clone $this->flush()->getRbac();
        $role = $this->insureRole($rbac, $slug);
        foreach ($children as $child_slug) {

            $child = $this->insureRole($rbac, $child_slug);

            if ($role->checkCircularReferences($child)) {
                $role->addChild($child);
            } else {
                $circularReferences[] = $child_slug;
            }

        }
        return $circularReferences;
    }


    /**
     * @return $this
     */
    public function flush(): self
    {
        self::$rbac = null;
        return $this;
    }

    /**
     * @return array
     */
    public function getPermissions(): array
    {
        return array_keys(Gate::abilities());
    }

    /**
     * @param Rbac $rbac
     * @param string $slug
     * @return \Laminas\Permissions\Rbac\RoleInterface
     */
    private function insureRole(Rbac $rbac, string $slug): RoleInterface
    {
        if (!$rbac->hasRole($slug)) {
            $rbac->addRole($slug);
        }
        return $rbac->getRole($slug);
    }
}