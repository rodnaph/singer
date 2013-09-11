<?php

namespace Singer;

use Closure;

class Thread
{
    /**
     * @var mixed
     */
    private $context;

    /**
     * @var Closure
     */
    private $threader;

    /**
     * @var Closure
     */
    private $caller;

    /**
     * Create a new threader, 'thread last' by default in root namespace
     *
     * @return Thread
     */
    public static function create($context)
    {
        $thread = new Thread($context);

        return $thread
            ->threadLast()
            ->inNamespace('');
    }

    /**
     * @param mixed $context
     *
     * @return Thread
     */
    public static function singer($context)
    {
        include_once __DIR__ . '/Util.php';

        return self::create($context)
            ->inNamespace('Singer\Util');
    }

    /**
     * Change to using 'thread first'
     *
     * @return Thread
     */
    public function threadFirst()
    {
        $this->threader = function ($context, $args) {
            array_unshift($args, $context);
            return $args;
        };

        return $this;
    }

    /**
     * Change to using 'thread last'
     *
     * @return Thread
     */
    public function threadLast()
    {
        $this->threader = function ($context, $args) {
            array_push($args, $context);
            return $args;
        };

        return $this;
    }

    /**
     * Thread into nth position
     *
     * @param integeger $n
     *
     * @return Thread
     */
    public function threadNth($n)
    {
        $this->threader = function ($context, $args) use ($n) {
            array_splice($args, $n - 1, 0, array($context));
            return $args;
        };

        return $this;
    }

    /**
     * Change scope to specified namespace
     *
     * @param string $namespace
     *
     * @return Thread
     */
    public function inNamespace($namespace)
    {
        $this->caller = function ($name) use ($namespace) {
            return sprintf('%s\%s', $namespace, $name);
        };

        return $this;
    }

    /**
     * Change scope to call static functions on class
     *
     * @param string $class
     *
     * @return Thread
     */
    public function onClass($class)
    {
        return $this->callOn($class);
    }

    /**
     * Change scope to call on object
     *
     * @param object $object
     *
     * @return Thread
     */
    public function onObject($object)
    {
        return $this->callOn($object);
    }

    /**
     * Catch calls to functions
     *
     * @param string $name
     * @param array $params
     *
     * @return Thread
     */
    public function __call($name, $params)
    {
        $this->context = $this->thread($name, $params);

        return $this;
    }

    /**
     * Return current context value
     *
     * @return mixed
     */
    public function value()
    {
        return $this->context;
    }

    /**
     * Debug the context, using print_r by default, or the
     * custom function if specified.
     *
     * @param Closure $debugger
     */
    public function debug($debugger = null)
    {
        call_user_func_array(
            $debugger ?: '\print_r',
            array($this->context)
        );

        exit(1);
    }

    /**
     * @param string $context
     */
    protected function __construct($context)
    {
        $this->context = $context;
    }

    /**
     * Set the caller to use the target (class name or object)
     *
     * @param mixed $target
     *
     * @return Thread
     */
    protected function callOn($target)
    {
        $this->caller = function ($name) use ($target) {
            return array($target, $name);
        };

        return $this;
    }

    /**
     * Thread context into named function and assigned context
     * to the result
     *
     * @return mixed
     */
    protected function thread($name, $params)
    {
        $threader = $this->threader;
        $caller = $this->caller;
        $context = $this->context;

        $threaded = $threader($context, $params);
        $callable = $caller($name);

        return call_user_func_array($callable, $threaded);
    }
}
