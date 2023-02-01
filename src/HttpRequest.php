<?php

namespace Http;

/**
 * @template TValue
 */
class HttpRequest implements Request
{
    /**
     * @param array<string,TValue>  $getParameters
     * @param array<string,TValue>  $postParameters
     * @param array<string,TValue>  $cookies
     * @param array<string,TValue>  $files
     * @param array<string,TValue>  $server
     * @param string $inputStream
     */
    public function __construct(
        public readonly array $getParameters,
        public readonly array $postParameters,
        public readonly array $cookies,
        public readonly array $files,
        public readonly array $server,
        public readonly string $inputStream = ''
    ) {
    }

    /**
     * Returns a parameter value or a default value if none is set.
     *
     * @param  string $key
     * @param  string $defaultValue (optional)
     */
    public function getParameter(string $key, $defaultValue = null): string|int|null
    {
        if (array_key_exists($key, $this->postParameters)) {
            return $this->postParameters[$key];
        }

        if (array_key_exists($key, $this->getParameters)) {
            return $this->getParameters[$key];
        }

        return $defaultValue;
    }

    /**
     * Returns a query parameter value or a default value if none is set.
     *
     * @param  string $key
     * @param  string $defaultValue (optional)
     * @return string
     */
    public function getQueryParameter(string $key, $defaultValue = null): string|int|null
    {
        if (array_key_exists($key, $this->getParameters)) {
            return $this->getParameters[$key];
        }

        return $defaultValue;
    }

    /**
     * Returns a body parameter value or a default value if none is set.
     *
     * @param  string $key
     * @param  string $defaultValue (optional)
     * @return string
     */
    public function getBodyParameter(string $key, $defaultValue = null): string
    {
        if (array_key_exists($key, $this->postParameters)) {
            return $this->postParameters[$key];
        }

        return $defaultValue;
    }

    /**
     * Returns a file value or a default value if none is set.
     *
     * @param  string $key
     * @param  string $defaultValue (optional)
     */
    public function getFile(string $key, $defaultValue = null): string|null
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
     */
    public function getCookie(string $key, $defaultValue = null): string|int|null
    {
        if (array_key_exists($key, $this->cookies)) {
            return $this->cookies[$key];
        }

        return $defaultValue;
    }

    /**
     * Returns all parameters.
     *
     * @return array<string, TValue>
     */
    public function getParameters(): array
    {
        return array_merge($this->getParameters, $this->postParameters);
    }

    /**
     * Returns all query parameters.
     *
     * @return array<string, TValue>
     */
    public function getQueryParameters(): array
    {
        return $this->getParameters;
    }

    /**
     * Returns all body parameters.
     *
     * @return array<string, TValue>
     */
    public function getBodyParameters(): array
    {
        return $this->postParameters;
    }

    /**
    * Returns raw values from the read-only stream that allows you to read raw data from the request body.
    *
    * @return string
    */
    public function getRawBody(): string
    {
        return $this->inputStream;
    }

    /**
     * Returns a Cookie Iterator.
     *
     * @return array<string, TValue>
     */
    public function getCookies(): array
    {
        return $this->cookies;
    }

    /**
     * Returns a File Iterator.
     *
     * @return array<string, TValue>
     */
    public function getFiles(): array
    {
        return $this->files;
    }

    /**
     * The URI which was given in order to access this page
     *
     * @return string
     * @throws MissingRequestMetaVariableException
     */
    public function getUri(): string
    {
        return $this->getServerVariable('REQUEST_URI');
    }

    /**
     * Return just the path
     *
     * @return string
     */
    public function getPath(): string
    {
        return strtok($this->getServerVariable('REQUEST_URI'), '?');
    }

    /**
     * Which request method was used to access the page;
     * i.e. 'GET', 'HEAD', 'POST', 'PUT'.
     *
     * @return string
     * @throws MissingRequestMetaVariableException
     */
    public function getMethod(): string
    {
        return $this->getServerVariable('REQUEST_METHOD');
    }

    /**
     * Contents of the Accept: header from the current request, if there is one.
     *
     * @return string
     * @throws MissingRequestMetaVariableException
     */
    public function getHttpAccept(): string
    {
        return $this->getServerVariable('HTTP_ACCEPT');
    }

    /**
     * The address of the page (if any) which referred the user agent to the
     * current page.
     *
     * @return string
     * @throws MissingRequestMetaVariableException
     */
    public function getReferer(): string
    {
        return $this->getServerVariable('HTTP_REFERER');
    }

    /**
     * Content of the User-Agent header from the request, if there is one.
     *
     * @return string
     * @throws MissingRequestMetaVariableException
     */
    public function getUserAgent(): string
    {
        return $this->getServerVariable('HTTP_USER_AGENT');
    }

    /**
     * The IP address from which the user is viewing the current page.
     *
     * @return string
     * @throws MissingRequestMetaVariableException
     */
    public function getIpAddress(): string
    {
        return $this->getServerVariable('REMOTE_ADDR');
    }

    /**
     * Checks to see whether the current request is using HTTPS.
     *
     * @return boolean
     */
    public function isSecure(): bool
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
    public function getQueryString(): string
    {
        return $this->getServerVariable('QUERY_STRING');
    }

    /**
     * @throws MissingRequestMetaVariableException
     */
    private function getServerVariable($key): string
    {
        if (!array_key_exists($key, $this->server)) {
            throw new MissingRequestMetaVariableException($key);
        }

        return $this->server[$key];
    }
}
