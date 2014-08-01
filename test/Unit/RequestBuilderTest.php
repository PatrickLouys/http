<?php

namespace Http\Test\Unit;

use Http\RequestBuilder;

class RequestBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuildFromSuperglobals()
    {
        $_GET = ['getkey' => 'getvalue', 'postkey' => 'getvalue'];
        $_POST = ['postkey' => 'postvalue'];
        $_COOKIE = ['cookiekey' => 'cookievalue'];
        $_FILES = ['filekey' => 'filevalue'];
        $_SERVER = ['REQUEST_METHOD' => 'GET'];

        $builder = new RequestBuilder;
        $request = $builder->buildFromSuperglobals();

        $this->assertInstanceOf('Http\HttpRequest', $request);

        $this->assertEquals(
            $request->getParameter('getkey'), 
            $_GET['getkey']
        );

        $this->assertEquals(
            $request->getParameter('postkey'), 
            $_POST['postkey']
        );

        $this->assertEquals(
            $request->getFile('filekey'), 
            $_FILES['filekey']
        );

        $this->assertEquals(
            $request->getCookie('cookiekey'), 
            $_COOKIE['cookiekey']
        );

        $this->assertEquals(
            $request->getFile('filekey'), 
            $_FILES['filekey']
        );

        $this->assertEquals(
            $request->getMethod('REQUEST_METHOD'), 
            $_SERVER['REQUEST_METHOD']
        );
    }
}