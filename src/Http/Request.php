<?php
    namespace App\Http;
    class Request{
        public static function uri(){
            return trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        }
        public static function method(){
            return $_SERVER['REQUEST_METHOD'];
        }
        public static function body(){
            $json = json_decode(file_get_contents('php://input'), true) ?? [];
            $data = match(self::method()){
                'GET' => $_GET,
                'POST' => $json,
                'PUT' => $json,
                'DELETE' => $json,
                default => []
            };
            return $data;
        }   

    }