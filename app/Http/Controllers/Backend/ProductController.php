<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductSku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $products = Product::with(['category', 'subCategory', 'skus', 'images'])->get();

            return DataTables::of($products)
                ->addIndexColumn()
                ->addColumn('category', fn($row) => $row->category?->name ?? '—')
                ->addColumn('subcategory', fn($row) => $row->subCategory?->name ?? '—')

                // mininm
                ->addColumn('price', function ($row) {
                    if ($row->skus->count()) {
                        return "₹ " . number_format($row->skus->min('price'), 2);
                    }
                    return '—';
                })

                // status
                ->addColumn('status', fn($row) =>
                    $row->status == 1
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Inactive</span>'
                )

                // image
                ->addColumn('image', function ($row) {
                    if ($row->images->count()) {
                        return '<img src="' . asset('storage/' . $row->images->first()->image_path) . '" width="60">';
                    }
                    return '—';
                })

                ->addColumn('action', function ($row) {
                    // Use products module for routes (show/edit/destroy)
                    return view('layouts.includes.list-action', [
                        'data' => $row,
                        'module' => 'products',
                    ])->render();
                })

                ->rawColumns(['status', 'action', 'image'])
                ->make(true);
        }

        return view('backend.products.index');
    }

    public function create()
    {
        $categories = Category::where('status', 1)->get();
        return view('backend.products.create', compact('categories'));
    }

    public function show($id)
    {
        $product = Product::with(['category', 'subCategory', 'images', 'skus'])->findOrFail($id);
        return view('backend.products.show', compact('product'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            // VALIDATION
            $request->validate([
                'name' => 'required|string|max:255',
                'category_id' => 'required',
                'subcategory_id' => 'required',
                'description' => 'nullable',
                'status' => 'required|boolean',
                'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
                'skus' => 'required|array|min:1',
                'skus.*.sku' => 'required|string',
                'skus.*.attribute' => 'required|string',
                'skus.*.stock' => 'required|integer|min:0',
                'skus.*.price' => 'required|numeric|min:0',
            ]);

            $skuData = collect($request->input('skus'));
            $basePrice = $skuData->min('price');

            // CREATE PRODUCT
            $product = Product::create([
                'name' => $request->name,
                'slug' => str()->slug($request->name),
                'category_id' => $request->category_id,
                'subcategory_id' => $request->subcategory_id,
                'description' => $request->description,
                'price' => $basePrice,
                'status' => $request->status,
            ]);

            // SAVE SKUS
            $product->skus()->createMany($skuData->map(function ($sku) {
                return [
                    'sku' => $sku['sku'],
                    'attribute' => $sku['attribute'],
                    'stock' => $sku['stock'],
                    'price' => $sku['price'],
                ];
            })->toArray());

            //  images
            if ($request->hasFile('images')) {

                foreach ($request->file('images') as $img) {
                    $filename = time() . '_' . $img->getClientOriginalName();

                    // Save to storage/app/public/products
                    $path = $img->storeAs('products', $filename, 'public');

                    // Save ONLY folder/file — NOT full "storage/products"
                    $product->images()->create([
                        'image_path' => "products/$filename",
                    ]);
                }
            }

            DB::commit();
            return response()->json([
                'success' => 'Product created successfully.',
                'url' => route('products.index')
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function edit($id)
    {
        $product = Product::with(['images', 'skus'])->findOrFail($id);
        $categories = Category::where('status', 1)->get();
        $subcategories = SubCategory::where('category_id', $product->category_id)->get();

        return view('backend.products.edit', compact('product', 'categories', 'subcategories'));
    }


    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $product = Product::findOrFail($id);

            $request->validate([
                'name' => 'required|string|max:255',
                'category_id' => 'required',
                'subcategory_id' => 'required',
                'description' => 'nullable',
                'status' => 'required|boolean',
                'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
                'skus' => 'required|array|min:1',
                'skus.*.sku' => 'required|string',
                'skus.*.attribute' => 'required|string',
                'skus.*.stock' => 'required|integer|min:0',
                'skus.*.price' => 'required|numeric|min:0',
            ]);

            $skuData = collect($request->input('skus'));
            $basePrice = $skuData->min('price');

            // UPDATE PRODUCT
            $product->update([
                'name' => $request->name,
                'slug' => str()->slug($request->name),
                'category_id' => $request->category_id,
                'subcategory_id' => $request->subcategory_id,
                'description' => $request->description,
                'price' => $basePrice,
                'status' => $request->status,
            ]);

            // REPLACE SKUS (simple approach)
            $product->skus()->delete();
            $product->skus()->createMany($skuData->map(function ($sku) {
                return [
                    'sku' => $sku['sku'],
                    'attribute' => $sku['attribute'],
                    'stock' => $sku['stock'],
                    'price' => $sku['price'],
                ];
            })->toArray());

            // ⭐ MULTIPLE NEW IMAGES UPLOAD
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $img) {
                    $filename = time() . '_' . $img->getClientOriginalName();
                    $img->storeAs('products', $filename, 'public');

                    $product->images()->create([
                        'image_path' => "products/$filename",
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('products.index')
                ->with('success', 'Product updated successfully.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }


    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Also delete product images
        foreach ($product->images as $img) {
            $path = storage_path('app/public/' . $img->image_path);
            if (file_exists($path)) unlink($path);
            $img->delete();
        }

        $product->delete();
        return response()->json(['status' => 'success']);
    }
}
