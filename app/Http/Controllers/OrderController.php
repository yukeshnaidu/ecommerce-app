<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderItem;
use App\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
     public function index()
    {
        $orders = Order::with('items.product')
                      ->where('user_id', auth()->id())
                      ->orderBy('created_at', 'desc')
                      ->get();
                      
        return view('orders.index', compact('orders'));
    }
    
    public function show(Order $order)
    {
        if ($order->user_id != auth()->id()) {
            abort(403);
        }
        
        return view('orders.show', compact('order'));
    }
}