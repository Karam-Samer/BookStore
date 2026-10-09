<?php

require_once __DIR__ . "/../../Controller.php";
require_once __DIR__ . "/../../../models/auth/AuthModel.php";

class LoginController extends Controller
{
    public function index(): void
    {
        $this->view("auth/Login");
    }

    public function login(): void
    {
        $errors = Request::validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!empty($errors)) {
            back();
        }

        $user = AuthModel::login();
        if (isset($user['error'])) {
            back("_invalid", $user['error']);
        }
        unset($user['password']);
        unset($_SESSION['user']['error']);
        $_SESSION['user'] = $user;
        $_SESSION['_old'] = [];
        session_regenerate_id(true);
        redirect("/profile");
    }

    public function logout()
    {
        unset($_SESSION['user']);

        redirect("/auth/login");
    }
}
