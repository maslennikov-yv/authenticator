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
        $this->assertContains('user', Role::find(1)->toArray());
        $this->assertContains('content', Role::find(2)->toArray());
        $this->assertContains('editor', Role::find(3)->toArray());
        $this->assertContains('manager', Role::find(4)->toArray());
        $this->assertContains('admin', Role::find(5)->toArray());
        $this->assertContains('guest', Role::find(6)->toArray());
    }
}
