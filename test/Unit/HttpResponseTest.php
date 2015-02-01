<?php

namespace Http\Test\Unit;

use Http\HttpResponse;

class HttpResponseTest extends \PHPUnit_Framework_TestCase
{
    public function testSetStatusCode()
    {
        $response = new HttpResponse;

        $response->setStatusCode('404');
        $this->assertEquals(
            $response->getHeaders()[0],
            'HTTP/1.1 404 Not Found'
        );
        $this->assertEquals($response->getStatusCode(), 404);

        $response->setStatusCode('555', 'Custom');
        $this->assertEquals($response->getHeaders()[0], 'HTTP/1.1 555 Custom');

        $response->setStatusCode('555');
        $this->assertEquals($response->getHeaders()[0], 'HTTP/1.1 555');
    }

    public function testAddHeader()
    {
        $response = new HttpResponse;

        $response->addHeader('name', 'value');
        $this->assertEquals(
            $response->getHeaders()[1],
            'name: value'
        );

        $response->addHeader('name2', 'value2');
        $this->assertEquals($response->getHeaders()[2], 'name2: value2');

    }

    public function testSetHeader()
    {
        $response = new HttpResponse;
        $response->addHeader('name', 'value');
        $response->addHeader('name2', 'value2');
        $response->setHeader('name2', 'value3');
        $this->assertEquals($response->getHeaders()[2], 'name2: value3');
    }

    public function testAddCookie()
    {
        $response = new HttpResponse;

        $response->addCookie(new MockCookie('mock1'));
        $this->assertEquals($response->getHeaders()[1], 'Set-Cookie: mock1');

        $response->addCookie(new MockCookie('mock2'));
        $this->assertEquals($response->getHeaders()[2], 'Set-Cookie: mock2');
    }

    public function testDeleteCookie()
    {
        $response = new HttpResponse;
        $response->addCookie(new MockCookie('mock1'));
        $response->deleteCookie(new MockCookie('mock1'));
        $this->assertEquals($response->getHeaders()[1], 'Set-Cookie: mock1  -1');
    }

    public function testSetContent()
    {
        $response = new HttpResponse;
        $response->setContent('test');
        $this->assertEquals($response->getContent(), 'test');
    }

    public function testRedirect()
    {
        $response = new HttpResponse;
        $response->redirect('http://test.com');
        $this->assertEquals($response->getHeaders(), [
            'HTTP/1.1 301 Moved Permanently',
            'Location: http://test.com'
        ]);
    }
}

class MockCookie implements \Http\Cookie
{
    private $name;
    private $value;
    private $maxAge;

    public function __construct($name)
    {
        $this->name = (string) $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setValue($value)
    {
        $this->value = (string) $value;
    }

    public function setMaxAge($seconds)
    {
        $this->maxAge = (int) $seconds;
    }

    public function setDomain($domain)
    {
    }

    public function setPath($path)
    {
    }

    public function setSecure($secure)
    {
    }

    public function setHttpOnly($httpOnly)
    {
    }

    public function getHeaderString()
    {
        return trim(implode(' ', [$this->name, $this->value, $this->maxAge]));
    }
}
