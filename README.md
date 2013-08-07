
# Singer, PHP Threading

Just some ideas of how it could be neat to write threaded code in PHP.

## Usage

```php
use Singer\Thread;

Thread::create()
    ->map($inc, array(1, 2, 3))
    ->filter($even)
    ->value(); // array(2, 4)
```

