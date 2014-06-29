<?php

namespace Http;

use Storage\Getter;

class HttpRequest implements Request
{
    protected $parameters;
    protected $server;
    protected $files;
    protected $cookies;

    public function __construct(
        Getter $parameters,
        Getter $cookies,
        Getter $files,
        Getter $server
    ) {
        $this->parameters = $parameters;
        $this->cookies = $cookies;
        $this->files = $files;
        $this->server = $server;
    }

    /**
     * Returns a parameter value or a default value if none is set.
     * 
     * @param  string $key
     * @param  string $defaultValue (optional)
     * @return string
     */
    public function getParameter($key, $defaultValue = null)
    {
        if(true === $this->parameters->has($key)) {
            return $this->parameters->get($key);
        }

        return $defaultValue;
    }

    /**
     * Returns a file value or a default value if none is set.
     * 
     * @param  string $key
     * @param  string $defaultValue (optional)
     * @return string
     */
    public function getFile($key, $defaultValue = null)
    {
        if(true === $this->files->has($key)) {
            return $this->files->get($key);
        }

        return $defaultValue;
    }

    /**
     * Returns a cookie value or a default value if none is set.
     * 
     * @param  string $key
     * @param  string $defaultValue (optional)
     * @return string
     */
    public function getCookie($key, $defaultValue = null)
    {
        if(true === $this->cookies->has($key)) {
            return $this->cookies->get($key);
        }

        return $defaultValue;
    }

    /**
     * Returns a File Iterator.
     * 
     * @return \Storage\ImmutableKeyValue
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Returns a Cookie Iterator.
     * 
     * @return \Storage\ImmutableKeyValue
     */
    public function getCookies()
    {
        return $this->cookies;
    }

    /**
     * Returns a File Iterator.
     * 
     * @return \Storage\ImmutableKeyValue
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * Which request method was used to access the page;
     * i.e. 'GET', 'HEAD', 'POST', 'PUT'. 
     * 
     * @return string
     */
    public function getMethod()
    {
        return $this->server->get('REQUEST_METHOD');
    }

    /**
     * Contents of the Accept: header from the current request, if there is one.
     * 
     * @return string
     */
    public function getHttpAccept()
    {
        return $this->server->get('HTTP_ACCEPT');
    }

    /**
     * The address of the page (if any) which referred the user agent to the 
     * current page.
     * 
     * @return string
     */
    public function getReferer()
    {
        return $this->server->get('HTTP_REFERER');
    }

    /**
     * Content of the User-Agent header from the request, if there is one.
     * 
     * @return string
     */
    public function getUserAgent()
    {
        return $this->server->get('HTTP_USER_AGENT');
    }

    /**
     * The IP address from which the user is viewing the current page.
     * 
     * @return string
     */
    public function getIpAddress()
    {
        return $this->server->getVars->get('HTTP_USER_AGENT');
    }

    /**
     * Checks to see whether the current request is using HTTPS.
     * 
     * @return boolean
     */
    public function isSecure()
    {
        return ($this->server->has('HTTPS') 
            && $this->server->get('HTTPS') !== 'off'
        );
    }

    /**
     * The query string, if any, via which the page was accessed.
     * 
     * @return string
     */
    public function getQueryString()
    {
        return $this->server->getVars->get('QUERY_STRING');
    }
}