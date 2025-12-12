@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white p-5 shadow rounded">
        <h2 class="text-xl font-bold mb-4">SubCategory Details</h2>

        <p><strong>Category:</strong> {{$categories->name }}</p>
        <p><strong>Name:</strong> {{ $categories->name }}</p>
        <p><strong>Slug:</strong> {{ $categories->slug }}</p>
        <p><strong>Status:</strong>
            <span class="badge {{ $categories->status ? 'bg-success' : 'bg-secondary' }}">
                {{ $categories->status ? 'Active' : 'Inactive' }}
            </span>
        </p>

        <div class="flex gap-3">
            <a href="{{ route('categories.index') }}"
                   class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition">
                    Cancel
                </a>
        </div>
    </div>
</div>
@endsection
