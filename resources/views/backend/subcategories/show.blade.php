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

        <a href="{{ route('subcategories.index') }}" class="btn btn-primary mt-3">
            Back
        </a>
    </div>
</div>
@endsection
