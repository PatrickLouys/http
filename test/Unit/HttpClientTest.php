<?php

namespace Http\Test\Unit;

use Http\HttpClient;

class HttpClientTest extends \PHPUnit_Framework_TestCase
{

    public function testGetReferer()
    {
        $server = ['HTTP_REFERER' => 'http://www.example.com/abc?s=a&b=c'];

        $request = new HttpClient($server);

        $this->assertEquals(
            $request->getReferer(), 
            $server['HTTP_REFERER']
        );
    }

    /**
     * @expectedException Http\MissingRequestMetaVariableException
     */
    public function testGetRefererException()
    {
        $request = new HttpClient([]);
        $request->getReferer();
    }

    public function testGetUserAgent()
    {
        $server = ['HTTP_USER_AGENT' => 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko/20100101 Firefox/30.0'];

        $request = new HttpClient($server);

        $this->assertEquals(
            $request->getUserAgent(), 
            $server['HTTP_USER_AGENT']
        );
    }

    /**
     * @expectedException Http\MissingRequestMetaVariableException
     */
    public function testGetUserAgentException()
    {
        $request = new HttpClient([]);
        $request->getUserAgent();
    }

    public function testGetIpAddress()
    {
        $server = ['REMOTE_ADDR' => '127.0.0.1'];

        $request = new HttpClient($server);

        $this->assertEquals(
            $request->getIpAddress(), 
            $server['REMOTE_ADDR']
        );
    }

    /**
     * @expectedException Http\MissingRequestMetaVariableException
     */
    public function testGetIpAddressException()
    {
        $request = new HttpClient([]);
        $request->getIpAddress();
    }

}