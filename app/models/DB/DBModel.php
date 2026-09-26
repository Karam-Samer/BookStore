<?php

require_once __DIR__ . '/../Model.php';

class DBModel extends Model
{
    public static function getTotalOfTable(string $tableName, array $wheres = []): int
    {

        $DB = Database::getConnection();
        $whereQuery = self::prepareWhereQuery($wheres);
        $stmt = $DB->prepare("SELECT COUNT(*) as total FROM {$tableName} {$whereQuery}");
        $stmt->execute();
        $result = $stmt->fetch();

        return $result['total'];
    }

    public static function getDataOfTable(string $tableName, array $wheres = [], int $page = 1): array
    {
        $DB = Database::getConnection();

        $whereQuery = self::prepareWhereQuery($wheres);

        $offset = ($page - 1) * 10;

        $stmt = $DB->prepare("SELECT * FROM {$tableName} {$whereQuery} ORDER BY id DESC LIMIT 10 offset {$offset}");
        $stmt->execute();

        $data = $stmt->fetchAll();

        $stmt = $DB->prepare("SELECT COUNT(*) as total FROM {$tableName} {$whereQuery}");
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
