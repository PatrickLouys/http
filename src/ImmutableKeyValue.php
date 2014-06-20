<?php

namespace Http;

class ImmutableKeyValue implements Getter, \Iterator
{
    protected $array = [];

    public function __construct(array $array)
    {
        $this->array = $array;
    }

    public function get($key)
    {
        if ($this->has($key)) {
            return $this->array[$key];
        }
    }

    public function has($key)
    {
        if (array_key_exists($key, $this->array)) {
            return true;
        }
        return false;
    }

    function rewind()
    {
        return reset($this->array);
    }

    function current()
    {
        return current($this->array);
    }

    function key()
    {
        return key($this->array);
    }

    function next()
    {
        return next($this->array);
    }

    function valid()
    {
        return key($this->array) !== null;
    }
}