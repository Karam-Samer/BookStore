<?php
require_once __DIR__ . "/../../Controller.php";
require_once __DIR__ . "/../../../models/admin/AdminModel.php";

class AdminController extends Controller
{

    public function banUser(): void
    {
        $wantedData = [
            'userId',
        ];
        if (!Request::has($wantedData)) {
            Response::json([], 'Missing required data', 422);
        }

        $errors = Request::validate([
            'userId' => ['required', ['exists', 'users', 'id']],
        ]);

        if (!empty($errors)) {
            Response::json($errors, 'User not found', 422);
        }

        if (auth("id") == Request::input('userId')) {
            Response::json([], 'You cannot ban yourself', 422);
        }


        AdminModel::banUser();

        Response::json([], 'User status updated successfully');
    }
}
