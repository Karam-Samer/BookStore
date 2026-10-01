<?php
require_once __DIR__ . "/../../Controller.php";
require_once __DIR__ . "/../../../models/user/UserModel.php";

class UserController extends Controller
{
    public function edit(string $type): void
    {

        $rules = [
            'role' => ['role' => ['required']],
            'name' => ['name' => ['required']],
            'email' => ['email' => ['required', 'email', ['unique', 'users', auth('id')]]],
            'password' => ['password' => ['required', ['min', 8]]],
            'phone' => ['phone' => ['required', 'regPhone', ['unique', 'users', auth('id')]]],
            'gender' => ['gender' => ['required']],
        ];
        $type = lcfirst($type);
        $value = Request::input($type);

        if ($value == auth($type)) {
            Response::json(["type" => "warning", "value" => $value], "No changes made");
        }

        $errors = Request::validate($rules[$type]);

        if (!empty($errors)) {
            Response::json(
                ["type" => "error"],
                $errors[$type][0] ?? "Validation error",
                422
            );
        }

        UserModel::updateUser($type, Request::input($type));

        $_SESSION['user'][$type] = $value;

        Response::json(["type" => "success", "value" => $value], "Updated successfully");
    }
}
