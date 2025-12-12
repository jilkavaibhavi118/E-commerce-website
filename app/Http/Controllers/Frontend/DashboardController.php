<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        // Get all products (or limit if needed)
        $products = Product::latest()->get();

        // Pass products to the frontend dashboard
        return view('frontend.dashboard', compact('products'));
    }
}
