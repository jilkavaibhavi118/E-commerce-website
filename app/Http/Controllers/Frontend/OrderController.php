<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\Review;
use App\Notifications\OrderCreatedNotification;

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

    /**
     * stores the orders
     */

    public function store()
    {
        // create orders
        $order = Order::create([
            'user_id' => $user->id,
            'total_amount' => $totalAmount,
            'status' => 'pending'

        ]);

        // notify the customer
        $customer = auth()->user();
        $customer->notify(new OrderCreatedNotification($order));

        // notify the admin
        $admin = User::where('role', 'admin')->first();
        $admin->notify(new OrderCreatedNotification($order));

        return redirect()->route('frontend.order-success')->with('success', 'Order placed successfully!');
    }

    /** Show single order */
    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        return view('frontend.orders.show', compact('order'));
    }

    public function invoice(Order $order)
    {
        // Make sure the authenticated user owns the order
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        return view('frontend.orders.invoice', compact('order'));
    }

      // Show feedback form
      public function feedbackForm(Order $order)
      {
          if ($order->user_id !== auth()->id()) {
              abort(403, 'Unauthorized');
          }
          return view('frontend.orders.feedback', compact('order'));
      }

      // Handle feedback submission
      public function submitFeedback(Request $request, Order $order)
      {
          $request->validate([
              'message' => 'required|string|max:1000',
              'rating' => 'required|integer|min:1|max:5',
          ]);

          Feedback::create([
              'user_id' => auth()->id(),
              'order_id' => $order->id,
              'message' => $request->message,
              'rating' => $request->rating,
          ]);

          return redirect()->route('frontend.orders.invoice', $order->id)
                           ->with('success', 'Feedback submitted successfully!');
      }

      // Show review form
      public function reviewForm(Order $order)
      {
          if ($order->user_id !== auth()->id()) {
              abort(403, 'Unauthorized');
          }
          return view('frontend.orders.review', compact('order'));
      }

      // Handle review submission
      public function submitReview(Request $request, Order $order)
      {
          $request->validate([
              'product_id' => 'required|exists:products,id',
              'message' => 'required|string|max:1000',
              'rating' => 'required|integer|min:1|max:5',
          ]);

          Review::create([
              'user_id' => auth()->id(),
              'product_id' => $request->product_id,
              'order_id' => $order->id,
              'message' => $request->message,
              'rating' => $request->rating,
          ]);

          return redirect()->route('frontend.orders.invoice', $order->id)
                           ->with('success', 'Review submitted successfully!');
      }
}
