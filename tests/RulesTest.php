<?php

namespace Maslennikov\Authorizator\Tests;

use Illuminate\Support\Facades\Validator;
use Maslennikov\Authorizator\Rules\CircularReferences;

class RulesTest extends TestCase
{
    /**
     * Test Circular References validation rule
     *
     * @param $role
     * @param $children
     * @param $expectations
     * @dataProvider providerCircularReferences
     */
    public function testCircularReferences($role, $children, $expectations)
    {
        $attributes = ['slug' => 'editor', 'children' => ['user', 'content']];
        $validator = Validator::make($attributes, [
            'children' => new CircularReferences(),
        ]);
        $this->assertEquals(false, $validator->fails());
    }

    /**
     * Data Provider for testCircularReferences
     *
     * @return array[]
     */
    public function providerCircularReferences()
    {
        return [
            ['admin', ['editor', 'manager'], false],
            ['editor', ['user', 'content'], false],
            ['editor', ['editor'], true],
            ['editor', ['admin'], true],
        ];
    }
}