<?php

require_once __DIR__ . '/../Model.php';

class OrderModel extends Model
{
    public static function getDataOfOrders(array $wheres = [], int $page = 1)
    {
        $DB = Database::getConnection();

        $whereQuery = self::prepareWhereQuery($wheres);

        $offset = ($page - 1) * 10;

        $stmt = $DB->query("SELECT
                              orders.*,
                              users.name as customer_name
                              FROM orders
                              LEFT JOIN users ON orders.customer_id = users.id
                              {$whereQuery}
                              ORDER BY id DESC 
                              LIMIT 10 offset {$offset} ");

        $data = $stmt->fetchAll();

        $stmt = $DB->query("SELECT COUNT(*) as total
                              FROM orders
                              LEFT JOIN users ON orders.customer_id = users.id
                              {$whereQuery}");

        $total = $stmt->fetch();

        return [
            'data' => $data,
            'total' => $total['total'],
            'totalPages' => ceil($total['total'] / 10),
            'currentPage' => $page
        ];
    }

    public static function doneOrder()
    {
        $DB = Database::getConnection();

        $orderId = Request::input('orderId');

        $checkStock = $DB->prepare("SELECT books.stock, orders_items.quantity
                                        FROM orders_items
                                        LEFT JOIN books ON orders_items.book_id = books.id
                                        WHERE orders_items.order_id = :orderId");

        $checkStock->execute(['orderId' => $orderId]);
        $items = $checkStock->fetchAll();



        foreach ($items as $item) {
            if ($item['stock'] < $item['quantity']) {
                Response::json([], 'Insufficient stock for one or more items.', 400);
                return;
            }
        }

        $updateStock = $DB->prepare("UPDATE books
                                LEFT JOIN orders_items
                                ON books.id = orders_items.book_id
                                SET books.stock = books.stock - orders_items.quantity
                                WHERE orders_items.order_id = :orderId");

        $updateStock->execute(['orderId' => $orderId]);

        
        $stmt = $DB->prepare("UPDATE orders SET status = 'done' WHERE id = :orderId");
        $stmt->execute(['orderId' => $orderId]);



        $order = $DB->prepare("SELECT
                                users.name as customer_name,
                                orders.id AS id,
                                orders.total_price,
                                orders.created_at
                                FROM orders
                                LEFT JOIN users ON orders.customer_id = users.id 
                                WHERE
                                orders.id = :orderId"
        );

        $order->execute(['orderId' => $orderId]);
        return $order->fetch();
    }

    public static function cancelOrder()
    {
        $DB = Database::getConnection();

        $orderId = Request::input('orderId');
        $cancelReason = Request::input('cancelReason');

        $stmt = $DB->prepare("UPDATE orders
                                SET status = 'canceled',
                                cancel_reason = :cancelReason
                                WHERE id = :orderId");
        $stmt->execute(['orderId' => $orderId, 'cancelReason' => $cancelReason]);

        $order = $DB->prepare(
            "SELECT
                                users.name as customer_name,
                                orders.id AS id,
                                orders.total_price,
                                orders.created_at
                            FROM orders
                            LEFT JOIN users ON orders.customer_id = users.id 
                            WHERE
                            orders.id = :orderId"
        );
        $order->execute(['orderId' => $orderId]);
        return $order->fetch();
    }
}
