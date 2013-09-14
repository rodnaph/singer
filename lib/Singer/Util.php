<?php

namespace Singer\Util;

use Closure;

/**
 * @param Closure $f
 * @param array $array
 *
 * @return array
 */
function map($f, array $array)
{
    return array_map($f, $array);
}

/**
 * @param Closure $f
 * @param array $array
 *
 * @return array
 */
function filter($f, array $array)
{
    return array_values(
        array_filter($array, $f)
    );
}

/**
 * Can be called with either:
 *
 *    reduce(func, array)
 *    reduce(func, initial, array)
 *
 * @param Closure $f
 * @param mixed $x
 * @param mixed $y
 *
 * @return mixed
 */
function reduce($f, $x, $y = null)
{
    return $y !== null
        ? array_reduce($y, $f, $x)
        : array_reduce($x, $f);
}

/**
 * @param Closure $f
 * @param array $array
 *
 * @return array
 */
function sort($f, array $array)
{
    usort($array, $f);

    return $array;
}

/**
 * Pick an item at an index (or use default)
 *
 * @param array $array
 * @param integer $index
 * @param mixed $default
 *
 * @return mixed
 */
function nth(array $array, $index, $default = null)
{
    return isset($array[$index])
        ? $array[$index]
        : $default;
}

/**
 * Test two items are loosely equal
 *
 * @param mixed $x
 * @param mixed $y
 *
 * @return boolean
 */
function equals($x, $y)
{
    return $x == $y;
}

/**
 * Test two variables are strictly equal
 *
 * @param mixed $x
 * @param mixed $y
 *
 * @return boolean
 */
function same($x, $y)
{
    return $x === $y;
}

/**
 * Return first item of array, or default (null)
 *
 * @param array $array
 * @param mixed $default
 *
 * @return mixed
 */
function first(array $array = null, $default = null)
{
    return isset($array[0])
        ? $array[0]
        : $default;
}

/**
 * Return last item of an array, or default (null)
 *
 * @param array $array
 * @param mixed $default
 *
 * @return mixed
 */
function last(array $array = null, $default = null)
{
    $count = count($array);

    return $count > 0
        ? $array[$count - 1]
        : $default;
}

/**
 * @param array $array
 *
 * @return integer
 */
function count(array $array = null)
{
    return $array
        ? \count($array)
        : 0;
}
