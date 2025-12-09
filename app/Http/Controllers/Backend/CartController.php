<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // SHOW CART PAGE
    public function index()
    {
        $cart = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        $subtotal = $cart->sum(fn ($item) =>
            $item->product->selling_price * $item->quantity
        );

        $discount = session('discount', 0);
        $total = $subtotal - $discount;

        return view('frontend.cart', compact('cart', 'subtotal', 'discount', 'total'));
    }

    // ADD TO CART
    public function add(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        $cart = Cart::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($cart) {
            $cart->increment('quantity');
        } else {
            Cart::create([
                'user_id'    => Auth::id(),
                'product_id' => $product->id,
                'quantity'   => 1,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Added to cart!',
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
            return back()->with('error', 'Invalid coupon!');
        }

        // Calculate subtotal
        $cart = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        $subtotal = $cart->sum(fn ($item) =>
            $item->product->selling_price * $item->quantity
        );

        // Discount logic
        $discount = ($coupon->type === 'fixed')
            ? $coupon->value
            : ($subtotal * ($coupon->value / 100));

        session(['discount' => $discount]);

        return back()->with('success', 'Coupon applied!');
    }
}
