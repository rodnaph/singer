<?php

namespace Singer;

class Thread
{
    /**
     * @var mixed
     */
    private $context;

    /**
     * Create a new thread
     *
     * @return Thread
     */
    public static function create()
    {
        return new Thread();
    }

    /**
     * Map function over the data (or context)
     *
     * @param Callable $f
     * @param mixed $data
     *
     * @return Thread
     */
    public function map($f, $data = null)
    {
        $this->context = array_map($f, $this->getData($data));
        return $this;
    }

    /**
     * Apply filter to the data or context
     *
     * @param Callable $f
     * @param mixed $data
     *
     * @return Thread
     */
    public function filter($f, $data = null)
    {
        $this->context = array_filter($this->getData($data), $f);
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
     * Fetch data or context
     *
     * @param mixed $data
     *
     * @return mixed
     */
    protected function getData($data)
    {
        return $data
            ? $data
            : $this->context;
    }
}
