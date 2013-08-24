
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

