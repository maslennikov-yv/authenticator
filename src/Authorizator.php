<?php

namespace Maslennikov\Authorizator;

use Illuminate\Support\Facades\Gate;
use Laminas\Permissions\Rbac\Rbac;
use Laminas\Permissions\Rbac\RoleInterface;

class Authorizator
{
    /** @var Rbac */
    private static $rbac;

    /** @var string */
    public static string $roleModel = 'Maslennikov\\Authorizator\\Models\\Role';

    /**
     * @return Rbac
     */
    public function getRbac(): Rbac
    {
        if (null === self::$rbac) {
            $rbac = new Rbac();
            foreach (self::roleModel()::all() as $r) {
                $role = $this->insureRole($rbac, $r->slug);
                foreach ($r->children ?? [] as $child) {
                    $role->addChild(self::insureRole($rbac, $child));
                }
                foreach ($r->permissions ?? [] as $permission) {
                    $role->addPermission($permission);
                }
                $rbac->addRole($role);
            }
            self::$rbac = $rbac;
        }
        return self::$rbac;
    }

    /**
     * @param $model
     * @return void
     */
    public static function useRoleModel($model): void
    {
        static::$roleModel = $model;
    }

    /**
     * @return string
     */
    public static function roleModel(): string
    {
        return static::$roleModel;
    }

    /**
     * @param string $slug
     * @param string $permission
     * @return bool
     */
    public function hasPermission(string $slug, string $permission): bool
    {
        return $this->getRbac()->getRole($slug)->hasPermission($permission);
    }

    /**
     * @param string $slug
     * @param array $children
     * @return array
     */
    public function checkCircularReferences(string $slug, array $children): array
    {
        $circularReferences = [];
        $rbac = clone $this->flush()->getRbac();
        $role = $this->insureRole($rbac, $slug);
        foreach ($children as $child_slug) {

            $child = $this->insureRole($rbac, $child_slug);

            if (!$role->checkCircularReferences($child)) {
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
     * @return RoleInterface
     */
    private function insureRole(Rbac $rbac, string $slug): RoleInterface
    {
        if (!$rbac->hasRole($slug)) {
            $rbac->addRole($slug);
        }
        return $rbac->getRole($slug);
    }
}