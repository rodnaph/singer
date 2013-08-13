<?php

namespace Singer;

/**
 *
 */
class Thread
{
    /**
     * @var mixed
     */
    private $context;

    /**
     * @var Callable
     */
    private $threader;

    /**
     * @var Callable
     */
    private $caller;

    /**
     * Create a new threader, 'thread last' by default in root namespace
     *
     * @return Thread
     */
    public static function create($context)
    {
        $t = new Thread($context, null, null);

        return $t
            ->last()
            ->inNamespace('');
    }

    /**
     * @param string $context
     * @param Callable $threader
     * @param Callable $caller
     */
    protected function __construct($context, $threader, $caller)
    {
        $this->context = $context;
        $this->threader = $threader;
        $this->caller = $caller;
    }

    /**
     * Change to using 'thread first'
     *
     * @return Thread
     */
    public function first()
    {
        return new Thread(
            $this->context,
            function ($context, $args) {
                array_unshift($args, $context);
                return $args;
            },
            $this->caller
        );
    }

    /**
     * Change to using 'thread last'
     *
     * @return Thread
     */
    public function last()
    {
        return new Thread(
            $this->context,
            function ($context, $args) {
                array_push($args, $context);
                return $args;
            },
            $this->caller
        );
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
        return new Thread(
            $this->context,
            $this->threader,
            function ($name) use ($namespace) {
                return sprintf('%s\%s', $namespace, $name);
            }
        );
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
     * Set the caller to use the target (class name or object)
     *
     * @param mixed $target
     *
     * @return Thread
     */
    protected function callOn($target)
    {
        return new Thread(
            $this->context,
            $this->threader,
            function ($name) use ($target) {
                return array($target, $name);
            }
        );
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

        return call_user_func_array(
            $threader($this->context, $params),
            $caller($name)
        );
    }
}
