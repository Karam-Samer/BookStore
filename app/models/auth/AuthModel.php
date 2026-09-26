<?php

require_once __DIR__ . '/../Model.php';

class AuthModel extends Model
{
    public static function login(): bool
    {

        $DB = Database::getConnection();

        $data = Request::all();

        $stmt = $DB->query("SELECT * FROM users WHERE email = '{$data['email']}'");
        $user = $stmt->fetch();
        if (!empty($user) && password_verify($data['password'], $user['password'])) {
            $_SESSION['user'] = $user;
            return true;
        }
        return false;
    }
}
