
# Singer Utilities

This namespace has some utility functions which sometimes clean-up
or replace PHPs standard library versions (as their interfaces are
usually pretty clunky).

## map

Wrapper for *array_map*

```php
$result = Util::map(
    $function,
    $array
)
```

## filter

Wrapper for *array_filter*

```php
$result = Util::filter(
    $function,
    $array
);
```

## reduce

Wrapper for *array_reduce*

```php
// with 2-args
$result = Util::reduce(
    $function,
    $array
);

// with 3-args
$result = Util::reduce(
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

This makes it a so can avoid messing around with the
accumulator, because mutating it is icky.

