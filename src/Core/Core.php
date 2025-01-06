<?php
namespace App\Core;
use App\Http\Request;
use App\Http\Response;

Class Core
{
    // public static function dispatch(array $routes)
    // {
    //     // Captura a URL corretamente independente do método HTTP
    //     $url = $_SERVER['REQUEST_URI'] ?? '/';
    //     $url = parse_url($url, PHP_URL_PATH); // Remove query string da URL
    //     $url = rtrim($url, '/'); // Remove barra no final
    
    //     $prefixController = 'App\\Controllers\\';
    //     $routeFound = false;
    
    //     foreach ($routes as $route) {
    //         // Converte parâmetros dinâmicos da rota para regex
    //         $pattern = '#^' . preg_replace('/{([\w-]+)}/', '([\w-]+)', $route['path']) . '$#';
    
    //         if (preg_match($pattern, $url, $matches)) {
    //             array_shift($matches);
    //             $routeFound = true;
    
    //             // Verifica o método HTTP corretamente
    //             if (strtoupper($route['method']) !== $_SERVER['REQUEST_METHOD']) {
    //                 Response::json([
    //                     'error' => true,
    //                     'success' => false,
    //                     'message' => 'Sorry, method not allowed'
    //                 ], 405);
    //                 return;
    //             }
    
    //             [$controller, $action] = explode('@', $route['action']);
    //             $controller = $prefixController . $controller;
    
    //             if (!class_exists($controller)) {
    //                 Response::json([
    //                     'error' => true,
    //                     'success' => false,
    //                     'message' => "Controller '{$controller}' not found"
    //                 ], 500);
    //                 return;
    //             }
    
    //             $extendController = new $controller();
    //             if (!method_exists($extendController, $action)) {
    //                 Response::json([
    //                     'error' => true,
    //                     'success' => false,
    //                     'message' => "Method '{$action}' not found in controller '{$controller}'"
    //                 ], 500);
    //                 return;
    //             }
    
    //             $extendController->$action(new Request(), new Response(), ...$matches);
    //             return;
    //         }
    //     }
    
    //     if (!$routeFound) {
    //         Response::json([
    //             'error' => true,
    //             'success' => false,
    //             'message' => 'Route not found'
    //         ], 404);
    //     }
    // }
    

    public static function dispatch(array $routes){
        $url = '/';
        isset($_GET['url']) && $url .= $_GET['url'];
        $url !== '/' && $url = rtrim($url, '/');
        $prefixController = 'App\\Controllers\\';
        $routeNotFound = false;

        foreach($routes as $route){
            $pattern = '#^' . preg_replace('/{id}/', '([\w-]+)', $route['path']) . '$#';
           // $pattern = '#^'. preg_replace('/{([\w-]+)}/', '([\w-]+)', $route['path']) .'$#';
            if(preg_match($pattern, $url, $matches)){
                array_shift($matches);
                $routeNotFound = true;
                if($route['method'] != Request::method()){
                    Response::json([
                        'error' => true,
                        'success' => false,
                        'message' => 'Sorry, method not allowed'

                    ], 405);
                    return;
                }

                [$controller, $action] = explode('@', $route['action']);

                $controller = $prefixController . $controller;
                $extendController = new $controller();
                $extendController->$action(new Request(), new Response(), ...$matches);

                return;

            }
        }
        if(!$routeNotFound){
            $controller = $prefixController . 'NotFoundController';
            $extendController = new $controller();
            $extendController->index(new Request(), new Response());
        }


    }
}