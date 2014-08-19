<?php

namespace Http\Test\Unit;

use Http\HttpCookie;

class HttpCookieTest extends \PHPUnit_Framework_TestCase
{
    public function testGetName()
    {
        $cookie = new HttpCookie('name', 'value');
        $this->assertEquals($cookie->getName(), 'name');
    }

    public function testSetValue()
    {
        $cookie = new HttpCookie('name', 'value');
        $cookie->setValue('newValue');
        $this->assertEquals($cookie->getHeaderString(), 'name=newValue');

        $cookie->setValue('new Value"');
        $this->assertEquals($cookie->getHeaderString(), 'name=new%20Value%22');
    }

    public function testSetMaxAge()
    {
        $cookie = new HttpCookie('name', 'value');
        $cookie->setMaxAge(100);
        $this->assertStringMatchesFormat(
            'name=value; Max-Age=100; expires=%s GMT', 
            $cookie->getHeaderString()
        );
    }

    public function testSetDomain()
    {
        $cookie = new HttpCookie('name', 'value');
        $cookie->setDomain('.example.com');
        $this->assertEquals(
            'name=value; domain=.example.com', 
            $cookie->getHeaderString()
        );
    }

    public function testSetPath()
    {
        $cookie = new HttpCookie('name', 'value');
        $cookie->setPath('/test');
        $this->assertEquals(
            'name=value; path=/test', 
            $cookie->getHeaderString()
        );
    }

    public function testSetSetSecure()
    {
        $cookie = new HttpCookie('name', 'value');
        $cookie->setSecure(true);
        $this->assertEquals(
            'name=value; secure', 
            $cookie->getHeaderString()
        );

        $cookie->setSecure(false);
        $this->assertEquals(
            'name=value', 
            $cookie->getHeaderString()
        );
    }

    public function testSetHttpOnly()
    {
        $cookie = new HttpCookie('name', 'value');
        $cookie->setHttpOnly(true);
        $this->assertEquals(
            'name=value; HttpOnly', 
            $cookie->getHeaderString()
        );

        $cookie->setHttpOnly(false);
        $this->assertEquals(
            'name=value', 
            $cookie->getHeaderString()
        );
    }
}