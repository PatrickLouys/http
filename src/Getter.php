<?php

namespace Http;

interface Getter
{
    public function get($key);
    public function has($key);
}