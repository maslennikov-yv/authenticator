<?php

namespace Maslennikov\Authorizator\Facade;

use Illuminate\Support\Facades\Facade;
use Maslennikov\Authorizator\Authorizator as AuthorizatorInstance;

/**
 * @method static array checkCircularReferences(string $slug, array $children)
 * @method static bool hasPermission(string $slug, string $permission)
 * @method static AuthorizatorInstance flush()
 */
class Authorizator extends Facade
{
    protected static function getFacadeAccessor(): AuthorizatorInstance
    {
        return 'Authorizator';
    }
}