<?php

namespace Singer;

class Thread
{
    /**
     * @var mixed
     */
    private $context;

    /**
     * Create a new 'thread first' Thread
     *
     * @return Thread
     */
    public static function first($context)
    {
        return new Thread(
            $context,
            self::threader('push')
        );
    }

    /**
     * New 'thread last' Thread
     *
     * @return Thread
     */
    public static function last($context)
    {
        return new Thread(
            $context,
            self::threader('unshift')
        );
    }

    /**
     * Create 'threader' function to interleave context
     * into function arguments before execution
     *
     * @param string $type
     *
     * @return Callable
     */
    protected static function threader($type)
    {
        $context = $this->context;

        return function ($f, array $args = array()) use ($context) {
            $threader = sprintf('array_%s', $type);
            $params = call_user_func_array(
                $threader,
                array($context, $args)
            );

            return call_user_func_array($f, $params);
        };
    }

    /**
     * @param string $context
     * @param Callable $threader
     */
    protected function __construct($context, $threader)
    {
        $this->context = $context;
        $this->threader = $threader;
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
        $threader = $this->threader;

        $this->context = $threader($name, $params);

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
}
