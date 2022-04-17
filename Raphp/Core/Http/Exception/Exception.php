<?php

namespace VictorPrdh\Raphp\Core\Http\Exception;

class Exception
{
    public function __construct($statusCode = 0, $message = '')
    {
        http_response_code($statusCode);
        echo "<h1>" . $message . "</h1>";
        die;
    }
}
