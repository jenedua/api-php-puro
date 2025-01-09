<?php
    namespace App\Services;

use App\Http\JWT as HttpJWT;
use App\Models\User;
use App\Utils\Validator;
use Exception;

use PDOException;

class UserServices {

        public static function create(array $data){
            //var_dump($data);
           try {
                $fields = Validator::validate([
                    'name' => $data['name'] ?? '',
                    'email' => $data['email'] ?? '',
                    'password' => $data['password'] ?? ''
                ]);
                $fields['password'] = password_hash($fields['password'], PASSWORD_DEFAULT);

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

        public static function auth(array $data){
            try {
                $fields = Validator::validate([
                    'email' => $data['email'] ?? '',
                    'password' => $data['password'] ?? ''
                ]);

                $user = User::authenticate($fields);

                if(!$user) return ['error' => 'Sorry, we could not authenticate you'];

               // return $user;
                return HttpJWT::generate($user);

            } catch (PDOException $e) {
                return ['error' => $e->getMessage()] ;
                //return ['error' => $e->errorInfo[0]] ;
            }
            catch (Exception $e) {
                return ['error' => $e->getMessage()] ;
             
            }
        }

}