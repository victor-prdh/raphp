<?php

namespace VictorPrdh\Raphp\Core\Http\Exception;

class NotImplementedException extends Exception
{
    public function __construct($message = "502 Not implemented")
    {
        parent::__construct(502, $message);
    }
}
