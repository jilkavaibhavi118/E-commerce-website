@extends('layouts.app')

@section('title', 'Coupons')

@section('content')
<style>
    /* Same styling as categories index */
    .custom-card { background:#ffffff; border-radius:10px; padding:0; box-shadow:0px 4px 12px rgba(0,0,0,0.08); overflow:hidden; }
    .custom-card-header { padding:18px 22px; background:#f8f9fc; border-bottom:1px solid #e9ecef; display:flex; justify-content:space-between; align-items:center; }
    .custom-card-header h4 { margin:0; font-size:18px; font-weight:600; }
    .add-btn { background:#4e73df; color:#fff; padding:8px 14px; font-size:13px; font-weight:600; border-radius:6px; text-decoration:none; transition:0.2s ease-in-out; }
    .add-btn:hover { background:#3558c7; color:#fff; }
    table.dataTable { border-collapse: collapse !important; width: 100% !important; }
    table.dataTable th { background: #f1f3f9; font-size: 13px; padding: 10px; text-transform: uppercase; letter-spacing: .5px; }
    table.dataTable td { padding: 10px; font-size: 14px; }
    @media(max-width: 768px) { .custom-card-header { flex-direction: column; align-items: flex-start; gap: 10px; } }
</style>

<div class="container-fluid">
    <div class="col-12">
        <div class="custom-card">
            <div class="custom-card-header">
                <h4>Coupons List</h4>
                <a href="{{ route('coupons.create') }}" class="add-btn">
                    <i class="fa fa-plus"></i> Add Coupon
                </a>
            </div>

            <div class="card-body p-3">
                <div class="table-responsive">
                    <table id="couponsTable" class="display" style="min-width: 100%; width: 100%;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Code</th>
                                <th>Type</th>
                                <th>Value</th>
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

@section('scripts')
<script>
$(function () {
    $('#couponsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('coupons.index') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'code', name: 'code' },
            { data: 'type', name: 'type' },
            { data: 'value', name: 'value' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });
});
</script>
@endsection
