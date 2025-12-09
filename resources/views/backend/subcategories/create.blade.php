@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-xl p-6">

    <div class="bg-white shadow rounded-lg p-6 border">
        <h2 class="text-xl font-semibold mb-4">Add SubCategory</h2>

        <form method="POST" action="{{ route('subcategories.store') }}" id="crudForm">
            @csrf

            {{-- Category --}}
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Category</label>
                <select name="category_id" id="category_id" class="w-full select2" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $id => $name)
                        <option value="{{ $id }}" {{ old('category_id') == $id ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id') 
                    <small class="text-red-500">{{ $message }}</small> 
                @enderror
            </div>

            {{-- Name --}}
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Name</label>
                <input type="text" name="name"
                       class="w-full px-3 py-2 border rounded-md focus:ring focus:ring-blue-300 focus:border-blue-500"
                       placeholder="Enter subcategory name" required>
            </div>

            {{-- Slug (optional if you want it like categories) --}}
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Slug</label>
                <input type="text" name="slug"
                       class="w-full px-3 py-2 border rounded-md focus:ring focus:ring-purple-300 focus:border-purple-500"
                       placeholder="subcategory-slug-here"
                       pattern="[a-z0-9-]+"
                       title="Slug should contain only lowercase letters, numbers, and hyphens."
                       required>
                <small class="text-gray-500">Slug must be lowercase, no spaces, only: a-z, 0-9, -</small>
            </div>

            {{-- Status --}}
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Status</label>
                <select name="status"
                        class="w-full px-3 py-2 border rounded-md focus:ring focus:ring-blue-300 focus:border-blue-500">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>

            {{-- Buttons --}}
            <div class="flex justify-end gap-3 mt-5">
                <a href="{{ route('subcategories.index') }}"
                   class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition">
                    Cancel
                </a>

                <button type="submit" id="crudFormSave"
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                    Create
                </button>
            </div>

        </form>
    </div>

</div>
@endsection

@push('scripts')
<script>
$(document).ready(function(){
    $('.select2').select2({ width: '100%' });

    // Auto-generate slug (same behavior as categories form)
    $('input[name="name"]').on('keyup', function () {
        let slug = $(this).val()
            .toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-+|-+$/g, '');

        $('input[name="slug"]').val(slug);
    });
});
</script>
@endpush
