@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Subcategory</h3>

    <form method="POST" action="{{ route('subcategories.update', $subcategory->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Category</label>
            <select name="category_id" id="category_id" class="form-control select2" required>
                <option value="">Select Category</option>
                @foreach($categories as $id => $name)
                    <option value="{{ $id }}" {{ (old('category_id', $subcategory->category_id) == $id) ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
            </select>
            @error('category_id') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label>Name</label>
            <input name="name" class="form-control" value="{{ old('name', $subcategory->name) }}" required>
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="1" {{ old('status', $subcategory->status) == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ old('status', $subcategory->status) == 0 ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('subcategories.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function(){
    $('.select2').select2({ width: '100%' });
});
</script>
@endpush
