<?php

namespace Maslennikov\Authorizator\Tests;

use Maslennikov\Authorizator\Facade\Authorizator;

class DatabaseTest extends TestCase
{
    /**
     * Check that tests are working
     * @return void
     */
    public function testDatabaseContainsTestUsers()
    {
        $this->assertSame(1, User::all()->count());
        $this->assertSame(1, Authorizator::roleModel()::where('slug', 'user')->count());
        $this->assertSame(1, Authorizator::roleModel()::where('slug', 'content')->count());
        $this->assertSame(1, Authorizator::roleModel()::where('slug', 'editor')->count());
        $this->assertSame(1, Authorizator::roleModel()::where('slug', 'manager')->count());
        $this->assertSame(1, Authorizator::roleModel()::where('slug', 'admin')->count());
        $this->assertSame(1, Authorizator::roleModel()::where('slug', 'guest')->count());
    }
}
