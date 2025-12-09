<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller; 
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class BrandController extends Controller
{
    // LIST PAGE
    public function index()
    {
        if (request()->ajax()) {
            $brands = Brand::latest()->get();

            return DataTables::of($brands)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    return $row->status
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('logo', function ($row) {
                    if ($row->logo) {
                        return '<img src="' . asset('storage/' . $row->logo) . '" width="60">';
                    }
                    return '—';
                })
                ->addColumn('action', function ($row) {
                    return view('layouts.includes.list-action', [
                        'data' => $row,
                        'module' => 'brands',
                    ])->render();
                })
                ->rawColumns(['status', 'logo', 'action'])
                ->make(true);
        }

        return view('backend.brands.index');
    }

    // CREATE PAGE
    public function create()
    {
        return view('backend.brands.create');
    }

    // STORE
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required|unique:brands,name',
            'logo'  => 'nullable|image|max:2048',
            'status'=> 'required|boolean',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $brand = new Brand();
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);

        if ($request->hasFile('logo')) {
            $brand->logo = $request->logo->store('brands', 'public');
        }

        $brand->status = $request->status ?? 1;
        $brand->save();

        return response()->json([
            'success' => 'Brand created successfully.',
            'url' => route('brands.index')
        ]);
    }

    // SHOW
    public function show($id)
    {
        $brand = Brand::findOrFail($id);
        return view('backend.brands.show', compact('brand'));
    }

    // EDIT PAGE
    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        return view('backend.brands.edit', compact('brand'));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name'  => 'required|unique:brands,name,' . $id,
            'logo'  => 'nullable|image|max:2048',
            'status'=> 'required|boolean',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);

        if ($request->hasFile('logo')) {
            // delete old if exists
            if ($brand->logo) {
                Storage::disk('public')->delete($brand->logo);
            }
            $brand->logo = $request->logo->store('brands', 'public');
        }

        $brand->status = $request->status;
        $brand->save();

        
        return response()->json([
            'success' => 'Brand Updated successfully.',
            'url' => route('brands.index')
        ]);
    }

    // DELETE
    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);

        if ($brand->logo) {
            Storage::disk('public')->delete($brand->logo);
        }

        $brand->delete();

        return redirect()->route('brands.index')->with('success', 'Brand deleted successfully');
    }
}
