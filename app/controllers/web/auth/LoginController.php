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
            redirect("/profile");
        }
        back("_errorMsg", "Invalid email or password");
    }
}
