<?php

namespace Maslennikov\Authorizator\Tests;

use Illuminate\Support\Str;
use Maslennikov\Authorizator\Traits\HasRole;
use Illuminate\Foundation\Auth\User as BaseUser;

class User extends BaseUser
{
    use HasRole;

    /**
     * Boot functions from Laravel.
     */
    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::uuid()->toString();
            }
        });
    }


    /**
     * Get the value indicating whether the IDs are incrementing.
     */
    public function getIncrementing(): bool
    {
        return false;
    }

    /**
     * Get the auto-incrementing key type.
     */
    public function getKeyType(): string
    {
        return 'string';
    }
}
