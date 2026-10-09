<?php
require_once __DIR__ . "/../../Controller.php";
require_once __DIR__ . "/../../../models/cart/CartModel.php";

class CartController extends Controller
{

    public static function addToCart(): void
    {
        $errors = Request::validate([
            'bookId' => ['required', 'numeric', ['exists', 'books', 'id']],
            'quantity' => ['required', 'numeric']
        ]);

        if (!empty($errors)) {
            Response::json($errors, "Unprocessable Entity", 422);
        }

        if (!CartModel::checkStock(Request::input('bookId'), Request::input('quantity'))) {
            Response::json([], "Total quantity exceeds available stock", 400);
            return;
        }

        $data = CartModel::addToCart(Request::input('bookId'), Request::input('quantity'));
        Response::json($data, "Item added to cart successfully");
    }

    public static function getCartItems(): void
    {
        $orderId = null;
        if (Request::input('orderId') != null || Request::input('orderId') !== "") {
            Request::validate([
                'orderId' => ['nullable', 'numeric', ['exists', 'orders', 'id']]
            ]);

            if (!empty($errors)) {
                Response::json($errors, "Unprocessable Entity", 422);
            }
            $orderId = Request::input('orderId');
        }
        $cartItems = CartModel::getCartItems($orderId);
        Response::json($cartItems, "Cart items retrieved successfully");
    }

    public static function updateCart(): void
    {
        $errors = Request::validate([
            'orderItemId' => ['required', 'numeric', ['exists', 'orders_items', 'id']],
            'quantity' => ['required', 'numeric'],
            'bookId' => ['required', 'numeric', ['exists', 'books', 'id']]
        ]);

        if (!empty($errors)) {
            Response::json($errors, "Unprocessable Entity", 422);
        }

        $quantity = Request::input('quantity');
        $bookId = Request::input('bookId');

        if (!CartModel::checkStock($bookId, $quantity)) {
            Response::json([], "Total quantity exceeds available stock", 400);
        } else if ($quantity < 0) {
            Response::json([], "Quantity must be greater than zero", 400);
        } else if ($quantity == 0) {
            $data = CartModel::removeFromCart();
            Response::json($data, "Item removed from cart successfully");
        }

        $data = CartModel::updateQuantity();
        Response::json($data, "Quantity updated successfully");
    }

    public static function removeFromCart(): void
    {
        $errors = Request::validate([
            'orderItemId' => ['required', 'numeric', ['exists', 'orders_items', 'id']]
        ]);

        if (!empty($errors)) {
            Response::json($errors, "Unprocessable Entity", 422);
        }

        $data = CartModel::removeFromCart();

        Response::json($data, "Item removed from cart successfully");
    }

    public static function fireOrder(): void
    {
        $errors = Request::validate([
            'orderId' => ['required', 'numeric', ['exists', 'orders', 'id']]
        ]);

        if (!empty($errors)) {
            Response::json($errors, "Unprocessable Entity", 422);
        }

        $data = CartModel::fireOrder();

        Response::json($data, "Order placed successfully");
    }
}
