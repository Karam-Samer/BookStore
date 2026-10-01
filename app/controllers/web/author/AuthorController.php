<?php
require_once __DIR__ . "/../../Controller.php";
require_once __DIR__ . "/../../../models/author/AuthorModel.php";

class AuthorController extends Controller
{
    public static function addAuthor(): void
    {
        $authorName = Request::input('authorName');
        $authorBio = Request::input('authorBio');

        $errors = Request::validate([
            'authorName' => ['required'],
            'authorBio' => ['required']
        ]);

        if (!empty($errors)) {
            Response::json($errors, "Unprocessable Entity", 422);
        }

        $authorId = AuthorModel::addAuthor();

        Response::json(["authorId" => $authorId, "authorName" => $authorName, "authorBio" => $authorBio], "Author added successfully");
    }
}
