<?php

require_once __DIR__ . '/../Model.php';

class AdminModel extends Model
{
    public static function banUser()
    {

        $userId = Request::input('userId');

        $DB = Database::getConnection();

        $stmt = $DB->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute([':id' => $userId]);
        $user = $stmt->fetch();


        if ($user['role'] == 'admin' && auth("id") > $user['id']) {
            Response::json([], 'You cannot ban this admin', 422);
        }

        $oldStatus = $user['is_banned'];

        $stmt = $DB->prepare("UPDATE users SET is_banned = :is_banned WHERE id = :id");
        $stmt->execute([
            ':is_banned' => !$oldStatus,
            ':id' => $userId
        ]);
    }
}
