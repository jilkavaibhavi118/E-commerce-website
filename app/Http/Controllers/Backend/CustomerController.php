<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $customers = User::role('customer')->latest()->get();

            return DataTables::of($customers)
                ->addIndexColumn()
                ->addColumn('phone', function ($row) {
                    return $row->phone ?? '—';
                })
                ->addColumn('status', function ($row) {
                    return $row->status
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('action', function ($row) {
                    return view('layouts.includes.list-action', [
                        'data' => $row,
                        'module' => 'customers',
                    ])->render();
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('backend.customers.index');
    }

    public function create()
    {
        return view('backend.customers.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'nullable|string|max:20',
            'password' => 'required|min:6',
            'status'   => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'status'   => $request->status,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('customer');

        return response()->json([
            'success' => 'Customer created successfully.',
            'url' => route('customers.index')
        ]);
    }

    public function show(User $customer)
    {
        return view('backend.customers.show', compact('customer'));
    }

    public function edit(User $customer)
    {
        return view('backend.customers.edit', compact('customer'));
    }

    public function update(Request $request, User $customer)
    {
        $validator = Validator::make($request->all(), [
            'name'   => 'required|max:255',
            'email'  => 'required|email|unique:users,email,' . $customer->id,
            'phone'  => 'nullable|string|max:20',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $customer->name   = $request->name;
        $customer->email  = $request->email;
        $customer->phone  = $request->phone;
        $customer->status = $request->status;

        if ($request->password) {
            $customer->password = Hash::make($request->password);
        }

        $customer->save();

        return response()->json([
            'success' => 'Customer Updated successfully.',
            'url' => route('customers.index')
        ]);
    }

    public function destroy(User $customer)
    {
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully!');
    }
}
