<?php

namespace Http;

class HttpRequest implements Request
{
    protected $getVariables;
    protected $postVariables;
    protected $serverVariables;
    protected $filesVariables;
    protected $cookieVariables;

    public function __construct(
        Getter $getVariables,
        Getter $postVariables,
        Getter $serverVariables,
        Getter $filesVariables,
        Getter $cookieVariables
    ) {
        $this->getVariables = $getVariables;
        $this->postVariables = $postVariables;
        $this->serverVariables = $serverVariables;
        $this->filesVariables = $filesVariables;
        $this->cookieVariables = $cookieVariables;
    }

    public function get($key, $defaultValue = null)
    {
        if(true === $this->getVariables->has($key)) {
            return $this->getVariables->get($key);
        }
        return $defaultValue;
    }

    public function post($key, $defaultValue = null)
    {
        if(true === $this->postVariables->has($key)) {
            return $this->postVariables->get($key);
        }
        return $defaultValue;
    }

    public function server($key, $defaultValue = null)
    {
        if(true === $this->serverVariables->has($key)) {
            return $this->serverVariables->get($key);
        }
        return $defaultValue;
    }

    public function files($key, $defaultValue = null)
    {
        if(true === $this->filesVariables->has($key)) {
            return $this->filesVariables->get($key);
        }
        return $defaultValue;
    }

    public function cookie($key, $defaultValue = null)
    {
        if(true === $this->cookieVariables->has($key)) {
            return $this->cookieVariables->get($key);
        }
        return $defaultValue;
    }

    public function getIterator()
    {
        return $this->getVariables;
    }

    public function postIterator()
    {
        return $this->postVariables;
    }

    public function serverIterator()
    {
        return $this->serverVariables;
    }

    public function filesIterator()
    {
        return $this->filesVariables;
    }

    public function cookieIterator()
    {
        return $this->cookieVariables;
    }

    public function getMethod()
    {
        return $this->server('REQUEST_METHOD');
    }
}