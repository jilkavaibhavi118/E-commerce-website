@extends('frontend.layouts.app')

@section('content')

<div class="max-w-6xl mx-auto p-6">

    <!-- Back Button -->
    <a href="{{ url()->previous() }}" class="text-blue-600 hover:underline mb-4 inline-block">
        ← Back to Products
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 bg-white shadow rounded p-6">

        <!-- LEFT: Product Image -->
        <div>
            @php
                $image = $product->images->first()->image_path ?? null;
            @endphp

            <img src="{{ $image ? asset('storage/' . $image) : 'https://via.placeholder.com/600x400?text=No+Image' }}"
                 class="w-full h-96 object-cover rounded shadow">
        </div>

        <!-- RIGHT: Product Info -->
        <div>
            <h1 class="text-3xl font-bold mb-2">{{ $product->name }}</h1>

            <p class="text-lg text-gray-700 mb-3">
                ₹{{ number_format($product->price, 2) }}
            </p>

            <!-- PRODUCT DESCRIPTION -->
            <p class="text-gray-600 leading-relaxed mb-6">
                {{ $product->description ?? 'No description available.' }}
            </p>

            <!-- ACTION BUTTONS -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                <!-- Add to Cart -->
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <button class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">
                        Add to Cart
                    </button>
                </form>

                <!-- Wishlist -->
                <form action="{{ route('wishlist.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <button class="w-full bg-pink-600 text-white py-2 rounded hover:bg-pink-700">
                        Add to Wishlist ❤️
                    </button>
                </form>

            </div>

            <!-- EXTRA INFO -->
            <div class="mt-6 pt-4 border-t text-gray-600 text-sm">
                <p><strong>Category:</strong> {{ $product->category->name ?? 'N/A' }}</p>
                <p><strong>Brand:</strong> {{ $product->brand->name ?? 'N/A' }}</p>
                <p><strong>Stock:</strong> {{ $product->stock ?? 'N/A' }}</p>
            </div>

        </div>
    </div>

    <!-- RELATED PRODUCTS -->
    @if(isset($relatedProducts) && count($relatedProducts) > 0)
        <div class="mt-10">
            <h2 class="text-2xl font-bold mb-4">Related Products</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                @foreach($relatedProducts as $item)
                    <div class="bg-white p-4 rounded shadow">
                        @php
                            $img = $item->images->first()->image_path ?? null;
                        @endphp
                        <img src="{{ $img ? asset('storage/' . $img) : 'https://via.placeholder.com/300?text=No+Image' }}"
                             class="h-40 w-full object-cover rounded mb-2">

                        <h3 class="font-semibold">{{ $item->name }}</h3>
                        <p class="text-gray-600">₹{{ number_format($item->price, 2) }}</p>

                        <a href="{{ route('product.details', $item->id) }}"
                           class="block mt-2 text-center bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                            View Details
                        </a>
                    </div>
                @endforeach

            </div>
        </div>
    @endif

</div>

@endsection
