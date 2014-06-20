<?php

namespace Http;

interface GetSetter extends Getter
{
    public function set($key, $value);
}