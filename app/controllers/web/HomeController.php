<?php
require_once __DIR__ . "/../Controller.php";

class HomeController extends Controller
{
    public function index(): void
    {
        $data = [
            'title' => 'Welcome',
            'content' => 'This is the home page content.'
        ];
        $this->view('Home/home', $data);
    }
}
