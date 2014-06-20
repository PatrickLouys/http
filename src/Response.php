<?php

namespace Http;

interface Response
{
    public function getVersion();
    public function setStatusCode($statusCode);
    public function getStatusCode();
    public function getStatusText();
    public function getHeaders();
    public function getCookies();
    public function setContent($content);
    public function getContent();
    public function redirect($url);
}