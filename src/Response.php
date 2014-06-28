<?php

namespace Http;

interface Response
{
    public function setStatusCode($statusCode);
    public function addHeader($name, $value);
    public function setHeader($name, $value);
    public function getHeaders();
    public function setCookie(Cookie $cookie);
    public function setContent($content);
    public function getContent();
    public function redirect($url);
}