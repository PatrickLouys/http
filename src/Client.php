<?php

namespace Http;

interface Client
{
    public function getReferer();
    public function getUserAgent();
    public function getIpAddress();
}