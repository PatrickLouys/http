<?php

namespace Http;

use Storage\ImmutableKeyValue;

class RequestBuilder
{
    public function buildFromSuperglobals()
    {
        $parameters = array_merge($_GET, $_POST);

        return new HttpRequest(
            new ImmutableKeyValue($parameters),
            new ImmutableKeyValue($_COOKIE),
            new ImmutableKeyValue($_FILES),
            new ImmutableKeyValue($_SERVER)
        );
    }
}