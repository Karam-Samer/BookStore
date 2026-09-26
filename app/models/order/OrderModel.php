<?php

require_once __DIR__ . '/../Model.php';

class OrderModel extends Model
{
    public static function getDataOfOrders(array $wheres = [], int $page = 1)
    {
        $DB = Database::getConnection();

        $whereQuery = self::prepareWhereQuery($wheres);

        $offset = ($page - 1) * 10;

        $stmt = $DB->prepare("SELECT
                              orders.*,
                              users.name as customer_name
                              FROM orders
                              LEFT JOIN users ON orders.customer_id = users.id
                              {$whereQuery}
                              ORDER BY id DESC 
                              LIMIT 10 offset {$offset} ");
        $stmt->execute();

        $data = $stmt->fetchAll();

        $stmt = $DB->prepare("SELECT COUNT(*) as total
                              FROM orders
                              LEFT JOIN users ON orders.customer_id = users.id
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
