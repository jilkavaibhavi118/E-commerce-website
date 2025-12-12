@extends('frontend.layouts.app')

@section('content')

<div class="max-w-7xl mx-auto p-6">

    <!-- PAGE TITLE -->
    <h2 class="text-3xl font-bold mb-6">My Wishlist</h2>

    <!-- CHECK IF EMPTY -->
    @if($wishlistItems->isEmpty())
        <div class="bg-white p-8 text-center rounded shadow">
            <p class="text-gray-600 text-lg">Your wishlist is empty.</p>
            <a href="{{ route('frontend.dashboard') }}"
               class="mt-4 inline-block px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Browse Products
            </a>
        </div>
    @else

        <!-- PRODUCTS GRID -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

            @foreach($wishlistItems as $item)
                @php
                    $product = $item->product;
                    $image = $product->images->first()->image_path ?? null;
                @endphp

                <div class="bg-white p-4 rounded-xl shadow hover:shadow-lg transition">

                    <!-- IMAGE -->
                    <img src="{{ $image ? asset('storage/' . $image) : 'https://via.placeholder.com/400x250' }}"
                         class="w-full h-48 object-cover rounded-lg mb-3">

                    <!-- TITLE -->
                    <h3 class="font-semibold text-lg">{{ $product->name }}</h3>

                    <!-- PRICE -->
                    <p class="text-gray-600">₹{{ number_format($product->price, 2) }}</p>

                    <!-- BUTTONS -->
                    <div class="mt-4 flex gap-3">

                        <!-- Remove from Wishlist -->
                        <form action="{{ route('wishlist.remove') }}" method="POST" class="flex-1">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button class="w-full bg-red-500 text-white py-2 rounded hover:bg-red-600">
                                Remove
                            </button>
                        </form>

                        <!-- Add to Cart -->
                        <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">
                                Add to Cart
                            </button>
                        </form>

                    </div>

                </div>

            @endforeach

        </div>

    @endif

</div>

@endsection
