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
            'data' => $orders
        ]);
    }
}
