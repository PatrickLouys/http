<?php

namespace Http;

class CookieBuilder
{
    private $defaultDomain;
    private $defaultPath = '/';
    private $defaultSecure = true;
    private $defaultHttpOnly = true;

    public function setDefaultDomain($domain)
    {
        $this->defaultDomain = (string) $domain;
    }

    public function setDefaultPath($path)
    {
        $this->defaultPath = (string) $path;
    }

    public function setDefaultSecure($secure)
    {
        $this->defaultSecure = (bool) $secure;
    }

    public function setDefaultHttpOnly($httpOnly)
    {
        $this->defaultHttpOnly = (bool) $httpOnly;
    }

    public function build($name, $value)
    {
        $cookie = new HttpCookie($name, $value);
        $cookie->setPath($this->defaultPath);
        $cookie->setSecure($this->defaultSecure);
        $cookie->setHttpOnly($this->defaultHttpOnly);

        if ($this->defaultDomain !== null) {
            $cookie->setDomain($this->defaultDomain);
        }

        return $cookie;
    }
}