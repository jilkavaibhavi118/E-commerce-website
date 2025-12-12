@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Add Subcategory</h3>

    <form action="{{ route('admin.subcategories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Category Selection --}}
        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select name="category_id" id="category_id" class="form-control select2" required>
                <option value="">Select Category</option>
                @foreach($categories as $id => $name)
                    <option value="{{ $id }}" {{ old('category_id') == $id ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Subcategory Name --}}
        <div class="mb-3">
            <label for="name" class="form-label">Subcategory Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Description --}}
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
        </div>

        {{-- Status --}}
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        {{-- Image Upload --}}
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>

        {{-- Submit Button --}}
        <button type="submit" class="btn btn-success">Create Subcategory</button>
        <a href="{{ route('admin.subcategories.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('.select2').select2({ width: '100%' });
    });
</script>
@endpush
@endsection
