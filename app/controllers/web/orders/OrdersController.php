<?php

require_once __DIR__ . "/../../Controller.php";
require_once __DIR__ . "/../../../models/order/OrderModel.php";


class OrdersController extends Controller
{
    public function paginate($type)
    {
        $page = $_POST['page'] ?? 1;
        $orders = OrderModel::getDataOfOrders([['status', '=', $type]], page: $page);

        Response::json([
            'orders' => $orders,
            'role' => auth("role")
        ]);
    }

    public function doneOrder()
    {
        $errors = Request::validate([
            'orderId' => ['required', 'numeric', ['exists', 'orders', 'id']]
        ]);

        if (!empty($errors)) {
            Response::json($errors, "Unprocessable Entity", 422);
        }

        $data = OrderModel::doneOrder();
        Response::json([$data]);
    }

    public function cancelOrder()
    {
        $errors = Request::validate([
            'orderId' => ['required', 'numeric', ['exists', 'orders', 'id']],
            'cancelReason' => ['required']
        ]);

        if (!empty($errors)) {
            Response::json($errors, "Unprocessable Entity", 422);
        }

        $data = OrderModel::cancelOrder();
        Response::json([$data]);
    }
}
