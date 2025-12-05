@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-xl p-6">

    <div class="bg-white shadow rounded-lg p-6 border">
        <h2 class="text-xl font-semibold mb-4">Add Category</h2>

        <form action="{{ route('categories.store') }}" method="POST" id="crudForm">
            @csrf

            {{-- Category Name --}}
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Name</label>
                <input type="text" name="name"
                       class="w-full px-3 py-2 border rounded-md focus:ring focus:ring-blue-300 focus:border-blue-500"
                       placeholder="Enter category name" required>
            </div>

            {{-- Category Slug --}}
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Slug</label>
                <input type="text" name="slug"
                       class="w-full px-3 py-2 border rounded-md focus:ring focus:ring-purple-300 focus:border-purple-500"
                       placeholder="category-slug-here"
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
            <div class="flex justify-end gap-3">
                <a href="{{ route('categories.index') }}"
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
