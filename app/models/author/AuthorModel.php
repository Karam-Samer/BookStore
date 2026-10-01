<?php

require_once __DIR__ . '/../Model.php';

class AuthorModel extends Model
{
    public static function addAuthor(): int
    {
        $DB = Database::getConnection();

        $stmt = $DB->prepare("INSERT INTO authors
                              (name, bio)
                              VALUES
                              (:name, :bio)
                              ");
        $stmt->execute([
            'name' => Request::input('authorName'),
            'bio' => Request::input('authorBio')
        ]);

        return $DB->lastInsertId();
    }
}
