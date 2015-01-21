<?php

namespace Http\Test\Unit;

use Http\HttpRequest;

class HttpRequestTest extends \PHPUnit_Framework_TestCase
{
    public function testGetParameter()
    {
        $get = [
            'key1' => 'value1',
        ];

        $post = [
            'key2' => 'value2',
        ];

        $request = new HttpRequest($get, $post, [], [], []);

        $this->assertEquals(
            $request->getParameter('key1'), 
            $get['key1']
        );

        $this->assertEquals(
            $request->getParameter('key1', 'defaultValue'), 
            $get['key1']
        );

        $this->assertEquals(
            $request->getParameter('key2'), 
            $post['key2']
        );

        $this->assertEquals(
            $request->getParameter('key3', 'defaultValue'), 
            'defaultValue'
        );

        $this->assertNull($request->getParameter('key3'));
    }

    public function testGetCookie()
    {
        $cookies = [
            'key1' => 'value1',
            'key2' => 'value2',
        ];

        $request = new HttpRequest([], [], $cookies, [], []);

        $this->assertEquals(
            $request->getCookie('key1'), 
            $cookies['key1']
        );

        $this->assertEquals(
            $request->getCookie('key1', 'defaultValue'), 
            $cookies['key1']
        );

        $this->assertEquals(
            $request->getCookie('key2'), 
            $cookies['key2']
        );

        $this->assertEquals(
            $request->getCookie('key3', 'defaultValue'), 
            'defaultValue'
        );

        $this->assertNull($request->getCookie('key3'));
    }

    public function testGetFile()
    {
        $files = [
            'key1' => 'value1',
            'key2' => 'value2',
        ];

        $request = new HttpRequest([], [], [], $files, []);

        $this->assertEquals(
            $request->getFile('key1'), 
            $files['key1']
        );

        $this->assertEquals(
            $request->getFile('key1', 'defaultValue'), 
            $files['key1']
        );

        $this->assertEquals(
            $request->getFile('key2'), 
            $files['key2']
        );

        $this->assertEquals(
            $request->getFile('key3', 'defaultValue'), 
            'defaultValue'
        );

        $this->assertNull($request->getFile('key3'));
    }

    public function testGetParameters()
    {
        $get = ['key1' => 'value1'];

        $request = new HttpRequest($get, [], [], [], []);

        $this->assertEquals(
            $request->getParameters(), 
            $get
        );
    }

    public function testGetCookies()
    {
        $cookies = ['key1' => 'value1'];

        $request = new HttpRequest([], [], $cookies, [], []);

        $this->assertEquals(
            $request->getCookies(), 
            $cookies
        );
    }

    public function testGetFiles()
    {
        $files = ['key1' => 'value1'];

        $request = new HttpRequest([], [], [], $files, []);

        $this->assertEquals(
            $request->getFiles(), 
            $files
        );
    }

    public function testGetMethod()
    {
        $server = ['REQUEST_METHOD' => 'POST'];

        $request = new HttpRequest([], [], [], [], $server);

        $this->assertEquals(
            $request->getMethod(), 
            $server['REQUEST_METHOD']
        );
    }

    /**
     * @expectedException Http\MissingRequestMetaVariableException
     */
    public function testGetMethodException()
    {
        $request = new HttpRequest([], [], [], [], []);
        $request->getMethod();
    }

    public function testGetUri()
    {
        $server = ['REQUEST_URI' => '/test?abc=def'];

        $request = new HttpRequest([], [], [], [], $server);

        $this->assertEquals(
            $request->getUri(), 
            $server['REQUEST_URI']
        );

        $server = ['REQUEST_URI' => '/test'];

        $request = new HttpRequest([], [], [], [], $server);

        $this->assertEquals(
            $request->getUri(), 
            $server['REQUEST_URI']
        );
    }

    /**
     * @expectedException Http\MissingRequestMetaVariableException
     */
    public function testGetUriException()
    {
        $request = new HttpRequest([], [], [], [], []);
        $request->getUri();
    }

    public function testGetPath()
    {
        $server = ['REQUEST_URI' => '/test?abc=def'];

        $request = new HttpRequest([], [], [], [], $server);

        $this->assertEquals(
            $request->getPath(), 
            '/test'
        );

        $server = ['REQUEST_URI' => '/test'];

        $request = new HttpRequest([], [], [], [], $server);

        $this->assertEquals(
            $request->getPath(), 
            '/test'
        );
    }

    public function testGetHttpAccept()
    {
        $server = ['HTTP_ACCEPT' => 'Accept: audio/*; q=0.2, audio/basic'];

        $request = new HttpRequest([], [], [], [], $server);

        $this->assertEquals(
            $request->getHttpAccept(), 
            $server['HTTP_ACCEPT']
        );
    }

    /**
     * @expectedException Http\MissingRequestMetaVariableException
     */
    public function testGetHttpAcceptException()
    {
        $request = new HttpRequest([], [], [], [], []);
        $request->getHttpAccept();
    }

    public function testIsSecure()
    {
        $request = new HttpRequest([], [], [], [], []);
        $this->assertFalse($request->isSecure());

        $request = new HttpRequest([], [], [], [], ['HTTPS' => 'off']);
        $this->assertFalse($request->isSecure());

        $request = new HttpRequest([], [], [], [], ['HTTPS' => 'on']);
        $this->assertTrue($request->isSecure());
    }

    public function testGetQueryString()
    {
        $server = ['QUERY_STRING' => '/over/there?name=ferret'];

        $request = new HttpRequest([], [], [], [], $server);

        $this->assertEquals(
            $request->getQueryString(), 
            $server['QUERY_STRING']
        );
    }

    /**
     * @expectedException Http\MissingRequestMetaVariableException
     */
    public function testGetQueryStringException()
    {
        $request = new HttpRequest([], [], [], [], []);
        $request->getQueryString();
    }
}