<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Category::latest()->get(); // Fetch all categories

            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    return $row->status
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('action', function ($row) {
                    // Pass the current category to the action view
                    return view('layouts.includes.list-action', ['data' => $row, 'module' => 'categories'])->render();
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('backend.categories.index');
    }


    public function create()
    {
        return view('backend.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name|max:255'
        ]);

        Category::create($request->all());

        return response()->json(['success' => 'Category Added Successfully', 'url' => route('categories.index')]);
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('backend.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|max:255|unique:categories,name,' . $id
        ]);

        $category->update($request->all());

        return response()->json(['success' => 'Category updated Successfully', 'url' => route('categories.index')]);
    }

    public function show(Category $categories)
    {
        return view('backend.categories.show', compact('categories'));
    }


    public function destroy($id)
    {
        Category::findOrFail($id)->delete();

        return response()->json(['message' => 'Category deleted successfully!']);
    }
}
