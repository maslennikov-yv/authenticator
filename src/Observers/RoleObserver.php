<?php

namespace Maslennikov\Authorizator\Observers;

use Maslennikov\Authorizator\Facade\Authorizator;
use Maslennikov\Authorizator\Models\Role;

class RoleObserver
{
    /**
     * Handle the Role "created" event.
     *
     * @param Role $role
     * @return void
     */
    public function created(Role $role): void
    {
        self::flush();
    }

    /**
     * Handle the Role "updated" event.
     *
     * @param Role $role
     * @return void
     */
    public function updated(Role $role): void
    {
        self::flush();
    }

    /**
     * Handle the Role "deleted" event.
     *
     * @param Role $role
     * @return void
     */
    public function deleted(Role $role): void
    {
        self::flush();
    }

    /**
     * Handle the Role "restored" event.
     *
     * @param Role $role
     * @return void
     */
    public function restored(Role $role): void
    {
        self::flush();
    }

    /**
     * Handle the Role "force deleted" event.
     *
     * @param Role $role
     * @return void
     */
    public function forceDeleted(Role $role): void
    {
        self::flush();
    }

    /**
     * @return void
     */
    private function flush(): void
    {
        Authorizator::flush();
    }
}
