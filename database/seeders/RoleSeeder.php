<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Maslennikov\Authorizator\Models\Role;

class RoleSeeder extends Seeder
{

    /**
     * @var string[][]
     */
    protected $rows = [
        [
            'slug' => 'role-manager',
            'name' => 'Role manager',
            'children' => null,
            'permissions' => ['roles.view', 'roles.viewAny', 'roles.create', 'roles.update', 'roles.delete'],
        ],
        [
            'slug' => 'admin',
            'name' => 'Administrator',
            'children' => ['role-manager'],
            'permissions' => null,
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect($this->rows)->each(function (array $row) {
            Role::create(
                [
                    'slug' => $row['slug'],
                    'name' => $row['name'],
                    'children' => $row['children'],
                    'permissions' => $row['permissions'],
                ]
            );
        });
    }
}
