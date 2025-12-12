<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Show wishlist page
     */
    public function index()
    {
        $wishlistItems = Wishlist::with('product.images')
            ->where('user_id', Auth::id())
            ->get();

        // Count for display badge
        session(['wishlist_count' => $wishlistItems->count()]);

        return view('frontend.wishlist', compact('wishlistItems'));
    }


    /**
     * Add product to wishlist
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $productId = $request->product_id;

        // Prevent duplicate wishlist items
        $exists = Wishlist::where('user_id', Auth::id())
                          ->where('product_id', $productId)
                          ->exists();

        if ($exists) {
            return back()->with('message', 'Already in wishlist');
        }

        Wishlist::create([
            'user_id'    => Auth::id(),
            'product_id' => $productId,
        ]);

        // update session count
        session(['wishlist_count' => Wishlist::where('user_id', Auth::id())->count()]);

        return back()->with('success', 'Added to wishlist!');
    }


    /**
     * Remove a product from wishlist
     */
    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        Wishlist::where('user_id', Auth::id())
                ->where('product_id', $request->product_id)
                ->delete();

        // Update count
        session(['wishlist_count' => Wishlist::where('user_id', Auth::id())->count()]);

        return back()->with('success', 'Removed from wishlist');
    }
}
