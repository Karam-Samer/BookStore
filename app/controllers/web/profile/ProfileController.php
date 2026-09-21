<?php
require_once __DIR__ . "/../../Controller.php";

class ProfileController extends Controller
{
    public function index(): void
    {
        $this->view('Profile/profile');
    }
}
