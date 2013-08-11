
# Singer, PHP Threading

PHP provides lots of utilities, but calling them in an understandable way usually
leads to a mess of code.  Singer tries to clean this up by allowing 'threading' of
results through functions/methods, giving you a readable chain of business logic.

## Usage

This example assumes two functions _$inc_ and _$even_, then maps _$inc_ over the
array, and then filters it with _$even_.  Finally fetching the resultant value.

```php
use Singer\Thread as T;

T::create(array(1,2,3))
    ->array_map($inc)
    ->first()
    ->array_filter($even)
    ->value(); // array(2, 4)
```

By default Singer does 'thread last', or inserting the context as the last argument
to the function.  You can see from the above example we can switch between this and
'thread first' at will (here to get around the annoyingness of PHPs seemingly
random parameter orders).

## Thread first/last

By default Singer uses 'thread last'.  This means that the context is added as the
last argument too all the functions called.  You can also use 'thread first', where
the context is inserted as the first argument.

As shown above you can switch between these methods during a chain of execution.

```php
T::create(array(1,2,3))
    ->last()
    ->array_pop()
    ->first()
    ->range(10)
    ->value(); // array(3,4,5,6,7,8,9,10);
```

Contrived, but an example.

## Namespaces

When calling functions on the threader by default it'll look for those functions in
the root namespace.  Which is fine for the standard library functions.  To change
the namespace, use the _inNamespace_ method.

```php
T::create('foo bar baz')
    ->first()
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
    ->the_method() // metod Class::the_method()
    ->onObject($foo)
    ->bar() // method $foo->bar()
    ->value();
```

And as usual, these can be included as needed during execution.

## About

Singer is just playing with some ideas to see if this could be a useful utility in
PHP.  If you'd like to contribute ideas or code just open an issue or  pull request.

