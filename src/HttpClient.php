<?php

namespace Http;

class HttpClient
{
    private $server;

    public function __construct(array $server)
    {
        $this->server = $server;
    }

    public function getReferer()
    {
        return $this->getServerVariable('HTTP_REFERER');
    }

    public function getUserAgent()
    {
        return $this->getServerVariable('HTTP_USER_AGENT');
    }

    public function getIpAddress()
    {
        return $this->getServerVariable('REMOTE_ADDR');
    }

    private function getServerVariable($key)
    {
        if (!array_key_exists($key, $this->server)) {
            throw new MissingRequestMetaVariableException($key);
        }
        
        return $this->server[$key];
    }
}