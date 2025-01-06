<?php
    namespace App\Models;
    use PDO;
    class Database{
        public static function getConnection(){
            $pdo = new PDO("pgsql:host=127.0.0.1;port=5432;dbname=api", "postgres", "1234");
            return $pdo;
        }

    }