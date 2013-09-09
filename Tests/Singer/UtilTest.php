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

    public function testFilterResetsArrayIndexes()
    {
        $even = function ($x) {
            return $x % 2 == 0;
        };
        $actual = \Singer\Util\filter($even, array(1, 2, 3));

        $this->assertEquals(2, $actual[0]);
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

    public function testPickingAnNth()
    {
        $this->assertEquals(2, \Singer\Util\nth(array(1,2), 1));
        $this->assertEquals(3, \Singer\Util\nth(array(1,2), 2, 3));
    }

    public function testEquals()
    {
        $this->assertTrue(\Singer\Util\equals(1, 1));
        $this->assertFalse(\Singer\Util\equals(1, 2));
    }

    public function testSame()
    {
        $x = new \stdclass();
        $y = new \stdclass();

        $this->assertTrue(\Singer\Util\same($x, $x));
        $this->assertFalse(\Singer\Util\same($x, $y));
    }

    public function testPop()
    {
        $this->assertEquals(2, \Singer\Util\pop(array(1,2)));
        $this->assertNull(\Singer\Util\pop(array()));
        $this->assertNull(\Singer\Util\pop(null));
    }

    public function testCount()
    {
        $this->assertEquals(0, \Singer\Util\count(null));
        $this->assertEquals(0, \Singer\Util\count(array()));
        $this->assertEquals(2, \Singer\Util\count(array(1, 2)));
    }
}
