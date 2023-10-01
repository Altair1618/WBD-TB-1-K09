<?php

class Router {
    private $routes;
    private static $instance;

    public function __construct($routes) {
        $this->routes = $routes;
    }

    public static function getInstance() {
        if (!isset(self::$instance)) {
            require_once APP_DIR . 'routes/web.php';
            self::$instance = new Router($routes);
        }

        return self::$instance;
    }

    public function match($uri, $route) {
        $temp = explode("?", $uri);
        $uri = $temp[0];

        $parsedUri = explode("/", trim($uri, "/"));
        $parsedRoute = explode("/", trim($route, "/"));

        if (count($parsedUri) != count($parsedRoute)) {
            return [false, null];
        }
        
        $params = [];
        for ($i = 0; $i < count($parsedRoute); $i++) {
            if ($parsedRoute[$i] == $parsedUri[$i]) {
                continue;
            } else if (substr($parsedRoute[$i], 0, 1) == ":") {
                $params[substr($parsedRoute[$i], 1)] = urldecode($parsedUri[$i]);
                continue;
            } else {
                return [false, null];
            }
        }

        if (count($temp) > 1) {
            $queries = explode("&", $temp[1]);
            foreach ($queries as $query) {
                $query = explode("=", $query);
                $params[$query[0]] = urldecode($query[1]);
            }
        }

        return [true, $params];
    }

    public function routing($uri, $method) {
        foreach ($this->routes as $key => $value) {
            $match = $this->match($uri, $key);
            
            if ($match[0]) {
                if (!isset($value[$method])) {
                    return [['route' => "ErrorController@showErrorPage"], ["errorCode" => 405]];
                }

                $result = $value[$method];
                $params = $match[1];
                return [$result, $params];
            }
        }

        return [['route' => "ErrorController@showErrorPage"], ["errorCode" => 404]];
    }

    public function run() {
        $uri = $_SERVER["REQUEST_URI"];
        $method = $_SERVER["REQUEST_METHOD"];

        $route = $this->routing($uri, $method);
        $result = $route[0];
        $params = $route[1];

        if (isset($result["middlewares"])) {
            foreach ($result["middlewares"] as $middleware) {
                require_once MIDDLEWARES_DIR . $middleware . ".php";

                $middleware = new $middleware();
                $middleware->handle($params);
            }
        }

        $temp = explode("@", $result["route"]);
        $controllerName = $temp[0];
        $controllerMethod = $temp[1];

        require_once CONTROLLERS_DIR . $controllerName . ".php";
        $controller = new $controllerName();
        $controller->$controllerMethod($params);
    }
}