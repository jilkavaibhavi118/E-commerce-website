<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    // LIST ALL ORDERS
    public function index()
    {
        $orders = Order::latest()->get();

        return view('backend.orders.index', compact('orders'));
    }

    // SHOW ORDER DETAILS
    public function show(Order $order)
    {
        $order->load('items.product');

        return view('backend.orders.show', compact('order'));
    }

    // EDIT ORDER STATUS
    public function edit(Order $order)
    {
        return view('backend.orders.edit', compact('order'));
    }

    // UPDATE ORDER FIELDS
    public function update(Request $request, Order $order)
    {
        $order->update($request->only('status'));

        return redirect()->route('orders.index')
            ->with('success', 'Order updated successfully.');
    }

    // UPDATE ORDER STATUS (AJAX/POST)
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);

        $order->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Order status updated');
    }

    // DELETE ORDER
    public function destroy(Order $order)
    {
        $order->delete();

        return back()->with('success', 'Order deleted successfully.');
    }
}
