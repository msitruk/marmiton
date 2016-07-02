<?php

namespace App\Router;
require_once dirname(__FILE__)."/Route.php";

class Router{

    private $url;
    private $routes = [];
    private $nameRoutes = [];
    public function __construct($url)
    {
        $this->url = $url;
    }
    public function get($path, $callable, $name = null)
    {
        return $this->add($path, $callable, $name, "GET");
    }
    public function post($path, $callable, $name = null)
    {
        return $this->add($path, $callable, $name, "POST");
    }
    private function add($path, $callable, $name, $method)
    {
        $route = new Route($path, $callable);
        $this->routes[$method][] = $route;
        if (is_string($callable) && $name === null){
            $name = $callable;
        }
        if ($name){
            $this->nameRoutes[$name] = $route;
        }
        return $route;
    }
    public function run()
    {
        if (!isset($this->routes[$_SERVER['REQUEST_METHOD']])) {
            throw new RouterException('REQUEST METHOD does not exist');
        }
        foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route){
            if($route->match($this->url)){
                return $route->call();
            }
        }
        throw new RouterException('No routes matches');
    }
    public function url ($name, $params = [])
    {
        if (!isset($this ->nameRoutes[$name])){
            throw new RouterException('No route matches this name');
        }
        return $this ->nameRoutes[$name]->getUrl($params);
    }

}
