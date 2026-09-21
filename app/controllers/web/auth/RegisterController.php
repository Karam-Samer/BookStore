<?php

require_once __DIR__ . "/../../Controller.php";
require_once __DIR__ . "/../../../models/user/UserModel.php";

class RegisterController extends Controller
{
    public function index(): void
    {
        $this->view("auth/register");
    }

    public function register(): void
    {

        if (Request::input('role') === 'admin' && !isAuth("admin")) {
            back("_errorMsg", "You are not authorized to create an admin account.");
        }
        
        $errors = Request::validate([
            'role' => ['required'],
            'name' => ['required'],
            'email' => ['required', 'email', ['unique', 'users']],
            'password' => ['required', ['min', 8]],
            'phone' => ['required', 'egPhone', ['unique', 'users']],
            'gender' => ['required'],
        ]);

        if (!empty($errors)) {
            back();
        }

        UserModel::createUser();

        $newRole = Request::input('role');

        back("_success", "New {$newRole} created successfully");
    }
}
