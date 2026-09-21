<?php

require_once __DIR__ . '/../core/Database.php';

class create_api_tokens_table
{
    public static function up()
    {
        $DB = Database::getConnection();
        $DB->exec("CREATE TABLE IF NOT EXISTS api_tokens (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id BIGINT UNSIGNED NOT NULL,
            CONSTRAINT fk_user_id FOREIGN KEY (user_id) REFERENCES users(id),
            token VARCHAR(255) NOT NULL,
            expires_at TIMESTAMP,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
    }

    public static function down()
    {
        $DB = Database::getConnection();
        $DB->exec("DROP TABLE IF EXISTS api_tokens");
    }
}
