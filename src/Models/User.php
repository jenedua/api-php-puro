<?php
    namespace App\Models;
    use App\Models\Database;
    class User extends Database{
        public static function save(array $data){
            $pdo = self::getConnection();
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");

            // $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
            // $stmt = $pdo->prepare($sql);
            $stmt->execute([
                 $data['name'],
                 $data['email'],
                 $data['password']
            ]);
           
            return $pdo->lastInsertId() > 0 ? true : false;
        }

    }