<div class="d-flex gap-1 align-items-center">
    @php $module2 = $module2 ?? $module; @endphp

    {{-- VIEW --}}
    @can($module.'.view')
        <a href="{{ route($module2.'.show', $data->id) }}" class="btn btn-info btn-sm">
            <i class="fa fa-eye"></i>
        </a>
    @endcan

  {{-- EDIT ICON FOR CATEGORIES --}}
@if($module == "categories")
@can('categories.edit')
    <a href="{{ route('categories.edit', $data->id) }}"
       class="btn btn-primary btn-sm"
       title="Edit Category">
        <i class="fa fa-pencil-alt"></i>
    </a>
@endcan
@endif


    {{-- ONLY FOR ROLES --}}
    @if($module == "roles")
        @can('roles.permissions')
            <a href="{{ route('roles.permissions', $data->id) }}" class="btn btn-warning btn-sm">
                <i class="fa fa-key"></i>
            </a>
        @endcan
    @endif

    {{-- DELETE --}}
    @can($module.'.delete')
        <form action="{{ route($module2.'.destroy', $data->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm">
                <i class="fa fa-trash"></i>
            </button>
        </form>
    @endcan
</div>
