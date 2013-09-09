<?php

namespace Singer\Util;

/**
 * @param Callable $f
 * @param array $args
 *
 * @return array
 */
function map($f, array $args)
{
    return array_map($f, $args);
}

/**
 * @param Callable $f
 * @param array $args
 *
 * @return array
 */
function filter($f, array $args)
{
    return array_values(
        array_filter($args, $f)
    );
}

/**
 * Can be called with either:
 *
 *    reduce(func, array)
 *    reduce(func, initial, array)
 *
 * @param Callable $f
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
 * Allows summing of multiple values returned from function
 * over a series.
 *
 * eg.
 *
 * sum(
 *   function ($item) {
 *     return array(
 *       'total' => $item
 *     );
 *   },
 *   array(
 *     1, 2, 3
 *   )
 * )
 *
 * =>
 *
 * array(
 *   'total' => 6
 * )
 *
 * @param Callable $f
 * @param array $args
 *
 * @return array
 */
function sum($f, array $args)
{
    $summer = function ($acc, $x) use ($f) {
        foreach ($f($x) as $k => $v) {
            if (!isset($acc[$k])) {
                $acc[$k] = 0;
            }
            $acc[$k] += $v;
        }

        return $acc;
    };

    return reduce($summer, array(), $args);
}

/**
 * @param Callable $f
 * @param array $args
 *
 * @return array
 */
function sort($f, array $args)
{
    usort($args, $f);

    return $args;
}

/**
 * Pick an item at an index (or use default)
 *
 * @param array $args
 * @param integer $index
 * @param mixed $default
 *
 * @return mixed
 */
function nth(array $args, $index, $default = null)
{
    return isset($args[$index])
        ? $args[$index]
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
 * Debug the passed arguments and exit
 *
 * @param boolean $andDie
 */
function debug()
{
    print_r(func_get_args());

    exit(1);
}

/**
 * Pop an item from the end of the array (without mutating the array)
 *
 * @param array $args
 *
 * @return mixed
 */
function pop(array $args = null)
{
    $count = count($args);

    return $count > 0
        ? $args[$count - 1]
        : null;
}
