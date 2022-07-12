<?php

namespace Maslennikov\Authorizator\Tests;


use Illuminate\Support\Facades\Gate;
use Maslennikov\Authorizator\Facade\Authorizator;

class PermissionsTest extends TestCase
{
    /**
     * @param $role
     * @param $permission
     * @param $grant
     */
    public function testGetPermissions()
    {
        Gate::define('roles.viewAny', function (User $user) {
            return true;
        });
        $this->assertContains('roles.viewAny', Authorizator::getPermissions());
    }

    /**
     * Check that user with role has permission
     * @dataProvider providerRolePermissions
     * @return void
     */
    public function testRolePermissions($role, $permission, $grant)
    {
        User::first()->assignRole($role);
        $this->assertEquals($grant, User::withRole()->first()->hasPermission($permission));
    }

    /**
     * Check that user with no role has no permission
     * @dataProvider providerNoRolePermissions
     * @return void
     */
    public function testNoRolePermissions($permission, $grant)
    {
        $this->assertEquals($grant, User::first()->hasPermission($permission));
    }


    /**
     * @return array[][]
     */
    public function providerRolePermissions()
    {
        return [
            ['user', 'blog.view', true],
            ['user', 'blog.create', false],
            ['user', 'blog.edit', false],
            ['user', 'blog.delete', false],
            ['user', 'blog.publish', false],
            ['user', 'user.manage', false],
            ['content', 'blog.view', true],
            ['content', 'blog.create', true],
            ['content', 'blog.edit', true],
            ['content', 'blog.delete', true],
            ['content', 'blog.publish', false],
            ['content', 'user.manage', false],
            ['editor', 'blog.view', true],
            ['editor', 'blog.create', true],
            ['editor', 'blog.edit', true],
            ['editor', 'blog.delete', true],
            ['editor', 'blog.publish', true],
            ['editor', 'user.manage', false],
            ['manager', 'blog.view', true],
            ['manager', 'blog.create', false],
            ['manager', 'blog.edit', false],
            ['manager', 'blog.delete', false],
            ['manager', 'blog.publish', false],
            ['manager', 'user.manage', true],
            ['admin', 'blog.view', true],
            ['admin', 'blog.create', true],
            ['admin', 'blog.edit', true],
            ['admin', 'blog.delete', true],
            ['admin', 'blog.publish', true],
            ['admin', 'user.manage', true],
        ];
    }

    /**
     * @return array[]
     */
    public function providerNoRolePermissions()
    {
        return [
            ['blog.view', false],
            ['blog.create', false],
            ['blog.edit', false],
            ['blog.delete', false],
            ['blog.publish', false],
            ['user.manage', false],
        ];
    }
}