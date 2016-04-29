<?php

namespace Http;

class HttpResponse implements Response
{
    private $version = '1.1';
    private $statusCode = 200;
    private $statusText = 'OK';
    private $headers = [];
    private $cookies = [];
    private $content;

    private $statusTexts = [
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-Status',
        208 => 'Already Reported',
        226 => 'IM Used',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => 'Reserved',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot',
        422 => 'Unprocessable Entity',
        423 => 'Locked',
        424 => 'Failed Dependency',
        425 => 'Reserved for WebDAV advanced collections expired proposal',
        426 => 'Upgrade Required',
        428 => 'Precondition Required',
        429 => 'Too Many Requests',
        431 => 'Request Header Fields Too Large',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        506 => 'Variant Also Negotiates',
        507 => 'Insufficient Storage',
        508 => 'Loop Detected',
        510 => 'Not Extended',
        511 => 'Network Authentication Required',
    ];

    /**
     * Sets the HTTP status code.
     *
     * @param  integer $statusCode
     * @param  string  $statusText (optional)
     * @return void
     */
    public function setStatusCode($statusCode, $statusText = null)
    {
        if ($statusText === null
            && array_key_exists((int) $statusCode, $this->statusTexts)
        ) {
            $statusText = $this->statusTexts[$statusCode];
        }

        $this->statusCode = (int) $statusCode;
        $this->statusText = (string) $statusText;
    }

    /**
     * Returns the HTTP status code
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Adds a header with the given name.
     *
     * @param  string $name
     * @param  string $value
     * @return void
     */
    public function addHeader($name, $value)
    {
        $this->headers[$name][] = (string) $value;
    }

    /**
     * Sets a new header for the given name.
     *
     * Replaces all headers with the same names.
     *
     * @param  string $name
     * @param  string $value
     * @return void
     */
    public function setHeader($name, $value)
    {
        $this->headers[$name] = [
            (string) $value,
        ];
    }

    /**
     * Returns an array with the HTTP headers.
     *
     * @return array
     */
    public function getHeaders()
    {
        $headers = array_merge(
            $this->getRequestLineHeaders(),
            $this->getStandardHeaders(),
            $this->getCookieHeaders()
        );

        return $headers;
    }

    /**
     * Adds a new cookie.
     *
     * @param  Cookie $cookie
     * @return void
     */
    public function addCookie(Cookie $cookie)
    {
        $this->cookies[$cookie->getName()] = $cookie;
    }

    /**
     * Deletes a cookie.
     *
     * @param  Cookie $cookie
     * @return void
     */
    public function deleteCookie(Cookie $cookie)
    {
        $cookie->setValue('');
        $cookie->setMaxAge(-1);
        $this->cookies[$cookie->getName()] = $cookie;
    }

    /**
     * Sets the body content.
     *
     * @param  string $content
     * @return void
     */
    public function setContent($content)
    {
        $this->content = (string) $content;
    }

    /**
     * Returns the body content.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Sets the headers for a redirect.
     *
     * @param  string $url
     * @return void
     */
    public function redirect($url)
    {
        $this->setHeader('Location', $url);
        $this->setStatusCode(301);
    }

    private function getRequestLineHeaders()
    {
        $headers = [];

        $requestLine = sprintf(
            'HTTP/%s %s %s',
            $this->version,
            $this->statusCode,
            $this->statusText
        );

        $headers[] = trim($requestLine);

        return $headers;
    }

    private function getStandardHeaders()
    {
        $headers = [];

        foreach ($this->headers as $name => $values) {
            foreach ($values as $value) {
                $headers[] = "$name: $value";
            }
        }

        return $headers;
    }

    private function getCookieHeaders()
    {
        $headers = [];

        foreach ($this->cookies as $cookie) {
            $headers[] = 'Set-Cookie: ' . $cookie->getHeaderString();
        }

        return $headers;
    }
}
