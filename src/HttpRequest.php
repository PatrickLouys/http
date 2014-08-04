<?php

namespace Http;

class HttpRequest implements Request
{
    protected $parameters;
    protected $server;
    protected $files;
    protected $cookies;

    public function __construct(
        array $get,
        array $post,
        array $cookies,
        array $files,
        array $server
    ) {
        $this->parameters = array_merge($get, $post);
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
        if (array_key_exists($key, $this->parameters)) {
            return $this->parameters[$key];
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
        if (array_key_exists($key, $this->files)) {
            return $this->files[$key];
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
        if (array_key_exists($key, $this->cookies)) {
            return $this->cookies[$key];
        }

        return $defaultValue;
    }

    /**
     * Returns a File Iterator.
     * 
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Returns a Cookie Iterator.
     * 
     * @return array
     */
    public function getCookies()
    {
        return $this->cookies;
    }

    /**
     * Returns a File Iterator.
     * 
     * @return array
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
     * @throws MissingRequestMetaVariableException
     */
    public function getMethod()
    {
        if (!array_key_exists('REQUEST_METHOD', $this->server)) {
            throw new MissingRequestMetaVariableException('REQUEST_METHOD');
        }
        
        return $this->server['REQUEST_METHOD'];
    }

    /**
     * Contents of the Accept: header from the current request, if there is one.
     * 
     * @return string
     * @throws MissingRequestMetaVariableException
     */
    public function getHttpAccept()
    {
        if (!array_key_exists('HTTP_ACCEPT', $this->server)) {
            throw new MissingRequestMetaVariableException('HTTP_ACCEPT');
        }
        
        return $this->server['HTTP_ACCEPT'];
    }

    /**
     * The address of the page (if any) which referred the user agent to the 
     * current page.
     * 
     * @return string
     * @throws MissingRequestMetaVariableException
     */
    public function getReferer()
    {
        if (!array_key_exists('HTTP_REFERER', $this->server)) {
            throw new MissingRequestMetaVariableException('HTTP_REFERER');
        }
        
        return $this->server['HTTP_REFERER'];
    }

    /**
     * Content of the User-Agent header from the request, if there is one.
     * 
     * @return string
     * @throws MissingRequestMetaVariableException
     */
    public function getUserAgent()
    {
        if (!array_key_exists('HTTP_USER_AGENT', $this->server)) {
            throw new MissingRequestMetaVariableException('HTTP_USER_AGENT');
        }
        
        return $this->server['HTTP_USER_AGENT'];
    }

    /**
     * The IP address from which the user is viewing the current page.
     * 
     * @return string
     * @throws MissingRequestMetaVariableException
     */
    public function getIpAddress()
    {
        if (!array_key_exists('REMOTE_ADDR', $this->server)) {
            throw new MissingRequestMetaVariableException('REMOTE_ADDR');
        }
        
        return $this->server['REMOTE_ADDR'];
    }

    /**
     * Checks to see whether the current request is using HTTPS.
     * 
     * @return boolean
     */
    public function isSecure()
    {
        return (array_key_exists('HTTPS', $this->server)
            && $this->server['HTTPS'] !== 'off'
        );
    }

    /**
     * The query string, if any, via which the page was accessed.
     * 
     * @return string
     * @throws MissingRequestMetaVariableException
     */
    public function getQueryString()
    {
        if (!array_key_exists('QUERY_STRING', $this->server)) {
            throw new MissingRequestMetaVariableException('QUERY_STRING');
        }
        
        return $this->server['QUERY_STRING'];
    }
}