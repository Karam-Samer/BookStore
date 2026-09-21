<?php

class App
{
    public static function run()
    {
        session_start();

        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $type = str_starts_with($url, BASE_URL . "/api") ? "api" : "web";

        if ($type === "api") {
            header("Content-Type: application/json; charset=UTF-8");
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
            header("Access-Control-Allow-Headers: Content-Type, Authorization");
        }


        require_once __DIR__ . "/../app/helpers/Helpers.php";
        require_once __DIR__ . "/Response.php";
        require_once __DIR__ . "/../routes/{$type}.php";
        require_once __DIR__ . "/Route.php";
        require_once __DIR__ . "/Request.php";

        $_SESSION['user'] = [];

        Route::dispatch();
    }
}
