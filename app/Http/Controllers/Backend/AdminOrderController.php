<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Notifications\OrderStatusUpdatedNotification;

class AdminOrderController extends Controller
{
        // LIST ALL ORDERS
        public function index(Request $request)
        {
            if ($request->ajax()) {

                $data = Order::with('customer','items')->latest()->get();

                return datatables()->of($data)
                    ->addIndexColumn()

                    ->addColumn('customer', function($row) {
                        return $row->customer->name ?? 'No Customer';
                    })

                    ->addColumn('address', function($row) {
                        return $row->address ?? 'N/A';
                    })

                    ->addColumn('total_amount', function($row) {
                        $total = $row->items->sum(function($item) {
                            return $item->price * ($item->quantity ?? 1);
                        });

                        return number_format($total, 2);
                    })

                    ->addColumn('product', function($row) {
                        return $row->items->map(fn($item) => $item->product->name)->implode(', ');
                    })

                    ->addColumn('order_status' , function ($row) {
                        return $row->order_status ?? 'processing';
                    })

                    ->addColumn('payment_status', function ($row) {
                        return $row->payment_status ?? 'Pending';
                    })

                    ->addColumn('action', function ($row) {
                        return view('layouts.includes.list-action', [
                            'data' => $row,
                            'module' => 'orders',
                            'module2' => 'admin.orders',
                        ])->render();
                    })

                    ->rawColumns(['status','action'])
                    ->make(true);
            }

            return view('backend.orders.index');
        }


    // SHOW ORDER DETAILS
    public function show(Order $order)
    {
        return view('backend.orders.show', compact('order'));
    }

    // EDIT ORDER STATUS
    public function edit($id)
    {
        $order = Order::findOrFail($id);
        return view('backend.orders.edit', compact('order'));
    }

    // UPDATE ORDER FIELDS
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'order_status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'payment_status' => 'required|in:pending,paid,fail' . $id

        ]);

        $order->update($request->all());

        return response()->json(['success' => 'Orders updated Successfully', 'url' => route('admin.orders.index')]);
    }


    // DELETE ORDER
    public function destroy(Order $order)
    {
        $order->delete();

        return back()->with('success', 'Order deleted successfully.');
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        // Notify customer about status update
        $order->user->notify(new OrderStatusUpdatedNotification($order));

        return back()->with('success', 'Status updated!');
    }


}
