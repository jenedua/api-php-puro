<?php
    namespace App\Services;

use App\Models\User;
use App\Utils\Validator;
use Exception;
use PDOException;

    class UserServices {

        public static function create(array $data){
            var_dump($data);
           try {
                $fields = Validator::validate([
                    'name' => $data['name'] ?? '',
                    'email' => $data['email'] ?? '',
                    'password' => $data['password'] ?? ''
                ]);

                $user  = User::save($fields);   

                if(!$user) return ['error' => 'Sorry, user not created'];

                return "User created successfully";

           } 
           catch (PDOException $e) {
               return ['error' => $e->getMessage()] ;
               //return ['error' => $e->errorInfo[0]] ;
           }
           catch (Exception $e) {
               return ['error' => $e->getMessage()] ;
            
           }
        }

    }