<?php

namespace App\Routes;
use App\Providers\View;
class Route {

    /* 
    ================
    Liste des routes
    ================
    */

    private static $routes = [];

    /* 
    =======================
    GET : Afficher une page
    =======================
    */

    public static function get($url, $controller){
        self::$routes[] = ['url' => $url, 'controller' => $controller, 'method' => 'GET'];
    }

    /* 
    ==============================
    POST : Soumettre un formulaire
    ==============================
    */

    public static function post($url, $controller){
        self::$routes[] = ['url' => $url, 'controller' => $controller, 'method' => 'POST'];
    }

    /* 
    ================================================
    DISPATCH : Trouver et exécuter la route demandée
    ================================================
    */

    public static function dispatch() {

        // URI de base
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $base = BASE;

        // Enlever le "base"
        if ($base !== '/' && str_starts_with($uri, $base)) {
            $uri = substr($uri, strlen($base));
        }

        // Normaliser l'URI
        $uri = '/' . trim($uri, '/');
        $method = $_SERVER['REQUEST_METHOD'];

        // Parcourir toutes les routes enregistrées
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

        // Si aucune route ne correspond
        http_response_code(404);
        return View::render('error', ['msg' => 'Page introuvable']);
    }
}
