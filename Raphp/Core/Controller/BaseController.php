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

    /**
     * Return json to client
     */
    public function json(array $response)
    {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($response);
    }
}
