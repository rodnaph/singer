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

    public function testSum()
    {
        $sum = function ($x) {
            return array(
                'total' => $x
            );
        };
        $actual = \Singer\Util\sum($sum, array(1, 2, 3));

        $this->assertEquals(6, $actual['total']);
    }

    public function testSort()
    {
        $lowToHigh = function($a, $b) {
            return $a > $b;
        };

        $this->assertEquals(
            array(1, 3, 5),
            \Singer\Util\sort($lowToHigh, array(5, 1, 3))
        );
    }

    public function testPickingAnItem()
    {
        $this->assertEquals(2, \Singer\Util\item(array(1,2), 1));
        $this->assertEquals(3, \Singer\Util\item(array(1,2), 2, 3));
    }
}
