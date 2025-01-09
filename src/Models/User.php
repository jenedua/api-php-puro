<?php
    namespace App\Models;
    use App\Models\Database;
    use PDO;

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
        public static function authenticate(array $data){
            $pdo = self::getConnection();
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$data['email']]);

            if($stmt->rowCount() < 1) return false;

            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if(!password_verify($data['password'], $user['password'])){
                return false;
            }
            return [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email']
            ];
            // $user = $stmt->fetch();

            // //if(!$user) return false;


            // if(password_verify($data['password'], $user['password'])){
            //     return $user;
            // }
            // return false;
        }

        public static function find(int|string $id){
            $pdo = self::getConnection();
            $stmt = $pdo->prepare("SELECT id, name, email FROM users WHERE id = ?");
            $stmt->execute([$id]);

            if($stmt->rowCount() < 1) return false;

            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

    }