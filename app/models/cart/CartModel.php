<?php

require_once __DIR__ . '/../Model.php';

class CartModel extends Model
{
    public static function addToCart(int $bookId, int $quantity)
    {
        $DB = Database::getConnection();
        $customerId = auth('id');

        $pendingOrderId = self::getPendingOrderItems();

        if (!$pendingOrderId) {
            $DB->exec("INSERT INTO orders
                    (customer_id, status)
                    VALUES
                    ({$customerId}, 'pending')");

            $pendingOrderId = $DB->lastInsertId();
        }

        $unitPrice = $DB->query(
            "SELECT price FROM books WHERE id = {$bookId}"
        )->fetchColumn();

        $subtotal = (float) $unitPrice * $quantity;

        $orderItemId = self::getOrderItemId($pendingOrderId, $bookId);

        if ($orderItemId) {

            $stmt = $DB->prepare("SELECT quantity FROM orders_items WHERE id = :orderItemId");
            $stmt->execute(['orderItemId' => $orderItemId]);
            $currentQuantity = $stmt->fetchColumn();
            $newQuantity = $currentQuantity + $quantity;
            if (!self::checkStock($bookId, $newQuantity)) {
                Response::json([], "Total quantity exceeds available stock", 400);
            }

            $stmt = $DB->prepare("UPDATE orders_items
                                    SET
                                        quantity = quantity + :quantity,
                                        subtotal = subtotal + (:quantity * :unit_price)
                                    WHERE id = :id
        ");

            $stmt->execute([
                'quantity'   => $quantity,
                'unit_price' => $unitPrice,
                'id'         => $orderItemId,
            ]);
        } else {

            $stmt = $DB->prepare("
            INSERT INTO orders_items
                (order_id, book_id, quantity, unit_price, subtotal)
            VALUES
                (:order_id, :book_id, :quantity, :unit_price, :subtotal)
        ");

            $stmt->execute([
                'order_id'   => $pendingOrderId,
                'book_id'    => $bookId,
                'quantity'   => $quantity,
                'unit_price' => $unitPrice,
                'subtotal'   => $subtotal,
            ]);
        }

        self::updateTotalPrice($pendingOrderId);

        $totalItems = self::totalItemsInCart();

        return ["totalItems" => $totalItems];
    }

    public static function getPendingOrderItems(): false | int
    {
        $DB         = Database::getConnection();
        $customerId = auth('id');
        $stmt       = $DB->query("SELECT id
                            FROM orders
                            WHERE customer_id = {$customerId}
                            AND status = 'pending'");

        $result = $stmt->fetchColumn();
        return $result ?? false;
    }

    public static function getOrderItemId(int $orderId, int $bookId): false | int
    {
        $DB   = Database::getConnection();
        $stmt = $DB->query("SELECT id
                            FROM orders_items
                            WHERE order_id = {$orderId}
                            AND book_id = {$bookId}");

        $result = $stmt->fetchColumn();
        return $result ?? false;
    }

    public static function updateTotalPrice(int $orderId)
    {

        $DB   = Database::getConnection();
        $stmt = $DB->query("SELECT SUM(subtotal) AS total_price
                            FROM orders_items
                            WHERE order_id = {$orderId}");

        $totalPrice = $stmt->fetchColumn() ?? 0;


        $DB->exec("UPDATE orders
                    SET total_price = {$totalPrice}
                    WHERE id = {$orderId}");

        return $totalPrice;
    }

    public static function totalItemsInCart(): int
    {
        $DB = Database::getConnection();
        $orderId = self::getPendingOrderItems();

        if (!$orderId) {
            return 0;
        }
        $stmt = $DB->query("SELECT COUNT(*) AS total_items
                            FROM orders_items
                            WHERE order_id = {$orderId}")->fetchColumn();

        return $stmt ?? 0;
    }

    public static function checkStock(int $bookId, int $quantity): bool
    {
        $DB    = Database::getConnection();
        $stmt  = $DB->query("SELECT stock FROM books WHERE id = {$bookId}");
        $stock = (int) $stmt->fetchColumn();

        return $stock >= $quantity;
    }

    public static function getCartItems(?int $orderId = null): array
    {
        $DB = Database::getConnection();

        if ($orderId === null) {
            $orderId = self::getPendingOrderItems();
        }

        $stmt = $DB->prepare("SELECT
                                books.id AS book_id,
                                books.title,
                                books.price,
                                books.image,
                                books.description,
                                books.stock,
                                authors.id AS author_id,
                                authors.name,
                                orders.id AS order_id,
                                orders.total_price,
                                orders_items.id AS order_item_id,
                                orders_items.quantity,
                                orders_items.subtotal
                            FROM orders_items
                            LEFT JOIN books ON orders_items.book_id = books.id
                            LEFT JOIN authors ON books.author_id = authors.id
                            LEFT JOIN orders ON orders_items.order_id = orders.id
                            WHERE
                            orders.id = :orderId");

        $stmt->execute(['orderId' => $orderId]);
        return $stmt->fetchAll();
    }

    public static function updateQuantity()
    {
        $DB = Database::getConnection();

        $stmt = $DB->prepare("UPDATE orders_items
                                SET quantity = :quantity,
                                subtotal = :quantity * unit_price
                                WHERE id = :orderItemId");

        $stmt->execute([
            'quantity' => Request::input('quantity'),
            'orderItemId' => Request::input('orderItemId')
        ]);

        $stmt = $DB->prepare("SELECT quantity, subtotal
                                FROM orders_items
                                WHERE id = :orderItemId");

        $stmt->execute([
            'orderItemId' => Request::input('orderItemId')
        ]);

        $orderItem = $stmt->fetch();

        $orderID = self::getPendingOrderItems();
        $totalPrice = self::updateTotalPrice($orderID);

        $totalItems = self::totalItemsInCart();

        return ["totalPrice" => $totalPrice, "orderItem" => $orderItem, "totalItems" => $totalItems];
    }

    public static function removeFromCart()
    {
        $DB = Database::getConnection();
        $orderItemId = Request::input('orderItemId');
        $orderId = self::getPendingOrderItems();

        $stmt = $DB->prepare("DELETE FROM orders_items
                                WHERE id = :orderItemId");
        $stmt->execute(['orderItemId' => $orderItemId]);

        $totalItems = self::totalItemsInCart();

        $totalPrice = self::updateTotalPrice($orderId);

        /* if ($totalItems == 0) {
             $stmt = $DB->prepare("DELETE FROM orders
                                 WHERE id = :orderId");
             $stmt->execute(['orderId' => $orderId]);
         }*/


        return ["totalPrice" => $totalPrice, "totalItems" => $totalItems, "orderItem" => ["quantity" => 0, "subtotal" => 0]];
    }

    public static function fireOrder()
    {
        $DB = Database::getConnection();
        $orderId = Request::input('orderId');

        $stmt = $DB->prepare("UPDATE orders
                                SET status = 'ordered'
                                WHERE id = :orderId");

        $stmt->execute(['orderId' => $orderId]);

        $order = $DB->prepare("SELECT
                                users.name as customer_name,
                                orders.id AS id,
                                orders.total_price,
                                orders.created_at
                            FROM orders
                            LEFT JOIN users ON orders.customer_id = users.id 
                            WHERE
                            orders.id = :orderId");

        $order->execute(['orderId' => $orderId]);
        return $order->fetchAll();
    }
}
