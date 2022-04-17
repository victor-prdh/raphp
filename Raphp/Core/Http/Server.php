<?php

namespace VictorPrdh\Raphp\Core\Http;

use VictorPrdh\Raphp\Core\Router\Router;

class Server
{
    /**
     * Path for the config folder
     */
    private static $configFolderPath;

    public function __construct($configFolderPath)
    {
        self::$configFolderPath = $configFolderPath;
        new Router();
    }

    /**
     * Get path for the config folder
     */
    public static function getConfigFolderPath()
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
