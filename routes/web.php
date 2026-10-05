<?php

require_once __DIR__ . "/../core/Route.php";
// Controllers
require_once __DIR__ . "/../app/controllers/web/HomeController.php";
require_once __DIR__ . "/../app/controllers/web/profile/ProfileController.php";
require_once __DIR__ . "/../app/controllers/web/user/UserController.php";
require_once __DIR__ . "/../app/controllers/web/author/AuthorController.php";
require_once __DIR__ . "/../app/controllers/web/book/BookController.php";
require_once __DIR__ . "/../app/controllers/web/admin/AdminController.php";
require_once __DIR__ . "/../app/controllers/web/orders/OrdersController.php";
require_once __DIR__ . "/../app/controllers/web/cart/CartController.php";
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


Route::post("/profile/addAuthor", AuthorController::class, "addAuthor", ["AuthMiddleware:admin"]);

Route::post("/profile/filterBooks", BookController::class, "filterBooks", [AuthMiddleware::class]);

Route::post("/profile/addBook", BookController::class, "addBook", ["AuthMiddleware:admin"]);

Route::post("/profile/banUser", AdminController::class, "banUser", ["AuthMiddleware:admin"]);

Route::post("/profile/pagination/{type}", OrdersController::class, "paginate", [AuthMiddleware::class]);

Route::post("/profile/addToCart", CartController::class, "addToCart", ["AuthMiddleware:customer"]);

Route::post("/profile/getCartItems", CartController::class, "getCartItems", [AuthMiddleware::class]);

Route::post("/profile/updateCart", CartController::class, "updateCart", ["AuthMiddleware:customer"]);

Route::post("/profile/removeFromCart", CartController::class, "removeFromCart", ["AuthMiddleware:customer"]);

Route::post("/profile/fireOrder", CartController::class, "fireOrder", ["AuthMiddleware:customer"]);

Route::post("/profile/doneOrder", OrdersController::class, "doneOrder", ["AuthMiddleware:admin"]);

Route::post("/profile/cancelOrder", OrdersController::class, "cancelOrder", ["AuthMiddleware:admin"]);