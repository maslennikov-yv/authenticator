<?php

namespace Maslennikov\Authorizator\Observers;

use Maslennikov\Authorizator\Facade\Authorizator;
use Illuminate\Database\Eloquent\Model;

class RoleObserver
{
    /**
     * Handle the Role "created" event.
     *
     * @param Model $role
     * @return void
     */
    public function created(Model $role): void
    {
        self::flush();
    }

    /**
     * Handle the Role "updated" event.
     *
     * @param Model $role
     * @return void
     */
    public function updated(Model $role): void
    {
        self::flush();
    }

    /**
     * Handle the Role "deleted" event.
     *
     * @param Model $role
     * @return void
     */
    public function deleted(Model $role): void
    {
        self::flush();
    }

    /**
     * Handle the Role "restored" event.
     *
     * @param Model $role
     * @return void
     */
    public function restored(Model $role): void
    {
        self::flush();
    }

    /**
     * Handle the Role "force deleted" event.
     *
     * @param Model $role
     * @return void
     */
    public function forceDeleted(Model $role): void
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
