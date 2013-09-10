# Singer, PHP Threading

PHP provides lots of utilities, but calling them in an understandable way usually
leads to a mess of code.  Singer tries to clean this up by allowing 'threading' of
results through functions/methods, giving you a readable chain of business logic.

## Threading

By 'threading' I don't mean operating system threads, I mean the threading of the result of one function/method into the next.  With PHP we usually need to either assign the results of function calls to temporary variables (to pass them in to the next function)…

```php
$values = array(1, 2, 3);
$evenValues = array_filter($values, $even);
$incdValues = array_map($inc, $evenValues);
```

Or we nest our function calls so the results go straight into the next…

```php
$result = array_map(
	$inc,
    array_filter(
        $values,
        $even
    )
);
```

This is a very simple example, the more steps your have in your data processing the worse it gets.

## Singer Usage

Taking the above simple example, this is how you can rewrite it using Singer.

```php
use Singer\Thread as T;

// standard version

$values = array(1, 2, 3);
$evenValues = array_filter($values, $even);
$incdValues = array_map($inc, $evenValues);

// singer version

T::singer($values)
    ->filter($even)
    ->map($inc)
    ->value();
```

So, Singer allows stitching together of functions, so our code doesn't need to be concerned
with handling temporary variables to control the flow of the data.  Instead of following variable assignments and tracking them being fed back into other functions, the flow of processing is much more evident.

## Thread First/Last

There are a few different methods of threading that Singer allows.  The default is called 'thread last' - which means that the result of each function is passed as the *last* argument to the next function.

The second way you can thread data is called 'thread first' - and means that the result of each function is passed as the *first* parameter to the next in the chain.

You can switch between these using *threadFirst* and *threadLast* methods, as shown below.

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

In this example we're calling our own *array_last* function, and also the core PHP function *range*.

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

## Two constructors

There are two constructors for creating a Singer object, the first is _create_

```php
T::create($initial);
```

Which will create a threading object, using _thread last_, in the root namespace.  You can use this right away to call all the PHP standard library functions.

The second constructor is _singer_

```php
T::singer($initial);
```

Which creates a threading object using _thread last_, in the [utilities namespace](docs/util.md). This namespace provides a bunch of function which are meant to provide a cleaner and more consistent API than PHP's.

```php
T::singer(array(1,2,3))
    ->map($inc)
    ->filter($even)
    ->reduce($toTotal, 0)
    ->value();
```

Both these methods create the same threader object, just with different default namespaces.  You can switch them about with all the options above.

## Isn't this like...

Chaining?  No, chaining is a technique of calling multiple methods on the same object.

Undercore.js chaining? More like this yeah, but with the control to thread first/last and nth.

## What doesn't Singer do?

Singer works best when you're using a more functional approach to writing PHP, and if you use the functions in the utilities namespace (I think) it works quite nicely.

While it does support calling method on objects, if you do find yourself doing this a lot then maybe you should think if it's really the most understandable thing (as your logic is probably to spread across disparate objects...  or something...).

## Installation

To install Singer you can either just clone/download from Github, or install 
[through Composer](https://packagist.org/packages/rodnaph/singer).

## About

If you'd like to contribute ideas or code just open an issue or pull request.
