@extends('layouts.app')

@section('title', 'Brand Details')

@section('content')
<div class="container mx-auto max-w-xl p-6">

    <div class="bg-white shadow rounded-lg p-6 border">

        {{-- Header --}}
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">{{ $brand->name }}</h2>

            <a href="{{ route('brands.index') }}"
               class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition">
                Back
            </a>
        </div>

        {{-- Details --}}
        <div class="space-y-4">

            {{-- Name --}}
            <div>
                <p class="text-sm text-gray-600 font-medium">Name</p>
                <p class="text-lg font-semibold text-gray-800">{{ $brand->name }}</p>
            </div>

            {{-- Slug --}}
            <div>
                <p class="text-sm text-gray-600 font-medium">Slug</p>
                <p class="text-gray-800">{{ $brand->slug }}</p>
            </div>

            {{-- Status --}}
            <div>
                <p class="text-sm text-gray-600 font-medium">Status</p>

                @if($brand->status)
                    <span class="px-3 py-1 text-sm rounded-full bg-green-100 text-green-700">
                        Active
                    </span>
                @else
                    <span class="px-3 py-1 text-sm rounded-full bg-red-100 text-red-700">
                        Inactive
                    </span>
                @endif
            </div>

            {{-- Logo --}}
            <div class="pt-4">
                <p class="text-sm text-gray-600 font-medium mb-2">Logo</p>

                @if($brand->logo)
                    <img src="{{ asset('storage/' . $brand->logo) }}"
                         alt="Brand Logo"
                         class="w-32 h-32 object-cover border rounded-md shadow-sm">
                @else
                    <p class="text-gray-500 italic">No logo uploaded.</p>
                @endif
            </div>

        </div>

    </div>

</div>
@endsection
