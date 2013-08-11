<?php

namespace Singer;

use Singer\Thread;

function mymap($f, $args)
{
    return array_map($f, $args);
}

class ThreadTest extends \PHPUnit_Framework_TestCase
{
    private $inc, $odd;

    public static function mymap($f, $args)
    {
        return array_map($f, $args);
    }

    protected function setUp()
    {
        $this->inc = function ($x) {
            return $x + 1;
        };
        $this->odd = function ($x) {
            return $x % 2 == 1;
        };
    }

    public function testThreadFirstAndLast()
    {
        $res = Thread::create(array(1,2,3))
            ->array_map($this->inc)
            ->first()
            ->array_filter($this->odd)
            ->value();
        $this->assertEquals(array(3), array_values($res));
    }

    public function testCanThreadInNamespace()
    {
        $res = Thread::create(array(1,2,3))
            ->inNamespace('Singer')
            ->mymap($this->inc)
            ->value();
        $this->assertEquals(array(2,3,4), array_values($res));
    }

    public function testCanThreadOnStaticMethods()
    {
        $res = Thread::create(array(1,2,3))
            ->onClass('Singer\ThreadTest')
            ->mymap($this->inc)
            ->value();
        $this->assertEquals(array(2,3,4), array_values($res));
    }

    public function testCanThreadOnObjectMethods()
    {
        $bazzle = new Bazzle();
        $res = Thread::create(array(1,2,3))
            ->onObject($bazzle)
            ->mymap($this->inc)
            ->value();
        $this->assertEquals(array(2,3,4), array_values($res));
    }
}

class Bazzle
{
    public function mymap($f, $args)
    {
        return array_map($f, $args);
    }
}
