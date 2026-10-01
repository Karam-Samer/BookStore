<?php

require_once __DIR__ . '/../Model.php';

class BookModel extends Model
{
    public static function getDataOfBooks(array $wheres = [], string $sort = 'DESC', int $page = 1)
    {
        $DB = Database::getConnection();

        $whereQuery = self::prepareWhereQuery($wheres);


        $offset = ($page - 1) * 10;

        $stmt = $DB->query("SELECT
                              books.*,
                              authors.name as author_name
                              FROM books
                              LEFT JOIN authors ON books.author_id = authors.id
                              {$whereQuery}
                              ORDER BY id {$sort} 
                              LIMIT 10 offset {$offset} ");

        $data = $stmt->fetchAll();

        $stmt = $DB->query("SELECT COUNT(*) as total
                              FROM books
                              LEFT JOIN authors ON books.author_id = authors.id
                              {$whereQuery}");

        $total = $stmt->fetch();

        return [
            'data' => $data,
            'total' => $total['total'],
            'totalPages' => ceil($total['total'] / 10),
            'currentPage' => $page
        ];
    }

    public static function addBook()
    {
        $DB = Database::getConnection();

        $stmt = $DB->prepare("INSERT INTO books
                             (author_id, title, image, description, price, stock)
                             VALUES
                             (:author_id, :title, :image, :description, :price, :stock)");

        $stmt->execute([
            ':author_id' => Request::input('authorId'),
            ':title' => Request::input('bookTitle'),
            ':image' => self::uploadImg('bookImg'),
            ':description' => Request::input('bookDesc'),
            ':price' => Request::input('bookPrice'),
            ':stock' => Request::input('bookStock')
        ]);
        $newId = $DB->lastInsertId();

        $newBook = self::getDataOfBooks([['books.id', '=', $newId]]);
        return $newBook['data'][0];
    }

    public static function uploadImg(string $fileName): ?string
    {
        if (!Request::hasFile($fileName)) {
            return null;
        }

        $file = Request::file($fileName);
        $FileName = $file['name'];
        $fileOriginalName = pathinfo($FileName, PATHINFO_FILENAME);
        $fileOriginalExtension = strtolower(pathinfo($FileName, PATHINFO_EXTENSION));
        $fileTmpName = $file['tmp_name'];

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($fileOriginalExtension, $allowedExtensions)) {
            Response::json([], 'Invalid file type.', 422);
        }

        $fileNewName = $fileOriginalName . '_' . time() . '.' . $fileOriginalExtension;

        $uploadDir = __DIR__ . '/../../../public/assets/images/uploads';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir);
        }




        $uploadPath = $uploadDir . '/' . $fileNewName;

        if (!move_uploaded_file($fileTmpName, $uploadPath)) {
            Response::json([], 'Failed to upload file.', 500);
        }



        return $fileNewName;
    }
}
