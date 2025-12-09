@extends('layouts.app')

@section('title', 'Edit Brand')

@section('content')
<div class="container mx-auto max-w-xl p-6">

    <div class="bg-white shadow rounded-lg p-6 border">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Edit Brand</h2>

        </div>

        <form action="{{ route('brands.update', $brand->id) }}" method="POST" enctype="multipart/form-data" id="crudForm">
            @csrf
            @method('PUT')

            {{-- Brand Name --}}
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Brand Name</label>

                <input type="text" name="name"
                       class="w-full px-3 py-2 border rounded-md focus:ring focus:ring-blue-300 focus:border-blue-500"
                       value="{{ old('name', $brand->name) }}" required>

                @error('name')
                    <small class="text-red-600">{{ $message }}</small>
                @enderror
            </div>

            {{-- Brand Logo --}}
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Brand Logo</label>

                <input type="file" name="logo"
                       class="w-full px-3 py-2 border rounded-md focus:ring focus:ring-purple-300 focus:border-purple-500">

                @if($brand->logo)
                <div class="mt-3">
                    <img src="{{ asset('storage/' . $brand->logo) }}"
                         alt="Brand Logo"
                         class="w-24 h-24 object-cover border rounded-md shadow-sm">
                </div>
                @endif

                @error('logo')
                    <small class="text-red-600">{{ $message }}</small>
                @enderror
            </div>

            {{-- Status --}}
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Status</label>

                <select name="status"
                        class="w-full px-3 py-2 border rounded-md focus:ring focus:ring-blue-300 focus:border-blue-500">
                    <option value="1" {{ old('status', $brand->status) == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('status', $brand->status) == 0 ? 'selected' : '' }}>Inactive</option>
                </select>

                @error('status')
                    <small class="text-red-600">{{ $message }}</small>
                @enderror
            </div>

            {{-- Buttons --}}
            <div class="flex justify-end gap-3">
                <a href="{{ route('brands.index') }}"
                   class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition">
                    Cancel
                </a>

                <button type="submit" id="crudFormSave"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                    Update
                </button>
            </div>

        </form>
    </div>

</div>
@endsection
