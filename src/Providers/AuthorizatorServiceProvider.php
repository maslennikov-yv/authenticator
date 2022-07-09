<?php

namespace Maslennikov\Authorizator\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Maslennikov\Authorizator\Authorizator;
use Maslennikov\Authorizator\Models\Role;
use Maslennikov\Authorizator\Observers\RoleObserver;
use Maslennikov\Authorizator\Policies\RolePolicy;

class AuthorizatorServiceProvider extends ServiceProvider
{
    /**
     * @var array|string[]
     */
    public array $bindings = [
        'Authorizator' => Authorizator::class,
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../Config/authorizator.php' => config_path('authorizator.php'),
        ], 'authorizator-config');

        $this->publishes([
            __DIR__ . '/../Database/Migrations' => database_path('migrations'),
        ], 'authorizator-migrations');

        Gate::resource('roles', RolePolicy::class);

        Role::observe(RoleObserver::class);
    }

}