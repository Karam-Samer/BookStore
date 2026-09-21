<?php

class UserController
{
    public function __invoke()
    {
        if (!isset($_SESSION['user'])) {
            Response::error("Unauthorized", 401);
        }
        $user = $_SESSION['user'];
        Response::json($user);
    }
}