
# Singer Utilities

This namespace has some utility functions which sometimes clean-up
or replace PHPs standard library versions (as their interfaces are
usually pretty clunky).

## map

Wrapper for *array_map*

```php
$result = map(
    $function,
    $array
)
```

## filter

Wrapper for *array_filter*

```php
$result = filter(
    $function,
    $array
);
```

## reduce

Wrapper for *array_reduce*

```php
// with 2-args
$result = reduce(
    $function,
    $array
);

// with 3-args
$result = reduce(
    $function,
    $initial,
    $array
);
```

## sum

Allows giving a function which returns an assoc of array
of keys and values, where the values will be summed over
the series.

```php
sum(
  function ($item) {
    return array(
      "total" => $item
    );
  },
  array(
    1, 2, 3
  )
) // => array('total' => 6)
```

This makes it a so you can avoid messing around with the
accumulator, because mutating it is icky.

## sort

Provide a user defined sorting function.

```php
$lowToHigh = function($a, $b) {
  return $a > $b;
};

sort($lowToHigh, $array);
```

## item

Pick an item at an index, or return the default.

```php
item(array(1, 2), 0) // => 1
item(array(1, 2), 2, 3) // => 3
``

The optional third argument is the default 'not found'.

## equals

Test two items are loosely equal.

```php
equals(1, 1) // => true
equals(1, 2) // => false
```

## same

Test two items refer to the same variable.

```php
$x = new DateTime();
$y = new DateTime();

same($x, $x) // => true
same($x, $y) // => false
``

## debug

Prints out the arguments and exits.

```php
debug(1) => // '1'
```

