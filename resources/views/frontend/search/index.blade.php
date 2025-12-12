@extends('frontend.layouts.app')

@section('content')

<div class="max-w-7xl mx-auto py-6">

    <h2 class="text-2xl font-bold mb-4">
        Search results for: <span class="text-blue-600">"{{ $query }}"</span>
    </h2>

    @if($products->count() === 0)
        <p class="text-gray-600">No products found.</p>
    @endif

    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">

        @foreach($products as $product)
        <a href="{{ route('product.details', $product->id) }}"
           class="bg-white shadow rounded p-4 hover:shadow-lg transition">

            <img src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                 class="w-full h-40 object-cover rounded">

            <h3 class="mt-3 font-semibold text-gray-800">
                {{ $product->name }}
            </h3>

            <p class="text-green-600 font-bold mt-1">₹{{ $product->price }}</p>

        </a>
        @endforeach

    </div>

    <div class="mt-6">
        {{ $products->links() }}
    </div>

</div>

@endsection
