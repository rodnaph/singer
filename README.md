# Singer, PHP Threading

PHP provides lots of utilities, but calling them in an understandable way usually
leads to a mess of code.  Singer tries to clean this up by allowing 'threading' of
results through functions/methods, giving you a readable chain of business logic.

## Usage

This example assumes two functions _$inc_ and _$even_, then uses PHP's standard
library *array_map* to map _$inc_ over the array, and then also uses the standard
*array_filter* to filter it with _$even_.  Finally fetching the resultant value.

```php
use Singer\Thread as T;

T::create(array(1,2,3))
    ->array_map($inc)
    ->threadFirst()
    ->array_filter($even)
    ->value(); // array(2, 4)
```

So we can use Singer to stitch together bog standard functions in a threaded/chainable
way.

By default Singer does 'thread last', or inserting the context as the last argument
to the function.  You can see from the above example we can switch between this and
'thread first' at will (here to get around the annoyingness of PHPs seemingly
random parameter orders).

## Installation

To install Singer you can either just clone/download from Github, or install 
[through Composer](https://packagist.org/packages/rodnaph/singer).

## Thread first/last

As shown above you can switch between these methods during a chain of execution.

```php
function array_last($array)
{
    return $array[count($array) - 1];
}

T::create(array(1,2,3))
    ->threadLast()
    ->array_last()
    ->threadFirst()
    ->range(10)
    ->value(); // array(3,4,5,6,7,8,9,10);
```

Contrived, but an example.

## Thread to nth

You can also thread into arbitrary positions with _threadNth_

```php
T::create($x)
    ->threadNth(3)
    ->someFunc($one, $two)
    ->value();
```

This uses 1-based indexing. So _1_ for the first argument position, _2_ for the second, etc...

## Namespaces

When calling functions on the threader by default it'll look for those functions in
the root namespace.  Which is fine for the standard library functions.  To change
the namespace, use the _inNamespace_ method.

```php
T::create('foo bar baz')
    ->threadFirst()
    ->inNamespace('String\Utils')
    ->sentenceCase()
    ->inNamespace('Word\Utils')
    ->countWords()
    ->value(); // 3
```

Again, you can change the namespace scope arbitrarily.

## Static/Object Methods

Until now we've just been calling plain old functions, but you can also call class
and instance methods too.

```php
T::create('foo')
    ->onClass('Some\Static\Class')
    ->the_method() // Class::the_method()
    ->onObject($foo)
    ->bar() // $foo->bar()
    ->value();
```

And as usual, these can be included as needed during execution.

## Utilities

There is also a [utilities namespace](docs/util.md) with some utility functions, meant to provide
a hopefully cleaner API than PHP's.

```php
T::create(array(1,2,3))
    ->inNamespace('Singer\Util')
    ->map($inc)
    ->filter($even)
    ->reduce($toTotal, 0)
    ->value();
```

You can create a threader using this namespace as the default using the *singer* function.

```php
T::singer($array)
    ->map($etc)
    ->value();
```

## About

Singer is just playing with some ideas to see if this could be a useful utility in
PHP.  If you'd like to contribute ideas or code just open an issue or pull request.

