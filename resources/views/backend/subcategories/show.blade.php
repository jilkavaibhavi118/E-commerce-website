@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white p-5 shadow rounded">
        <h2 class="text-xl font-bold mb-4">SubCategory Details</h2>

        <p><strong>Category:</strong> {{ $subcategory->category->name }}</p>
        <p><strong>Name:</strong> {{ $subcategory->name }}</p>
        <p><strong>Slug:</strong> {{ $subcategory->slug }}</p>
        <p><strong>Status:</strong>
            <span class="badge {{ $subcategory->status ? 'bg-success' : 'bg-secondary' }}">
                {{ $subcategory->status ? 'Active' : 'Inactive' }}
            </span>
        </p>

    <div class="flex justify-end gap-3 mt-5">
        <a href="{{ route('subcategories.index') }}"
                   class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition">
                    Cancel
                </a>
    </div>

    </div>
</div>
@endsection
