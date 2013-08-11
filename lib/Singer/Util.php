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
    return $y
        ? array_reduce($x, $f)
        : array_reduce($y, $f, $x);
}

