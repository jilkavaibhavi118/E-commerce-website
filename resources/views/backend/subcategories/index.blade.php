@extends('layouts.app')

@section('title', 'SubCategories')

@section('content')
<style>
    /* ---------------------------
       CUSTOM PAGE CSS
    -----------------------------*/

    /* Card */
    .custom-card {
        background: #ffffff;
        border-radius: 10px;
        padding: 0;
        box-shadow: 0px 4px 12px rgba(0,0,0,0.08);
        overflow: hidden;
    }

    .custom-card-header {
        padding: 18px 22px;
        background: #f8f9fc;
        border-bottom: 1px solid #e9ecef;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .custom-card-header h4 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
    }

    /* Add Category Button */
    .add-btn {
        background: #4e73df;
        color: #fff;
        padding: 8px 14px;
        font-size: 13px;
        font-weight: 600;
        border-radius: 6px;
        text-decoration: none;
        transition: 0.2s ease-in-out;
    }

    .add-btn:hover {
        background: #3558c7;
        color: #fff;
    }

    /* Table Styling */
    table.dataTable {
        border-collapse: collapse !important;
        width: 100% !important;
    }

    table.dataTable th {
        background: #f1f3f9;
        font-size: 13px;
        padding: 10px;
        text-transform: uppercase;
        letter-spacing: .5px;
    }

    table.dataTable td {
        padding: 10px;
        font-size: 14px;
    }

    /* Responsive */
    @media(max-width: 768px) {
        .custom-card-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }
    }
</style>

<div class="container-fluid">
    <div class="col-12">
        <div class="custom-card">

            <div class="custom-card-header">
                <h4>SubCategories List</h4>

                <a href="{{ route('subcategories.create') }}" class="add-btn">
                    <i class="fa fa-plus"></i> Add SubCategory
                </a>
            </div>

            <div class="card-body p-3">
                <div class="table-responsive">
                    <table id="SubCategoriesTable" class="display" style="min-width: 850px; width: 100%;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Category</th>
                                <th>Sub Category</th>
                                <th>Slug</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('js')
<script>
$(document).ready(function() {
    $('#SubCategoriesTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('subcategories.index') }}",
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'category', name: 'category'},
            { data: 'name', name: 'name' },
            { data: 'slug', name: 'slug' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
        order: [[1, 'desc']],
    });
});
</script>
@endpush
