<?php

namespace Http;

interface Request
{
    public function getParameter($key, $defaultValue = null);
    public function getFile($key, $defaultValue = null);
    public function getCookie($key, $defaultValue = null);
    public function getParameterIterator();
    public function getCookieIterator();
    public function getFileIterator();
    public function getMethod();
    public function getHttpAccept();
    public function getReferer();
    public function getUserAgent();
    public function getIpAddress();
    public function isSecure();
    public function getQueryString();
}