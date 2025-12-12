<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    // GET /api/categories
   public function index()
   {
       try {
            $categories = Category::latest()->get();

            return response()->json([
                'status' => true,
                'data' => $categories
            ], 200);

       } catch (\Exception $e) {
              return response()->json([
                    'status' => false,
                    'error' =>$e->getMessage()
              ], 500);

       }
   }

   // GET /api/categories/{category}
   public function show(Category $category)
   {
    try {
        return response()->json([
            'status' => true,
            'data' => $category
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'data' => $e->getMessage()
        ], 500);

    }
   }

   // POST /api/categories (protected)
   public function store(Request $request)
   {
     try {
        $data = $request->validate([
                'name' => 'required|string|max:255|unique:categories,name',
                'slug' => 'nullable',
                'status' => 'nullable|boolean',
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $category = Category::create($data);

        return response()->json([
            'status' => true,
            'message' => 'Category Created Successfully',
            'data' => $category
        ], 201);

     } catch (\Illuminate\Validation\ValidationException $ex) {
        return response()->json([
            'status' => false,
            'errors' => $ex->errors()
        ],422);

     } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'error' => $e->getMessage()
        ], 500);
     }

   }

   // PUT /api/categories/{category}
   public function update(Request $request, Category $category)
   {
    try {
        $data = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')->ignore($category->id)
            ],
            'slug' => 'nullable',
            'status' => 'nullable|boolean',
        ]);

        if (!isset($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

         $category->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Category Upadetd Successfully',
            'data' => $category
        ], 201);

     } catch (\Illuminate\Validation\ValidationException $ex) {
        return response()->json([
            'status' => false,
            'errors' => $ex->errors()
        ],422);

     } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'error' => $e->getMessage()
        ], 500);
     }

   }

   public function destroy(Category $category)
   {
    try {
        $category->delete();

        return response()->json([
            'status' => true,
            'message' => 'Category Deleted Successfully!',
        ], 200);

    } catch (\Exception $e) {
          return response()->json([
            'status' => false,
            'errors' => $e->getMessage()
          ]);
    }
   }

}


