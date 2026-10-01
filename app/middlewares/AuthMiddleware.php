<?php

require_once __DIR__ . "/Middleware.php";

class AuthMiddleware implements Middleware
{
    public function handle(string ...$roles): void
    {
        if (!isset($_SESSION['user'])) {
            redirect("/auth/login");
        }

        if (empty($roles)) {
            return;
        }

        $userRole = $_SESSION['user']['role'];
        if (!in_array($userRole, $roles)) {
            Response::error("Forbidden", 403);
        }
    }
}
