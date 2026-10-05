<?php
require_once __DIR__ . "/../../Controller.php";
require_once __DIR__ . "/../../../models/DB/DBModel.php";
require_once __DIR__ . "/../../../models/book/BookModel.php";
require_once __DIR__ . "/../../../models/order/OrderModel.php";
require_once __DIR__ . "/../../../models/cart/CartModel.php";

class ProfileController extends Controller
{
    public function index(): void
    {
        $role = ucfirst(auth("role"));
        if (isAuth("admin")) {
            $data = $this->getAdminData();
        } else if (isAuth("customer")) {
            $data = $this->getCustomerData();
        }


        $data['currentPage'] = $_GET['page'] ?? 1;

        $this->view('Profile/profile', $data);
    }

    private function getAdminData(): array
    {
        $total = [
            'books' => DBModel::getTotalOfTable('books'),
            'authors' => DBModel::getTotalOfTable('authors'),
            'customers' => DBModel::getTotalOfTable('users', [['role', '=', 'customer']]),
            'admins' => DBModel::getTotalOfTable('users', [['role', '=', 'admin']]),
            'orders' => [
                'ordered' => DBModel::getTotalOfTable('orders', [['status', '=', 'ordered']]),
                'canceled' => DBModel::getTotalOfTable('orders', [['status', '=', 'canceled']]),
                'done' => DBModel::getTotalOfTable('orders', [['status', '=', 'done']]),
            ]
        ];
        $admins = DBModel::getDataOfTable('users', [['role', '=', 'admin'], ['id', '!=', auth('id')]], Request::input('admins-page', 1));
        $customers = DBModel::getDataOfTable('users', [['role', '=', 'customer']], Request::input('customers-page', 1));
        $authors = DBModel::getDataOfTable('authors', page: Request::input('authors-page', 1));
        $books = BookModel::getDataOfBooks(page: Request::input('books-page', 1));
        $orders = [
            'ordered' => OrderModel::getDataOfOrders([['status', '=', 'ordered']], page: Request::input('orders_ordered-page', 1)),
            'canceled' => OrderModel::getDataOfOrders([['status', '=', 'canceled']], page: Request::input('orders_canceled-page', 1)),
            'done' => OrderModel::getDataOfOrders([['status', '=', 'done']], page: Request::input('orders_done-page', 1)),
        ];

        return [
            'total' => $total,
            'admins' => $admins,
            'customers' => $customers,
            'authors' => $authors,
            'books' => $books,
            'orders' => $orders
        ];
    }

    private function getCustomerData(): array
    {
        $total = [
            'books' => DBModel::getTotalOfTable('books'),
            'boughtBooks' => DBModel::getTotalOfCustomerBooks(),
            'totalCartItems' => CartModel::totalItemsInCart(),
            'orders' => [
                'ordered' => DBModel::getTotalOfTable('orders', [['status', '=', 'ordered'], ['customer_id', '=', auth('id')]]),
                'canceled' => DBModel::getTotalOfTable('orders', [['status', '=', 'canceled'], ['customer_id', '=', auth('id')]]),
                'done' => DBModel::getTotalOfTable('orders', [['status', '=', 'done'], ['customer_id', '=', auth('id')]]),
            ]
        ];
        $books = BookModel::getDataOfBooks(page: Request::input('books-page', 1));
        $orders = [
            'ordered' => OrderModel::getDataOfOrders([['status', '=', 'ordered'], ['customer_id', '=', auth('id')]], Request::input('orders_ordered-page', 1)),
            'canceled' => OrderModel::getDataOfOrders([['status', '=', 'canceled'], ['customer_id', '=', auth('id')]], Request::input('orders_canceled-page', 1)),
            'done' => OrderModel::getDataOfOrders([['status', '=', 'done'], ['customer_id', '=', auth('id')]], Request::input('orders_done-page', 1)),
        ];

        return [
            'total' => $total,
            'books' => $books,
            'orders' => $orders
        ];
    }
}
