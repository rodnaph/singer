<?php

namespace Singer;

include __DIR__ . '/../../lib/Singer/Util.php';

class UtilTest extends \PHPUnit_Framework_TestCase
{
    public function testMap()
    {
        $inc = function ($x) {
            return $x + 1;
        };
        $actual = \Singer\Util\map($inc, array(1, 2, 3));

        $this->assertEquals(array(2, 3, 4), $actual);
    }

    public function testFilter()
    {
        $even = function ($x) {
            return $x % 2 == 0;
        };
        $actual = \Singer\Util\filter($even, array(1, 2, 3));

        $this->assertEquals(1, count($actual));
    }

    public function testReduce()
    {
        $sum = function ($acc, $x) {
            return $acc + $x;
        };
        $actual = \Singer\Util\reduce($sum, 0, array(1, 2, 3));

        $this->assertEquals(6, $actual);
    }
}
