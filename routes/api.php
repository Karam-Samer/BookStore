<?php

require_once  __DIR__ . "/../core/Route.php";
require_once  __DIR__ . "/../app/controllers/api/UserController.php";

Route::get("/api/v1/getUser", UserController::class, "getData");
