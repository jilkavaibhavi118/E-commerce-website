<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\OrderCreatedNotification;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Cart::with('product')
            ->where('user_id', Auth::id())->get();

        if ($cart->count() == 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        $subtotal = $cart->sum(fn ($item) =>
            $item->product->price * $item->quantity
        );

        $discount = session('discount', 0);
        $total = $subtotal - $discount;

        return view('frontend.checkout', compact('subtotal', 'discount', 'total'));
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'name'    => 'required',
            'email'   => 'required|email',
            'phone'   => 'required',
            'address' => 'required',
        ]);

        $cart = Cart::with('product')->where('user_id', Auth::id())->get();

        if ($cart->count() == 0) {
            return back()->with('error', 'Cart is empty!');
        }

        $subtotal = $cart->sum(fn ($item) =>
            $item->product->price * $item->quantity
        );

        $discount = session('discount', 0);
        $total = $subtotal - $discount;

         //CREATE ORDER
        $order = Order::create([
            'user_id'  => Auth::id(),
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'address'  => $request->address,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total'    => $total,
            'status'   => 'pending',
        ]);

           // Notify the customer
           auth()->user()->notify(new OrderCreatedNotification($order));

               // Notify the admin
              $admin = User::where('role', 'admin')->first();
              if ($admin) {
                  $admin->notify(new OrderCreatedNotification($order));
              }

        // SAVE THE ORDER
        foreach ($cart as $item) {
            OrderItem::create([
                'order_id'  => $order->id,
                'product_id'=> $item->product_id,
                'quantity'  => $item->quantity,
                'price'     => $item->product->price,
                'total'     => $item->product->price * $item->quantity
            ]);

            // REDUCE STOCK
            $item->product->decrement('quantity', $item->quantity);
        }

        // CLEAR CART + COUPON
        Cart::where('user_id', Auth::id())->delete();
        session()->forget('discount');

        return redirect()->route('cart.index')->with('success', 'Order placed successfully!');
    }
}
