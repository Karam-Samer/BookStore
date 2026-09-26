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

    public static function updateUser(string $column, string $value)
    {

        $DB = Database::getConnection();

        $userId = auth("id");
        if ($column === 'password') {
            $value = password_hash($value, PASSWORD_DEFAULT);
        }

        $stmt = $DB->prepare("UPDATE users SET {$column} = :value WHERE id = :id");
        $stmt->execute([
            ':value' => $value,
            ':id' => $userId
        ]);
    }
}
