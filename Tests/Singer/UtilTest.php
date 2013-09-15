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

    public function testFirst()
    {
        $this->assertEquals(1, \Singer\Util\first(array(1,2)));
        $this->assertNull(\Singer\Util\first(array()));
        $this->assertNull(\Singer\Util\first(null));

        $this->assertEquals(1, \Singer\Util\first(array(), 1));
        $this->assertEquals(1, \Singer\Util\first(null, 1));
    }

    public function testLast()
    {
        $this->assertEquals(2, \Singer\Util\last(array(1,2)));
        $this->assertNull(\Singer\Util\last(array()));
        $this->assertNull(\Singer\Util\last(null));

        $this->assertEquals(1, \Singer\Util\last(array(), 1));
        $this->assertEquals(1, \Singer\Util\last(null, 1));
    }

    public function testCount()
    {
        $this->assertEquals(0, \Singer\Util\count(null));
        $this->assertEquals(0, \Singer\Util\count(array()));
        $this->assertEquals(2, \Singer\Util\count(array(1, 2)));
    }

    public function testF()
    {
        $count = \Singer\Util\f('Singer\Util\count');

        $this->assertEquals(2, $count(array(1, 2)));
    }

    public function testCons()
    {
        $this->assertEquals(array(1), \Singer\Util\cons(1, array()));
        $this->assertEquals(array(2, 1), \Singer\Util\cons(2, array(1)));
    }

    public function testContains()
    {
        $array = array(1, 'foo');

        $this->assertTrue(\Singer\Util\contains($array, 1));
        $this->assertTrue(\Singer\Util\contains($array, 'foo'));
        $this->assertFalse(\Singer\Util\contains($array, 2));
        $this->assertFalse(\Singer\Util\contains($array, 'bar'));
    }

    public function testDistinct()
    {
        $result = \Singer\Util\distinct(array(1, 1, 2, 2, 1, 1, 2));

        $this->assertEquals(2, count($result));
        $this->assertTrue(\Singer\Util\contains($result, 1));
        $this->assertTrue(\Singer\Util\contains($result, 2));
    }
}
