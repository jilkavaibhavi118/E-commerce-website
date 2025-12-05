@extends('layouts.app')

@section('title', ucfirst($role->name) . ' Permissions')

@section('content')
<div class="container-fluid">

    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4>{{ ucfirst($role->name) }} Role Permissions</h4>

                    <div>
                        <button onclick="selectAllPermissions()" class="btn btn-success btn-sm">Select All</button>
                        <button onclick="unselectAllPermissions()" class="btn btn-danger btn-sm">Unselect All</button>
                    </div>
                </div>

                <div class="card-body">
                    <form id="crudForm" method="POST"
                          action="{{ route('roles.permissions.store', $role->id) }}">
                        @csrf

                        <div class="all-permissions">
                            @php
                                // Group permissions by prefix (product.create -> product)
                                $grouped = collect($permissions)->groupBy(function ($p) {
                                    return explode('.', $p->name)[0];
                                });
                            @endphp

                            @foreach ($grouped as $group => $perms)
                                <div class="row mb-3">
                                    <label class="col-md-2 fw-bold">{{ ucfirst($group) }}</label>

                                    <div class="col-md-10">
                                        @foreach ($perms as $permission)
                                            <div class="form-check form-check-inline">

                                                <input type="checkbox"
                                                       class="form-check-input"
                                                       name="permission[]"
                                                       value="{{ $permission->name }}"
                                                       id="permission-{{ $permission->id }}"
                                                       @checked(in_array($permission->name, $selectedPermissions))


                                                <label class="form-check-label"
                                                       for="permission-{{ $permission->id }}">
                                                    {{ strtoupper(explode('.', $permission->name)[1] ?? '') }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </form>
                </div>

                <div class="card-footer d-flex justify-content-end">
                    <button id="crudFormSave" class="btn btn-primary">Update</button>
                </div>

            </div>

        </div>
    </div>

</div>
@endsection


@push('js')
<script>
    // -------------------------
    // SELECT / UNSELECT ALL
    // -------------------------
    function selectAllPermissions() {
        $("input[type='checkbox']").prop("checked", true);
    }

    function unselectAllPermissions() {
        $("input[type='checkbox']").prop("checked", false);
    }
</script>
@endpush
