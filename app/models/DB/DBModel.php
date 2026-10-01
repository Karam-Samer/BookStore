<?php

require_once __DIR__ . '/../Model.php';

class DBModel extends Model
{
    public static function getTotalOfTable(string $tableName, array $wheres = []): int
    {

        $DB = Database::getConnection();
        $whereQuery = self::prepareWhereQuery($wheres);
        $stmt = $DB->query("SELECT COUNT(*) as total FROM {$tableName} {$whereQuery}");
        $result = $stmt->fetch();

        return $result['total'];
    }

    public static function getDataOfTable(string $tableName, array $wheres = [], int $page = 1): array
    {
        $DB = Database::getConnection();

        $whereQuery = self::prepareWhereQuery($wheres);

        $offset = ($page - 1) * 10;

        $stmt = $DB->query("SELECT * FROM {$tableName} {$whereQuery} ORDER BY id DESC LIMIT 10 offset {$offset}");

        $data = $stmt->fetchAll();

        $stmt = $DB->query("SELECT COUNT(*) as total FROM {$tableName} {$whereQuery}");

        $total = $stmt->fetch();

        return [
            'data' => $data,
            'total' => $total['total'],
            'totalPages' => ceil($total['total'] / 10),
            'currentPage' => $page
        ];
    }

    public static function getTotalOfCustomerBooks(): int
    {

        $DB = Database::getConnection();
        $id = auth('id');
        $stmt = $DB->query("SELECT SUM(orders_items.quantity) AS total
                            FROM orders_items
                            LEFT JOIN orders
                            ON orders_items.order_id = orders.id
                            WHERE
                            orders.customer_id = {$id}
                            AND 
                            orders.status = 'done'");
        $result = $stmt->fetch();

        return $result['total'] ?? 0;
    }
}
