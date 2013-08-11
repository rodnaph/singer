
# Singer, PHP Threading

PHP provides lots of utilities, but calling them in an understandable way usually
leads to a mess of code.  Singer tries to clean this up by allowing 'threading' of
results through functions/methods, giving you a readable chain of business logic.

## Usage

This example assumes two functions _$inc_ and _$even_, then maps _$inc_ over the
array, and then filters it with _$even_.  Finally fetching the resultant value.

```php
use Singer\Thread as T;

T:create(array(1,2,3))
    ->array_map($inc)
    ->first()
    ->array_filter($even)
    ->value(); // array(2, 4)
```

By default Singer does 'thread last', or inserting the context as the last argument
to the function.  You can see from the above example we can switch between this and
'thread first' at will (here to get around the annoyingness of PHPs seemingly
random parameter orders).

