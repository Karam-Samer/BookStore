<?php

require_once __DIR__ . "/../core/Route.php";
require_once __DIR__ . "/../app/controllers/web/HomeController.php";
require_once __DIR__ . "/../app/controllers/web/auth/LoginController.php";
require_once __DIR__ . "/../app/controllers/web/auth/RegisterController.php";
require_once __DIR__ . "/../app/controllers/web/profile/ProfileController.php";



Route::get("/", HomeController::class, "index");

Route::get("/auth/login", LoginController::class, "index");
Route::post("/auth/login", LoginController::class, "login");

Route::get("/auth/register", RegisterController::class, "index");
Route::post("/auth/register", RegisterController::class, "register");
Route::get("/profile", ProfileController::class, "index");
