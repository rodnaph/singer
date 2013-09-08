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
    return array_filter($args, $f);
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
function item(array $args, $index, $default = null)
{
    return isset($args[$index])
        ? $args[$index]
        : $default;
}
