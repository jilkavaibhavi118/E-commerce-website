<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller; 
use App\Models\Subcategory;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

use Illuminate\Support\Str;

class SubcategoryController extends Controller
{
    // public function __construct()
    // {
    //     // You can add middleware for permissions here if needed
    //     $this->middleware('can:subcategories.view')->only(['index']);
    // }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Subcategory::with('category')->select('subcategories.*');

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="row-checkbox" value="' . $row->id . '">';
                })
                ->addColumn('category', fn($row) => $row->category?->name ?? '-')
                ->addColumn('status', function ($row) {
                    return $row->status ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-secondary">Inactive</span>';
                })
                ->addColumn('action', function ($row) {
                    // Pass the current category to the action view
                    return view('layouts.includes.list-action', [
                        'data' => $row,
                        'module' => 'subcategories'
                    ])->render();
                    
                    
                })
                ->rawColumns(['checkbox','status','action'])
                ->make(true);
        }

        return view('backend.subcategories.index');
    }

    public function create()
    {
        $categories = Category::where('status', 1)->pluck('name', 'id');
        return view('backend.subcategories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:191|unique:subcategories,name',
            'status' => 'nullable|boolean',
        ]);

        $data = $request->only('category_id','name','status');
        $data['slug'] = Str::slug($data['name']);

        Subcategory::create($data);

        return redirect()->route('backend.subcategories.index')->with('success', 'Subcategory created successfully.');
    }

    public function edit(Subcategory $subcategory)
    {
        $categories = Category::where('status', 1)->pluck('name', 'id');
        return view('backend.subcategories.edit', compact('subcategory', 'categories'));
    }

    public function update(Request $request, Subcategory $subcategory)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:191|unique:subcategories,name,' . $subcategory->id,
            'status' => 'nullable|boolean',
        ]);

        $data = $request->only('category_id','name','status');
        $data['slug'] = Str::slug($data['name']);

        $subcategory->update($data);

        return redirect()->route('subcategories.index')->with('success', 'Subcategory updated successfully.');
    }

    public function show(Subcategory $subcategory)
{
    return view('backend.subcategories.show', compact('subcategory'));
}


    public function destroy(Subcategory $subcategory)
    {
        $subcategory->delete();
        return response()->json(['success' => 'Subcategory deleted successfully.']);
    }

    /**
     * Mass destroy.
     */
    public function massDestroy(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!is_array($ids) || empty($ids)) {
            return response()->json(['message' => 'No items selected.'], 422);
        }

        Subcategory::whereIn('id', $ids)->delete();
        return response()->json(['success' => 'Selected subcategories deleted.']);
    }

    /**
     * API: return subcategories for a category (useful for dependent selects)
     */
    public function byCategory($category_id)
    {
        return response()->json(
            Subcategory::where('category_id', $category_id)->get()
        );
    }
    
}
