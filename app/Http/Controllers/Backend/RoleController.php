<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StoreRole;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        abort_if(!auth()->user()->can('roles.view'), 403);
        if ($request->ajax()) {
            $roles = Role::query();

            return DataTables::of($roles)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    return view('layouts.includes.list-action', compact('data'))->with('module', 'roles');
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('backend.roles.index');
    }

    public function create()
    {
        abort_if(!auth()->user()->can('roles.create'), 403);
        return view('backend.roles.create');
    }

    public function store(StoreRole $request)
    {
        Role::create(['name' => $request->name]);
        return response()->json(['success' => 'Role Added Successfully', 'url' => route('roles.index')]);
    }

    public function show($id)
    {
        abort_if(!auth()->user()->can('roles.view'), 403);
        $role = Role::findOrFail($id);
        $permissions = $role->permissions;
        return view('backend.roles.show', compact('role', 'permissions'));
    }

    public function edit($id)
    {
        abort_if(!auth()->user()->can('roles.edit'), 403);
        $role = Role::findOrFail($id);
        return view('backend.roles.edit', compact('role'));
    }

    public function update(StoreRole $request, $id)
    {
        Role::findOrFail($id)->update(['name' => $request->name]);
        return response()->json(['success' => 'Role Updated Successfully', 'url' => route('admin.roles.index')]);
    }

    public function massDestroy(Request $request)
    {
        abort_if(!auth()->user()->can('roles.delete'), 403);

        $roles = Role::find(request('ids'));
        foreach ($roles as $role) {
            // Force Delete
            $role->users()->sync([]); // Delete relationship data
            $role->permissions()->sync([]); // Delete relationship data

            $role->delete();
        }

        return response()->json(['success' => 'Roles Deleted Successfully', 'url' => route('admin.roles.index')]);
    }

    public function permissions(Role $role)
    {
        abort_if(!auth()->user()->can('roles.permissions'), 403);
        $permissions = Permission::all();
        $selectedPermissions = $role->permissions->pluck('name')->toArray();
        return view('backend.roles.permission', compact('role', 'permissions', 'selectedPermissions'));
    }

    public function permissionsStore(Role $role, Request $request)
    {
        $role->syncPermissions($request->permissions);
        return response()->json(['success' => 'Role Permissions Updated Successfully', 'url' => route('admin.roles.index')]);
    }

    public function destroy($id)
    {
        abort_if(!auth()->user()->can('roles.delete'), 403);

        $role = Role::findOrFail($id);
        $role->delete();
        return response()->json(['success' => 'Role Deleted Successfully']);
    }
}
