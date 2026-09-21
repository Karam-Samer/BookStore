<?php

require_once __DIR__ . '/../core/Database.php';

class create_users_table
{
    public static function up()
    {
        $DB = Database::getConnection();
        $DB->exec("CREATE TABLE IF NOT EXISTS users (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            phone VARCHAR(255) NOT NULL UNIQUE,
            is_banned BOOLEAN NOT NULL DEFAULT FALSE,
            gender ENUM('male', 'female') NOT NULL,
            role ENUM('admin', 'customer') NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
    }

    public static function down()
    {
        $DB = Database::getConnection();
        $DB->exec("DROP TABLE IF EXISTS users");
    }
}
