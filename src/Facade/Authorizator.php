<?php

namespace Maslennikov\Authorizator\Facade;

use Illuminate\Support\Facades\Facade;
use Maslennikov\Authorizator\Authorizator as AuthorizatorInstance;

/**
 * @method static array checkCircularReferences(string $slug, array $children)
 * @method static bool hasPermission(string $slug, string $permission)
 * @method static AuthorizatorInstance flush()
 * @method static string roleModel()
 * @method static string[] getPermissions()
 */
class Authorizator extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'Authorizator';
    }
}