<?php

require_once __DIR__ . '/../Model.php';

class UserModel extends Model
{
    public static function createUser()
    {

        $DB = Database::getConnection();

        $data = Request::all();

        $hashPass = password_hash($data['password'], PASSWORD_DEFAULT);

        $stmt = $DB->prepare("INSERT INTO users 
                    (role, name, email, password, phone, gender) 
                    VALUES
                    (:role, :name, :email, :password, :phone, :gender)");

        $stmt->execute([
            ':role' => $data['role'],
            ':name' => $data['name'],
            ':email' => $data['email'],
            ':password' => $hashPass,
            ':phone' => $data['phone'],
            ':gender' => $data['gender']
        ]);
    }
}
