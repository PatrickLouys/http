<?php

namespace Http\Test\Unit;

use Http\HttpRequest;
use PHPUnit\Framework\TestCase;

class HttpRequestTest extends TestCase
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
    
    public function testGetQueryParameter()
    {
        $get = [
            'key1' => 'value1',
        ];

        $request = new HttpRequest($get, [], [], [], []);

        $this->assertEquals(
            $request->getQueryParameter('key1'), 
            $get['key1']
        );

        $this->assertEquals(
            $request->getQueryParameter('key1', 'defaultValue'), 
            $get['key1']
        );

        $this->assertEquals(
            $request->getQueryParameter('key3', 'defaultValue'), 
            'defaultValue'
        );

        $this->assertNull($request->getQueryParameter('key3'));
    }

    public function testGetBodyParameter()
    {
        $post = [
            'key1' => 'value1',
        ];

        $request = new HttpRequest([], $post, [], [], []);

        $this->assertEquals(
            $request->getBodyParameter('key1'), 
            $post['key1']
        );

        $this->assertEquals(
            $request->getBodyParameter('key1', 'defaultValue'), 
            $post['key1']
        );

        $this->assertEquals(
            $request->getBodyParameter('key3', 'defaultValue'), 
            'defaultValue'
        );

        $this->assertNull($request->getQueryParameter('key3'));
    }

    public function testGetRawBody()
    {
        $post = "{'key1' => 'value1'}";

        $request = new HttpRequest([], [], [], [], [], $post);

        $this->assertEquals(
            $request->getRawBody(),
            $post
        );
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
    
    public function testGetQueryParameters()
    {
        $get = ['key1' => 'value1'];

        $request = new HttpRequest($get, [], [], [], []);

        $this->assertEquals(
            $request->getQueryParameters(), 
            $get
        );
    }
    
    public function testGetBodyParameters()
    {
        $post = ['key1' => 'value1'];

        $request = new HttpRequest([], $post, [], [], []);

        $this->assertEquals(
            $request->getBodyParameters(), 
            $post
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

    public function testGetMethodException()
    {
        $this->expectException(\Http\MissingRequestMetaVariableException::class);
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

    public function testGetUriException()
    {
        $this->expectException(\Http\MissingRequestMetaVariableException::class);
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

    public function testGetHttpAcceptException()
    {
        $this->expectException(\Http\MissingRequestMetaVariableException::class);
        $request = new HttpRequest([], [], [], [], []);
        $request->getHttpAccept();
    }

    public function testGetReferer()
    {
        $server = ['HTTP_REFERER' => 'http://www.example.com/abc?s=a&b=c'];

        $request = new HttpRequest([], [], [], [], $server);

        $this->assertEquals(
            $request->getReferer(),
            $server['HTTP_REFERER']
        );
    }

    public function testGetRefererException()
    {
        $this->expectException(\Http\MissingRequestMetaVariableException::class);
        $request = new HttpRequest([], [], [], [], []);
        $request->getReferer();
    }

    public function testGetUserAgent()
    {
        $server = ['HTTP_USER_AGENT' => 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko/20100101 Firefox/30.0'];

        $request = new HttpRequest([], [], [], [], $server);

        $this->assertEquals(
            $request->getUserAgent(), 
            $server['HTTP_USER_AGENT']
        );
    }

    public function testGetUserAgentException()
    {
        $this->expectException(\Http\MissingRequestMetaVariableException::class);
        $request = new HttpRequest([], [], [], [], []);
        $request->getUserAgent();
    }

    public function testGetIpAddress()
    {
        $server = ['REMOTE_ADDR' => '127.0.0.1'];

        $request = new HttpRequest([], [], [], [], $server);

        $this->assertEquals(
            $request->getIpAddress(), 
            $server['REMOTE_ADDR']
        );
    }

    public function testGetIpAddressException()
    {
        $this->expectException(\Http\MissingRequestMetaVariableException::class);
        $request = new HttpRequest([], [], [], [], []);
        $request->getIpAddress();
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

    public function testGetQueryStringException()
    {
        $this->expectException(\Http\MissingRequestMetaVariableException::class);
        $request = new HttpRequest([], [], [], [], []);
        $request->getQueryString();
    }
}
