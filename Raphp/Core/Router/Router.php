<?php

namespace VictorPrdh\Raphp\Core\Router;

use VictorPrdh\Raphp\Core\Http\Server;

class Router
{

    private string $currentUrl;
    private array $routes = [];

    public function __construct()
    {
        if (!isset($_SERVER['PATH_INFO'])) {
            $this->currentUrl = "/";
        } else {
            $this->currentUrl = $_SERVER['PATH_INFO'];
        }

        $this->defineRoute();

        //var_dump($this->routes);

        $this->match();
    }



    /**
     * Get the value of currentUrl
     */
    public function getCurrentUrl()
    {
        return $this->currentUrl;
    }

    /**
     * Set the value of currentUrl
     *
     * @return  self
     */
    public function setCurrentUrl($currentUrl)
    {
        $this->currentUrl = $currentUrl;

        return $this;
    }

    /**
     * Get the value of routes
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * Add new route 
     *
     * @return  self
     */
    public function addRoutes(Route $route)
    {
        $this->routes[] = $route;
        return $this;
    }



    /**
     * Define the route for the app
     */
    public function defineRoute()
    {
        $yaml = file_get_contents(Server::$configFolderPath . '/routes.yaml');

        $data = htmlspecialchars($yaml);
        $data = explode("\n", $data);

        $i = 0;
        $newRoute = new Route();
        foreach ($data as $value) {

            $infoRoute = explode(":", $value, 2);

            if (isset($infoRoute[1])) {
                $i++;
            }

            $infoRoute[0] = trim($infoRoute[0]);


            if ($infoRoute[0] == "path") {
                $newRoute->setUrl(trim($infoRoute[1]));
            } elseif ($infoRoute[0] == "controller") {
                $newRoute->setController(trim($infoRoute[1]));
            } else {
                $newRoute->setName(trim($infoRoute[0]));
            }

            if (($i % 3) === 0) {
                $this->addRoutes($newRoute);
                $newRoute = new Route();
            }
        }
    }


    /**
     * Match the current route with defined route
     */
    public function match()
    {
        $currentUrlArray = explode("/", $this->getCurrentUrl());
        $currentUrlLength = count($currentUrlArray);



        foreach ($this->getRoutes() as $route) {
            $urlArray = explode("/", $route->getUrl());
            $urlLength = count($urlArray);

            if ($route->getUrl() == $this->getCurrentUrl()) {
                $this->callController($route->getController());
                return;
            }
        }

        foreach ($this->getRoutes() as $route) {
            $urlArray = explode("/", $route->getUrl());
            $urlLength = count($urlArray);

            if ($currentUrlLength === $urlLength) {
                $i = 0;
                foreach ($urlArray as $value) {
                    if (str_contains($value, "{")) {
                        $paramName = substr($value, 1, -1);
                        $_SERVER[$paramName] = $currentUrlArray[$i];
                    } elseif ($value !== $currentUrlArray[$i]) {
                        Server::NotFoundException();
                        return;
                    }

                    $i++;
                }
                $this->callController($route->getController());
                return;
            }
        }

        Server::NotFoundException();
        return;
    }

    /**
     * @param string $controller Controller namespace and methode from route.yaml 
     */
    public function callController(string $controller)
    {
        $data = explode(":", $controller);
        $class = $data[0];
        $method = $data[2];


        $controller = new $class();

        if (!method_exists($controller, $method)) return Server::NotImplementedException();

        $controller->$method();
        return;
    }
}
