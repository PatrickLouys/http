<?php

namespace Http;

class RequestBuilder
{
    public function buildFromSuperglobals()
    {
        $parameters = array_merge($_GET, $_POST);

        return new HttpRequest(
            $parameters,
            $_COOKIE,
            $_FILES,
            $_SERVER
        );
    }
}