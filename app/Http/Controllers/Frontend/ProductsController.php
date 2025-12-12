<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductsController extends Controller
{
    // Show Product Details Page
    public function show($id)
    {
        $product = Product::with('images', 'category', 'brand')->findOrFail($id);

        // Fetch related products
        $relatedProducts = Product::where('category_id', $product->category_id)
                                  ->where('id', '!=', $id)
                                  ->take(4)
                                  ->get();

        return view('frontend.product-details', compact('product', 'relatedProducts'));
    }
}
