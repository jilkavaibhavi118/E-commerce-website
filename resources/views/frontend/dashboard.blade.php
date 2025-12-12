@extends('frontend.layouts.app')

@section('title', 'Customer Dashboard')

@section('content')

<!-- ==================== HERO AUTO SLIDER ==================== -->
<div
    x-data="{
        current: 0,
        images: [
            '{{ asset('images/slider/slider1.jpg') }}',
            '{{ asset('images/slider/slider2.jpg') }}',
            '{{ asset('images/slider/slider3.avif') }}'
        ],
        interval: null,
        start() {
            this.interval = setInterval(() => {
                this.current = (this.current + 1) % this.images.length;
            }, 3000);
        }
    }"
    x-init="start()"
    class="relative w-full h-[420px] overflow-hidden"
>
    <!-- Slider Images -->
    <template x-for="(image, index) in images" :key="index">
        <img
            x-show="current === index"
            x-transition.opacity
            :src="image"
            class="absolute inset-0 w-full h-full object-cover"
        />
    </template>
</div>


<h2 class="text-3xl font-bold mb-6">Products</h2>

<!-- PRODUCT GRID -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

    @foreach($products as $product)
        @php
            $image = $product->images->first()->image_path ?? null;
        @endphp

        <div class="bg-white p-4 rounded-xl shadow hover:shadow-lg transition duration-200">

            <!-- IMAGE -->
            <img src="{{ $image ? asset('storage/' . $image) : 'https://via.placeholder.com/400x250?text=No+Image' }}"
                 alt="{{ $product->name }}"
                 class="w-full h-48 object-cover rounded-lg mb-3">

            <!-- NAME -->
            <h3 class="font-semibold text-lg">{{ $product->name }}</h3>

            <!-- PRICE -->
            <p class="text-gray-600 mt-1">₹{{ number_format($product->price, 2) }}</p>

            <!-- ACTIONS -->
            <div class="mt-4 flex justify-between items-center">

                <!-- ADD TO CART -->
                <button type="button"
                class="bg-green-600 text-white px-3 py-2 rounded-md hover:bg-green-700 add-to-cart-btn"
                data-id="{{ $product->id }}">
                Add to Cart
            </button>


                <!-- ADD TO WISHLIST -->
                <form action="{{ route('wishlist.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <button type="submit">
                        <i data-feather="heart"
                           class="w-6 h-6 text-red-500 hover:text-red-600"></i>
                    </button>
                </form>

            </div>

            <!-- VIEW DETAILS BUTTON -->
            <a href="{{ route('product.details', $product->id) }}"
               class="block text-center mt-3 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                View Details
            </a>

        </div>
    @endforeach

</div>

@endsection
