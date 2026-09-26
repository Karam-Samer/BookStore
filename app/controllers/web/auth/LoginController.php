<?php

require_once __DIR__ . "/../../Controller.php";
require_once __DIR__ . "/../../../models/auth/AuthModel.php";

class LoginController extends Controller
{
    public function index(): void
    {
        $this->view("auth/login");
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

        if (AuthModel::login()) {
            $_SESSION['_old'] = [];
            session_regenerate_id(true);
            redirect("/profile");
        }
        back("_invalid", "Invalid email or password");
    }

    public function logout()
    {
        unset($_SESSION['user']);

        redirect("/auth/login");
    }
}
