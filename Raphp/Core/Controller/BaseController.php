<?php

namespace VictorPrdh\Raphp\Core\Controller;

abstract class BaseController
{
    private array $params = [];

    public function __construct()
    {
        if (isset($_SERVER["params"])) {
            $this->params = $_SERVER["params"];
        }
    }

    /**
     * Get the value of params
     */
    public function getParams()
    {
        return $this->params;
    }
}
