<?php
    namespace App\Utils;    
    class Validator{
        public static function validate(array $fields){
            foreach($fields as $key => $value){
                if(empty(trim($value))){
                    throw new \Exception("They key {$key} is required");
                }
            }
            return $fields;
        }

    }