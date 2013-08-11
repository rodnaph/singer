<?php

namespace Singer;

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
     * @var string
     */
    private $namespace;

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
        $t = new Thread($context);
        $t->last();
        $t->inNamespace('');

        return $t;
    }

    /**
     * @param string $context
     */
    protected function __construct($context)
    {
        $this->context = $context;
    }

    /**
     * Change to using 'thread first'
     *
     * @return Thread
     */
    public function first()
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
    public function last()
    {
        $this->threader = function ($context, $args) {
            array_push($args, $context);
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
            return sprintf(
                '%s\%s',
                $namespace,
                $name
            );
        };

        return $this;
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
     * Thread context into named function and assigned context
     * to the result
     *
     * @return mixed
     */
    protected function thread($name, $params)
    {
        $threader = $this->threader;
        $caller = $this->caller;

        $threaded = $threader($this->context, $params);
        $callable = $caller($name);

        return call_user_func_array($callable, $threaded);
    }
}
