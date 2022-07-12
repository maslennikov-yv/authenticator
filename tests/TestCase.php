<?php

namespace Maslennikov\Authorizator\Tests;

use Illuminate\Support\Str;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Maslennikov\Authorizator\Models\Role;
use Maslennikov\Authorizator\Providers\AuthorizatorServiceProvider;

class TestCase extends OrchestraTestCase
{
    /**
     * Setup the test environment.
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom(realpath(__DIR__ . '/../database/migrations/'));

        $this->setupDatabase($this->app);
    }

    /**
     * Load package service provider
     * @param \Illuminate\Foundation\Application $app
     * @return array|string[]
     */
    protected function getPackageProviders($app)
    {
        return [
            AuthorizatorServiceProvider::class,
        ];
    }

    /**
     * Load package alias
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
        ];
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $app['config']->set(User::class);
    }

    protected function setupDatabase($app)
    {
        $user = User::create();
        $user->save();

        collect([
            [
                'slug' => 'user',
                'children' => null,
                'permissions' => ['blog.view'],
            ],
            [
                'slug' => 'content',
                'children' => ['user'],
                'permissions' => ['blog.create', 'blog.edit', 'blog.delete'],
            ],
            [
                'slug' => 'editor',
                'children' => ['content'],
                'permissions' => ['blog.publish'],
            ],
            [
                'slug' => 'manager',
                'children' => ['user'],
                'permissions' => ['user.manage'],
            ],
            [
                'slug' => 'admin',
                'children' => ['editor', 'manager'],
                'permissions' => null,
            ],
            [
                'slug' => 'guest',
                'children' => null,
                'permissions' => null,
            ],
        ])->each(function (array $row) {
            Role::create(
                [
                    'slug' => $row['slug'],
                    'children' => $row['children'],
                    'permissions' => $row['permissions'],
                ]
            );
        });
    }
}
