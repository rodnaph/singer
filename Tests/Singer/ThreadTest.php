<?php

namespace Singer;

class ThreadTest extends \PHPUnit_Framework_TestCase
{
    private $inc, $odd;

    protected function setUp()
    {
        $this->inc = function ($x) {
            return $x + 1;
        };
        $this->odd = function ($x) {
            return $x % 2 != 1;
        };
    }

    public function testThreadLast()
    {
        $res = Thread::last(array(1,2,3))
            ->map($this->inc)
            ->filter($this->odd)
            ->value();
        $this->assertEquals(array(3), $res);
    }

    public function testThreadFirst()
    {
    }
}
