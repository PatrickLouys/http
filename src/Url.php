<?php

namespace Http;

use InvalidArgumentException;

class Url
{
    private $parsedUrl;

    public function __construct($url)
    {
        $this->parsedUrl = parse_url($url);
    }

    public function getScheme()
    {
        return $this->get('scheme');
    }

    public function getUsername()
    {
        return $this->get('user');
    }

    public function getPassword()
    {
        return $this->get('pass');
    }

    public function getDomain()
    {
        return $this->get('host');
    }

    public function getPort()
    {
        return $this->get('port');
    }

    public function getPath()
    {
        return $this->get('path');
    }

    public function getQueryString()
    {
        return $this->get('query');
    }

    public function getFragmentId()
    {
        return $this->get('fragment');
    }

    private function get($key)
    {
        if (!isset($this->parsedUrl[$key])) {
            return null;
        }
        return $this->parsedUrl[$key];
    }
}