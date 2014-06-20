<?php

namespace Http;

interface Request
{
    public function get($key, $defaultValue = null);
    public function post($key, $defaultValue = null);
    public function server($key, $defaultValue = null);
    public function files($key, $defaultValue = null);
    public function cookie($key, $defaultValue = null);
    public function getIterator();
    public function postIterator();
    public function serverIterator();
    public function filesIterator();
    public function cookieIterator();
    public function getMethod();
}