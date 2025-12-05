<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use App\Models\Category;
use Illuminate\Http\Request;
use Str;
use Yajra\DataTables\DataTables;

class SubcategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $subcategories = Subcategory::with('category')->latest();
            return Datatables::of($subcategories)
                ->addIndexColumn()
                ->addColumn('category', fn($row) => $row->category->name)
                ->addColumn('action', fn($row) => view('admin.subcategories.actions', compact('row'))->render())
                ->editColumn('status', fn($row) => $row->status ? 'Active' : 'Inactive')
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
            'name' => 'required|unique:subcategories,name',
            'category_id' => 'required|exists:categories,id',

        ]);

        $data = $request->only('name', 'category_id', 'description', 'status');
        $data['slug'] = Str::slug($request->name);

        Subcategory::create($data);

        return redirect()->route('backend.subcategories.index')->with('success', 'Subcategory created successfully.');
    }

    public function edit(Subcategory $subcategory)
    {
        $categories = Category::where('status', 1)->pluck('name', 'id');
        return view('admin.subcategories.edit', compact('subcategory', 'categories'));
    }

    public function update(Request $request, Subcategory $subcategory)
    {
        $request->validate([
            'name' => 'required|unique:subcategories,name,' . $subcategory->id,
            'category_id' => 'required|exists:categories,id',

        ]);

        $data = $request->only('name', 'category_id','status');
        $data['slug'] = Str::slug($request->name);



        $subcategory->update($data);

        return redirect()->route('subcategories.index')->with('success', 'Subcategory updated successfully.');
    }

    public function destroy(Subcategory $subcategory)
    {
        if ($subcategory->image) {
            Storage::disk('public')->delete($subcategory->image);
        }
        $subcategory->delete();

        return response()->json(['success' => 'Subcategory deleted successfully.']);
    }
}
