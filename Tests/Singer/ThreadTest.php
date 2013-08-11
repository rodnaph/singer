<?php

namespace Singer;

use Singer\Thread;

class ThreadTest extends \PHPUnit_Framework_TestCase
{
    private $inc, $odd;

    protected function setUp()
    {
        $this->inc = function ($x) {
            print_r($x);
            return $x + 1;
        };
        $this->odd = function ($x) {
            return $x % 2 == 1;
        };
    }

    public function testThreadFirstAndLast()
    {
        $res = Thread::create(array(1,2,3))
            ->last()
            ->array_map($this->inc)
            ->first()
            ->array_filter($this->odd)
            ->value();
        $this->assertEquals(array(3), array_values($res));
    }

    public function testCanThreadInNamespace()
    {
        $this->markTestIncomplete();
    }

    public function testCanThreadOnStaticMethods()
    {
        $this->markTestIncomplete();
    }

    public function testCanThreadOnObjectMethods()
    {
        $this->markTestIncomplete();
    }
}
