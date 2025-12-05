@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Subcategories</h3>
    <a href="{{ route('subcategories.create') }}" class="btn btn-primary mb-3">+ Add Subcategory</a>
    <table class="table table-bordered" id="subcategory-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Category</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
    </table>
</div>

@push('scripts')
<script>
$(function() {
    $('#subcategory-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('subcategories.index') !!}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'name', name: 'name' },
            { data: 'category', name: 'category' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });
});
</script>
@endpush
@endsection
