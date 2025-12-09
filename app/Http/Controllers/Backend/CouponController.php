<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller; 

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class CouponController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $coupons = Coupon::latest()->get();

            return DataTables::of($coupons)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    return $row->status
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('action', function ($row) {
                    return view('layouts.includes.list-action', [
                        'data' => $row,
                        'module' => 'coupons',
                    ])->render();
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('backend.coupons.index');
    }

    public function create()
    {
        return view('backend.coupons.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code'          => 'required|unique:coupons,code',
            'type'          => 'required|in:percentage,fixed',
            'value'         => 'required|numeric|min:1',
            'min_cart_value'=> 'nullable|numeric|min:0',
            'max_uses'      => 'required|integer|min:1',
            'max_uses_user' => 'required|integer|min:1',
            'start_date'    => 'required|date',
            'end_date'      => 'required|date|after_or_equal:start_date',
            'status'        => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Coupon::create($validator->validated());

        return response()->json([
            'success' => 'Cupon Created successfully.',
            'url' => route('coupons.index')
        ]);
    }

    public function show(Coupon $coupon)
    {
        return view('backend.coupons.show', compact('coupon'));
    }
    public function edit(Coupon $coupon)
    {
        return view('backend.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $validator = Validator::make($request->all(), [
            'code'          => 'required|unique:coupons,code,' . $coupon->id,
            'type'          => 'required',
            'value'         => 'required|numeric|min:1',
            'min_cart_value'=> 'nullable|numeric|min:0',
            'max_uses'      => 'required|integer|min:1',
            'max_uses_user' => 'required|integer|min:1',
            'start_date'    => 'required|date',
            'end_date'      => 'required|date|after_or_equal:start_date',
            'status'        => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $coupon->update($validator->validated());

        return response()->json([
            'success' => 'Cupon Updated successfully.',
            'url' => route('coupons.index')
        ]);
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->route('coupons.index')->with('success', 'Coupon deleted.');
    }
}
