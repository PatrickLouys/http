<?php

namespace Http;

class HttpCookie implements Cookie
{
    private $name;
    private $value;
    private $domain;
    private $path;
    private $maxAge;
    private $secure;
    private $httpOnly;

    public function __construct($name, $value)
    {
        $this->name = (string) $name;
        $this->value = (string) $value;
    }

    /**
     * Returns the cookie name.
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the cookie value.
     * 
     * @param  string $value
     * @return void
     */
    public function setValue($value)
    {
        $this->value = (string) $value;
    }

    /**
     * Sets the cookie max age in seconds.
     * 
     * @param  integer $seconds
     * @return void
     */
    public function setMaxAge($seconds)
    {
        $this->maxAge = (int) $seconds;
    }

    /**
     * Sets the cookie domain.
     * 
     * @param  string $domain
     * @return void
     */
    public function setDomain($domain)
    {
        $this->domain = (string) $domain;
    }

    /**
     * Sets the cookie path.
     * 
     * @param  string $path
     * @return void
     */
    public function setPath($path)
    {
        $this->path = (string) $path;
    }

    /**
     * Sets the cookie secure flag.
     * 
     * @param  boolean $secure
     * @return void
     */
    public function setSecure($secure)
    {
        $this->secure = (bool) $secure;
    }

    /**
     * Sets the cookie httpOnly flag.
     * 
     * @param  boolean $httpOnly
     * @return void
     */
    public function setHttpOnly($httpOnly)
    {
        $this->httpOnly = (bool) $httpOnly;
    }

    /**
     * Returns the cookie HTTP header string.
     * 
     * @return string
     */
    public function getHeaderString()
    {
        $parts = [
            $this->name . '=' . $this->value,
        ];

        if ($this->maxAge !== null) {
            $parts[] = 'Max-Age='. $this->maxAge;
            $parts[] = 'expires=' . date(
                "D, d-M-Y H:i:s", 
                time() + $this->maxAge
            ) . ' GMT';
        }

        if ($this->domain) {
            $parts[] = "domain=$this->domain";
        }

        if ($this->path) {
            $parts[] = "path=$this->path";
        }

        if ($this->secure) {
            $parts[] = 'secure';
        }

        if ($this->httpOnly) {
            $parts[] = 'HttpOnly';
        }

        return implode('; ', $parts);
    }
}