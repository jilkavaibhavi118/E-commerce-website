<div class="d-flex gap-1 align-items-center">
    @php
        // Use module unless module2 is provided
        $module2 = $module2 ?? $module;
    @endphp

    {{-- VIEW --}}
    @can($module . '.view')
        <a href="{{ route($module2 . '.show', $data->id) }}" class="btn btn-info btn-sm" title="View">
            <i class="fa fa-eye"></i>
        </a>
    @endcan

    {{-- EDIT (Dynamic for any module) --}}
    @can($module . '.edit')
        <a href="{{ route($module2 . '.edit', $data->id) }}"
           class="btn btn-primary btn-sm"
           title="Edit">
            <i class="fa fa-pencil-alt"></i>
        </a>
    @endcan


    @php
        // Fix route prefix ONLY for orders
        // if ($module == "orders") {
        //     $module2 = "admin.orders";
        // } else {
        //     $module2 = $module2 ?? $module;
        // }
    @endphp




    {{-- ONLY FOR ROLES --}}
    @if($module == "roles")
        @can('roles.permissions')
            <a href="{{ route('roles.permissions', $data->id) }}" class="btn btn-warning btn-sm" title="Permissions">
                <i class="fa fa-key"></i>
            </a>
        @endcan
    @endif

    {{-- DELETE --}}
    @can($module . '.delete')
        <a href="javascript:;" data-url="{{ route($module2 . '.destroy', $data->id) }}" class="btn btn-danger btn-sm delete-btn" title="Delete">
            <i class="fa fa-trash"></i>
        </a>
    @endcan
</div>
