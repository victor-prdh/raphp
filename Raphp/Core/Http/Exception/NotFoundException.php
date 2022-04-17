<?php

namespace VictorPrdh\Raphp\Core\Http\Exception;

class NotFoundException extends Exception
{
    public function __construct($message = "404 Not found")
    {
        parent::__construct(404, $message);
    }
}
