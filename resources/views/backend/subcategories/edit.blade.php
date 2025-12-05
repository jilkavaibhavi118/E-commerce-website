@extends('layouts.app')

@section('content')
<div class="container">
    <h3>{{ isset($subcategory) ? 'Edit' : 'Add' }} Subcategory</h3>

    <form action="{{ isset($subcategory) ? route('admin.subcategories.update', $subcategory->id) : route('admin.subcategories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($subcategory)) @method('PUT') @endif

        <div class="mb-3">
            <label>Category</label>
            <select name="category_id" class="form-control select2" required>
                <option value="">Select Category</option>
                @foreach($categories as $id => $name)
                    <option value="{{ $id }}" {{ (isset($subcategory) && $subcategory->category_id == $id) ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ $subcategory->name ?? old('name') }}" required>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ $subcategory->description ?? old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="1" {{ (isset($subcategory) && $subcategory->status) ? 'selected' : '' }}>Active</option>
                <option value="0" {{ (isset($subcategory) && !$subcategory->status) ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Image</label>
            <input type="file" name="image" class="form-control">
            @if(isset($subcategory) && $subcategory->image)
                <img src="{{ asset('storage/' . $subcategory->image) }}" width="80" class="mt-2">
            @endif
        </div>

        <button type="submit" class="btn btn-success">{{ isset($subcategory) ? 'Update' : 'Create' }}</button>
    </form>
</div>

@push('scripts')
<script>
$('.select2').select2({ width: '100%' });
</script>
@endpush
@endsection
