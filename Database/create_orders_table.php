<?php

require_once __DIR__ . '/../core/Database.php';

class create_orders_table
{
    public static function up()
    {
        $DB = Database::getConnection();
        $DB->exec("CREATE TABLE IF NOT EXISTS orders (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            customer_id BIGINT UNSIGNED NOT NULL,
            CONSTRAINT fk_customer_id FOREIGN KEY (customer_id) REFERENCES users(id),
            status ENUM('pending', 'ordered', 'cancelled', 'done') NOT NULL DEFAULT 'pending',
            cancel_reason TEXT NULL,
            total_price DECIMAL(10, 2) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
    }

    public static function down()
    {
        $DB = Database::getConnection();
        $DB->exec("DROP TABLE IF EXISTS orders");
    }
}
