<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('status', 'completed')->get();

        return view('admin.orders.index', ['orders' => $orders]);
    }

    public function show(Order $order)
    {
        $itemsSold = $order->itemsSold;
        $total = 0;

        foreach ($itemsSold as $item) {
            $itemDetails = $item->item;
            $subtotal = $item->quantity * $itemDetails->price;
            $total += $subtotal;
        }

        return view('admin.orders.show', [
            'order' => $order,
            'itemsSold' => $itemsSold,
            'total' => $total
        ]);
    }

}
