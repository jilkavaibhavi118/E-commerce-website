<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        $products = Product::where('name', 'LIKE', "%$query%")
                           ->orWhere('description', 'LIKE', "%$query%")
                           ->paginate(12);

        return view('frontend.search.index', compact('products', 'query'));
    }
}
