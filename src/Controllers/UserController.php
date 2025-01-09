<?php
    namespace App\Controllers;
    use App\Http\Request;
    use App\Http\Response;
use App\Services\UserServices;

    class UserController{
        public function store(Request $request, Response $response){
           // var_dump($request::body());
            $body = $request::body();
             $userServices = UserServices::create($body);

            if(isset($userServices['error'])){
                return $response::json([
                    'error' => true,
                    'success' => false,
                    'message' => $userServices['error']
                ], 400);
            }  
            $response::json([
                'error' => false,
                'success' => true,
                'data' => $userServices,
            ], 201);
            
        }
        public function login(Request $request, Response $response){
            $body = $request::body();
            $userServices = UserServices::auth($body);

            if(isset($userServices['error'])){
                return $response::json([
                    'error' => true,
                    'success' => false,
                    'message' => $userServices['error']
                ], 400);
            }
            $response::json([
                'error' => false,
                'success' => true,
                'jwt' => $userServices,
            ], 200);

        }
        
        public function fetch(Request $request, Response $response){

        }
        public function update(Request $request, Response $response){

        }
        public function remove(Request $request, Response $response){

        }

    }