<?php

require_once __DIR__ . '/../Model.php';

class BookModel extends Model
{
    public static function getDataOfBooks(array $wheres = [], int $page = 1)
    {
        $DB = Database::getConnection();

        $whereQuery = self::prepareWhereQuery($wheres);

        $offset = ($page - 1) * 10;

        $stmt = $DB->prepare("SELECT
                              books.*,
                              authors.name as author_name
                              FROM books
                              LEFT JOIN authors ON books.author_id = authors.id
                              {$whereQuery}
                              ORDER BY id DESC 
                              LIMIT 10 offset {$offset} ");
        $stmt->execute();

        $data = $stmt->fetchAll();

        $stmt = $DB->prepare("SELECT COUNT(*) as total
                              FROM books
                              LEFT JOIN authors ON books.author_id = authors.id
                              {$whereQuery}");
        $stmt->execute();

        $total = $stmt->fetch();

        return [
            'data' => $data,
            'total' => $total['total'],
            'totalPages' => ceil($total['total'] / 10),
            'currentPage' => $page
        ];
    }
}
