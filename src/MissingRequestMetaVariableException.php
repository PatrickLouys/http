<?php

namespace Http;

class MissingRequestMetaVariableException extends \Exception
{
    public function __construct($variableName, $code = 0, \Exception $previous = null) {
        $message = "Request meta-variable $variableName was not set.";

        parent::__construct($message, $code, $previous);
    }
}
