<?php

namespace Http\Test\Unit;

use Http\Url;

class UrlTest extends \PHPUnit_Framework_TestCase
{
    public function testCompleteUrl()
    {
        $url = new Url('http://username:password@domain:80/path?arg=value#fragment_id');
        $this->assertEquals('http', $url->getScheme());
        $this->assertEquals('username', $url->getUsername());
        $this->assertEquals('password', $url->getPassword());
        $this->assertEquals('domain', $url->getDomain());
        $this->assertEquals(80, $url->getPort());
        $this->assertEquals('/path', $url->getPath());
        $this->assertEquals('arg=value', $url->getQueryString());
        $this->assertEquals('fragment_id', $url->getFragmentId());
    }

    public function testScheme()
    {
        $url = new Url('http://foo');
        $this->assertEquals('http', $url->getScheme());

        $url = new Url('foo');
        $this->assertNull($url->getScheme());
    }

    public function testUsername()
    {
        $url = new Url('http://username@domain');
        $this->assertEquals('username', $url->getUsername());

        $url = new Url('http://domain');
        $this->assertNull($url->getUsername());
    }

    public function testPassword()
    {
        $url = new Url('http://username:password@domain');
        $this->assertEquals('password', $url->getPassword());

        $url = new Url('http://domain');
        $this->assertNull($url->getPassword());
    }

    public function testDomain()
    {
        $url = new Url('http://domain.com');
        $this->assertEquals('domain.com', $url->getDomain());

        $url = new Url('http://');
        $this->assertNull($url->getDomain());
    }

    public function testPort()
    {
        $url = new Url('http://domain.com:80');
        $this->assertEquals(80, $url->getPort());

        $url = new Url('http://domain.com');
        $this->assertNull($url->getPort());
    }

    public function testPath()
    {
        $url = new Url('http://domain.com/path/foo/bar');
        $this->assertEquals('/path/foo/bar', $url->getPath());

        $url = new Url('http://domain.com');
        $this->assertNull($url->getPath());
    }

    public function testQueryString()
    {
        $url = new Url('http://domain.com?foo=bar&bar=foo');
        $this->assertEquals('foo=bar&bar=foo', $url->getQueryString());

        $url = new Url('http://domain.com');
        $this->assertNull($url->getQueryString());
    }

    public function testFragmentId()
    {
        $url = new Url('http://domain.com#fragment_id');
        $this->assertEquals('fragment_id', $url->getFragmentId());

        $url = new Url('http://domain.com');
        $this->assertNull($url->getFragmentId());
    }
}