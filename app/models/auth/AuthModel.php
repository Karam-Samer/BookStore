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

    public static function checkIfBanned() : bool
    {
        $DB = Database::getConnection();

        $userId = auth("id");

        $stmt = $DB->prepare("SELECT is_banned FROM users WHERE id = :userId");
        $stmt->execute(['userId' => $userId]);

        return $stmt->fetchColumn();
    }
}
