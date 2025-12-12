<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        // Fetch cart items for the logged-in user
        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();

        // Count for display badge
        session(['cart_count' => $cartItems->count()]);

        // Calculate subtotal
        $subtotal = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        // Default discount values
        $discountAmount = 0;
        $couponType = null;
        $couponValue = null;
        $couponCode = session('coupon_code');

        if ($couponCode) {
            $coupon = Coupon::where('code', $couponCode)->where('status', 1)->first();
            if ($coupon) {
                if ($coupon->type === 'fixed') {
                    $discountAmount = max(0, (float)$coupon->value);
                    $couponType = 'fixed';
                } elseif ($coupon->type === 'percent' || $coupon->type === 'percentage') {
                    $percent = max(0, min(100, (float)$coupon->value));
                    $discountAmount = round(($subtotal * $percent) / 100, 2);
                    $couponType = 'percent';
                }

                $discountAmount = min($discountAmount, $subtotal);
                $couponValue = $coupon->value;

                session(['discount' => $discountAmount]);
            }
        }

        $total = max(0, $subtotal - $discountAmount);

        return view('frontend.cart', [
            'cart' => $cartItems,
            'subtotal' => $subtotal,
            'discountAmount' => $discountAmount,
            'total' => $total,
            'couponType' => $couponType,
            'couponValue' => $couponValue,
        ]);
    }


    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $product = Product::findOrFail($request->product_id);

        // Check if item already exists in cart
        $cartItem = Cart::where('user_id', Auth::id())
                        ->where('product_id', $product->id)
                        ->first();

        if ($cartItem) {
            // Increase quantity
            $cartItem->increment('quantity');
        } else {
            // Create new cart row
            Cart::create([
                'user_id'    => Auth::id(),
                'product_id' => $product->id,
                'quantity'   => 1
            ]);
        }

        // Updated cart count
        $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');

        return response()->json([
            'success' => true,
            'cart_count' => $cartCount
        ]);
    }



    // UPDATE CART ITEM
    public function update(Request $request)
    {
        $cart = Cart::findOrFail($request->cart_id);
        $cart->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Cart updated!');
    }

    // REMOVE ITEM
    public function remove($id)
    {
        Cart::findOrFail($id)->delete();

        return back()->with('success', 'Item removed!');
    }

    // APPLY COUPON
    public function applyCoupon(Request $request)
    {
        $coupon = Coupon::where('code', $request->code)
            ->where('status', 1)
            ->first();

        if (!$coupon) {
            return back()->with('error', 'Invalid or inactive coupon!');
        }

        // Get cart
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Your cart is empty!');
        }

        // Calculate subtotal
        $subtotal = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        // Calculate discount amount
        if ($coupon->type === 'fixed') {
            $discountAmount = max(0, (float)$coupon->value);
        } elseif ($coupon->type === 'percent' || $coupon->type === 'percentage') {
            $percent = max(0, min(100, (float)$coupon->value));
            $discountAmount = round(($subtotal * $percent) / 100, 2);
        } else {
            $discountAmount = 0;
        }

        // Prevent over-discount
        $discountAmount = min($discountAmount, $subtotal);

        // Save in session
        session([
            'coupon_code' => $coupon->code,
            'discount' => $discountAmount,
        ]);

        return back()->with('success', 'Coupon applied successfully!');
    }
}
