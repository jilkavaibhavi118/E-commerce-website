<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /** Show logged-in user's all orders */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
                       ->latest()
                       ->get();

        return view('frontend.orders.index', compact('orders'));
    }

    /** Show single order */
    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        return view('frontend.orders.show', compact('order'));
    }
}
