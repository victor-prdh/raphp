<?php

namespace VictorPrdh\Raphp\Core\Http;

use VictorPrdh\Raphp\Core\Router\Router;

class Server
{
    /**
     * Path for the config folder
     */
    public static $configFolderPath;

    public function __construct($configFolderPath)
    {
        self::$configFolderPath = $configFolderPath;
        new Router();
    }

    static function NotFoundException()
    {
        header('HTTP/1.0 404 Not Found');
        echo "<h1>404 Not Found</h1>";
        exit;
    }

    static function NotImplementedException()
    {
        header('HTTP/1.0 501 Not Implemented');
        echo "<h1>501 Not Implemented</h1>";
        exit;
    }

    /**
     * Get path for the config folder
     */
    public function getConfigFolderPath()
    {
        return self::$configFolderPath;
    }

    /**
     * Set path for the config folder
     *
     * @return  self
     */
    public function setConfigFolderPath($configFolderPath)
    {
        $this->configFolderPath = $configFolderPath;

        return $this;
    }
}
