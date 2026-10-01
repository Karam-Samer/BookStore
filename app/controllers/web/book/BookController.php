<?php
require_once __DIR__ . "/../../Controller.php";
require_once __DIR__ . "/../../../models/book/BookModel.php";

class BookController extends Controller
{
    public function filterBooks(): void
    {
        $wantedData = [
            'filterBookTitle',
            'filterAuthorName',
            'filterMinPrice',
            'filterMaxPrice',
            'filterStock',
            'filterSort',
            'page'
        ];
        if (!Request::has($wantedData)) {
            Response::json([], 'Missing required data', 400);
        }
        $maxPrice = Request::input('filterMaxPrice', '') == '' ? false : Request::input('filterMaxPrice');
        $minPrice = Request::input('filterMinPrice', '') == '' ? 0 : Request::input('filterMinPrice');
        $stock = Request::input('filterStock', '') == '' ? false : Request::input('filterStock');
        $wheres = [
            ['title', 'like', "%" . Request::input('filterBookTitle', '') . "%"],
            ['authors.name', 'like', "%" . Request::input('filterAuthorName', '') . "%"],
            ['price', '>=', $minPrice],
        ];

        if ($maxPrice !== false) {
            array_push($wheres, ['price', '<=', $maxPrice]);
        }
        if ($stock !== false) {
            array_push($wheres, ['stock', '=', $stock]);
        }



        $books = BookModel::getDataOfBooks($wheres, Request::input('filterSort'), Request::input('page', 1));

        Response::json($books);
    }

    public function addBook(): void
    {
        $wantedData = [
            'authorId',
            'bookTitle',
            'bookDesc',
            'bookPrice',
            'bookStock',
        ];
        if (!Request::has($wantedData)) {
            Response::json([], 'Missing required data', 422);
        }



        $errors = Request::validate([
            'authorId' => ['required', ['exists', 'authors', 'id']],
            'bookTitle' => ['required'],
            'bookDesc' => ['required'],
            'bookPrice' => ['required', 'numeric'],
            'bookStock' => ['required', 'numeric'],
        ]);

        if (!empty($errors)) {
            Response::json($errors, 'Validation errors', 422);
        }

        $newBook = BookModel::addBook();

        Response::json($newBook, 'Book added successfully');
    }
}
