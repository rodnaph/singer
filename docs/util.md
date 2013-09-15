
# Singer Utilities

This namespace has some utility functions which sometimes clean-up
or replace PHPs standard library versions (as their interfaces are
usually pretty clunky).

## f

Returns a Closure around a named function, so that function can then
be used as a Closure.

```php
$count = f('count');

$count(array(1, 2)); // 2
```

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

Note, unlike array_filter indexes are reset.

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

## sort

Provide a user defined sorting function.

```php
$lowToHigh = function($a, $b) {
  return $a > $b;
};

sort($lowToHigh, $array);
```

## nth

Pick an item at the nth position, or return the default.

```php
nth(array(1, 2), 0);    // => 1
nth(array(1, 2), 2, 3); // => 3
```

The optional third argument is the default 'not found'.

## equals

Test two items are loosely equal.

```php
equals(1, 1); // => true
equals(1, 2); // => false
```

## same

Test two items refer to the same variable.

```php
$x = new DateTime();
$y = new DateTime();

same($x, $x); // => true
same($x, $y); // => false
``

## first

Return the first item of an array, or default.

```php
first(array(1, 2)); // 1
first(array());     // null
first(null);        // null
first(array(), 1);  // 1
first(null, true);  // true
```

## last

Return the last item of an array, or default.

```php
last(array(1, 2)); // => 2
last(array());     // null
last(null);        // null
last(array(), 1);  // 1
last(null, true);  // true
```

## count

Count the items in an array.

```php
count(null);        // => 0
count(array());     // => 0
count(array(1, 2)); // => 2
```

## cons

Add an item to the front of an array.

```php
cons(1, array());    // => array(1)
cons(2, array(1));   // => array(2, 1)
```

## contains

Indiciates if an array contains the specified item.

```php
contains(array(1, 2), 1);   // => true
contains(array(1, 2), 3);   // => false
```

## distinct

Returns distinct items from the array.

```php
distinct(array(1, 1, 2, 2))     // => array(1, 2)
```

