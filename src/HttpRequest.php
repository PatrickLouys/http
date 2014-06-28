<?php

namespace Http;

use Storage\Getter;

class HttpRequest implements Request
{
    protected $parameterVars;
    protected $serverVars;
    protected $fileVars;
    protected $cookieVars;

    public function __construct(
        Getter $parameterVars,
        Getter $cookieVars
        Getter $fileVars,
        Getter $serverVars,
    ) {
        $this->parameterVars = $parameterVars;
        $this->cookieVars = $cookieVars;
        $this->fileVars = $fileVars;
        $this->serverVars = $serverVars;
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
        if(true === $this->parameterVars->has($key)) {
            return $this->parameterVars->get($key);
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
        if(true === $this->fileVars->has($key)) {
            return $this->fileVars->get($key);
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
        if(true === $this->cookieVars->has($key)) {
            return $this->cookieVars->get($key);
        }

        return $defaultValue;
    }

    /**
     * Returns a File Iterator.
     * 
     * @return \Storage\ImmutableKeyValue
     */
    public function getParameterIterator()
    {
        return $this->parameterVars;
    }

    /**
     * Returns a Cookie Iterator.
     * 
     * @return \Storage\ImmutableKeyValue
     */
    public function getCookieIterator()
    {
        return $this->cookieVars;
    }

    /**
     * Returns a File Iterator.
     * 
     * @return \Storage\ImmutableKeyValue
     */
    public function getFileIterator()
    {
        return $this->fileVars;
    }

    /**
     * Which request method was used to access the page;
     * i.e. 'GET', 'HEAD', 'POST', 'PUT'. 
     * 
     * @return string
     */
    public function getMethod()
    {
        return $this->serverVars->get('REQUEST_METHOD');
    }

    /**
     * Contents of the Accept: header from the current request, if there is one.
     * 
     * @return string
     */
    public function getHttpAccept()
    {
        return $this->serverVars->get('HTTP_ACCEPT');
    }

    /**
     * The address of the page (if any) which referred the user agent to the 
     * current page.
     * 
     * @return string
     */
    public function getReferer()
    {
        return $this->serverVars->get('HTTP_REFERER');
    }

    /**
     * Content of the User-Agent header from the request, if there is one.
     * 
     * @return string
     */
    public function getUserAgent()
    {
        return $this->serverVars->get('HTTP_USER_AGENT');
    }

    /**
     * The IP address from which the user is viewing the current page.
     * 
     * @return string
     */
    public function getIpAddress()
    {
        return $this->serverVars->getVars->get('HTTP_USER_AGENT');
    }

    /**
     * Checks to see whether the current request is using HTTPS.
     * 
     * @return boolean
     */
    public function isSecure()
    {
        return ($this->serverVars->has('HTTPS') 
            && $this->serverVars->get('HTTPS') !== 'off'
        );
    }

    /**
     * The query string, if any, via which the page was accessed.
     * 
     * @return string
     */
    public function getQueryString()
    {
        return $this->serverVars->getVars->get('QUERY_STRING');
    }
}