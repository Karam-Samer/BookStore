<?php

require_once __DIR__ . '/../Model.php';

class AuthModel extends Model
{
    public static function login(): array
    {

        $DB = Database::getConnection();

        $data = Request::all();

        $stmt = $DB->query("SELECT * FROM users WHERE email = '{$data['email']}'");
        $user = $stmt->fetch();

        if ($user['is_banned']) {
            return ["error" => "User is banned"];
        }

        if (!empty($user) && password_verify($data['password'], $user['password'])) {
            return $user;
        }
        return ["error" => "Wrong email or password"];
    }
}
