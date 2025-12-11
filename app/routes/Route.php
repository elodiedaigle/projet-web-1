<?php

namespace App\Routes;
use App\Providers\View;
class Route {

    private static $routes = [];

    public static function get($url, $controller){
        self::$routes[] = ['url' => $url, 'controller' => $controller, 'method' => 'GET'];
    }

    public static function post($url, $controller){
        self::$routes[] = ['url' => $url, 'controller' => $controller, 'method' => 'POST'];
    }

    public static function dispatch() {

        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $base = BASE;

        if ($base !== '/' && str_starts_with($uri, $base)) {
            $uri = substr($uri, strlen($base));
        }

        $uri = '/' . trim($uri, '/');
        $method = $_SERVER['REQUEST_METHOD'];

        foreach (self::$routes as $route) {

            if ($route['url'] === $uri && $route['method'] === $method) {

                [$controllerName, $methodName] = explode('@', $route['controller']);
                $controllerClass = 'App\\Controllers\\' . $controllerName;

                $controllerInstance = new $controllerClass();

                if (!method_exists($controllerInstance, $methodName)) {
                    http_response_code(404);
                    return View::render('error', ['msg' => 'Méthode introuvable']);
                }

                $queryParams = $_GET ?? [];

                if ($method === 'GET') {
                    return $controllerInstance->$methodName($queryParams);
                }

                if ($method === 'POST') {
                    return $controllerInstance->$methodName($_POST, $_FILES);
                }
            }
        }

        http_response_code(404);
        return View::render('error', ['msg' => 'Page introuvable']);
    }
}
