<?php

namespace Maslennikov\Authorizator\Tests;

use Maslennikov\Authorizator\Models\Role;

class DatabaseTest extends TestCase
{
    /**
     * Check that tests are working
     * @return void
     */
    public function testDatabaseContainsTestUsers()
    {
        $this->assertSame(1, User::all()->count());
        $this->assertSame(1, Role::where('slug', 'user')->count());
        $this->assertSame(1, Role::where('slug', 'content')->count());
        $this->assertSame(1, Role::where('slug', 'editor')->count());
        $this->assertSame(1, Role::where('slug', 'manager')->count());
        $this->assertSame(1, Role::where('slug', 'admin')->count());
        $this->assertSame(1, Role::where('slug', 'guest')->count());
    }
}
