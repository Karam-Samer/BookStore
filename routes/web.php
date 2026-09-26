<?php

require_once __DIR__ . "/../core/Route.php";
// Controllers
require_once __DIR__ . "/../app/controllers/web/HomeController.php";
require_once __DIR__ . "/../app/controllers/web/profile/ProfileController.php";
require_once __DIR__ . "/../app/controllers/web/user/UserController.php";
// Auth Controllers
require_once __DIR__ . "/../app/controllers/web/auth/LoginController.php";
require_once __DIR__ . "/../app/controllers/web/auth/RegisterController.php";
// Middleware
require_once __DIR__ . "/../app/middlewares/AuthMiddleware.php";
require_once __DIR__ . "/../app/middlewares/GuestMiddleware.php";
require_once __DIR__ . "/../app/middlewares/RegisterMiddleware.php";



Route::get("/", HomeController::class, "index", [AuthMiddleware::class]);


Route::get("/auth/login", LoginController::class, "index", [GuestMiddleware::class]);
Route::post("/auth/login", LoginController::class, "login");

Route::get("/auth/register", RegisterController::class, "index", [RegisterMiddleware::class]);
Route::post("/auth/register", RegisterController::class, "register");

Route::get("/auth/logout", LoginController::class, "logout", [AuthMiddleware::class]);

Route::get("/profile", ProfileController::class, "index", [AuthMiddleware::class]);

Route::post("/profile/edit/{type}", UserController::class, "edit", [AuthMiddleware::class]);
