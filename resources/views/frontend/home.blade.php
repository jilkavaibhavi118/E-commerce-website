@extends('frontend.layouts.app')

@section('content')

<!-- ==================== TOP DARK NAVBAR ==================== -->
<header class="bg-[#131921] text-white">
    <div class="container mx-auto flex items-center justify-between px-4 py-3">

   <!-- Logo -->
<div>
    <img src="{{ url('images/logo1.png') }}"
         class="h-10 w-auto"
         alt="ShopEase Logo">
</div>




        <!-- Deliver to -->
        <div class="hidden md:flex items-center space-x-1 cursor-pointer">
            <svg class="w-5 h-5" fill="currentColor"></svg>
            <div class="text-sm leading-tight">
                <p class="text-gray-300">Deliver to</p>
                <div>{{ Auth::user()->name }}</div>
            </div>
        </div>

        <!-- Search -->
        <div class="flex-1 px-4">
            <div class="flex">
                <input type="text" class="w-full rounded-l-md px-4 py-2 text-black" placeholder="Search products...">
                <button class="bg-yellow-500 px-4 rounded-r-md">
                    <svg class="w-6 h-6 text-black"><path d="M..." /></svg>
                </button>
            </div>
        </div>

        <!-- Account -->
        <div class="hidden md:block text-sm cursor-pointer">
            <p>Hello, User</p>
        </div>

        <!-- Orders -->
    

        <!-- Cart -->
        <div class="relative cursor-pointer">
    <img src="{{ asset('images/cart.png') }}" class="w-8 h-8" alt="Cart">

    <span class="absolute -top-1 -right-1 bg-yellow-500 text-black text-xs font-bold rounded-full px-1">
        3
    </span>
</div>



    </div>
</header>



<!-- ==================== CATEGORY BOXES ==================== -->
<div class="container mx-auto px-4 mt-10 mb-10 grid grid-cols-1 md:grid-cols-4 gap-6">

    @foreach (['Electronics', 'Fashion', 'Home', 'Beauty'] as $category)
    <div class="bg-white p-4 shadow-md rounded">
        <h3 class="font-bold mb-2 text-lg">{{ $category }}</h3>
        <img src="https://via.placeholder.com/300x200?text={{ $category }}"
             class="w-full h-40 object-cover rounded mb-2">
        <a href="#" class="text-sm text-blue-600 hover:underline">Shop now</a>
    </div>
    @endforeach

</div>

<!-- ==================== PRODUCT SECTIONS ==================== -->

@foreach (['Top deals', 'Best Sellers', 'Trending Now', 'New Arrivals'] as $section)
<div class="container mx-auto px-4 mb-10">
    <h2 class="text-xl font-bold mb-3">{{ $section }}</h2>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">

        @foreach(range(1,4) as $i)
        <div class="bg-white p-4 shadow rounded hover:shadow-lg transition">
            <img src="https://via.placeholder.com/300x250?text=Product+{{ $i }}"
                 class="w-full h-48 object-cover rounded mb-3">

            <h3 class="font-semibold">Product {{ $i }}</h3>

            <p class="text-yellow-500 text-sm mb-1">★★★★☆</p>

            <p class="font-bold text-lg">₹{{ rand(499,1999) }}</p>
        </div>
        @endforeach

    </div>
</div>
@endforeach

<!-- ==================== FOOTER ==================== -->
<footer class="bg-[#232f3e] text-white py-10 mt-10">
    <div class="container mx-auto grid grid-cols-2 md:grid-cols-4 gap-10 px-4">

        <div>
            <h3 class="font-bold mb-2">Get to Know Us</h3>
            <p class="text-sm">About Us</p>
            <p class="text-sm">Careers</p>
            <p class="text-sm">Press Releases</p>
        </div>

        <div>
            <h3 class="font-bold mb-2">Connect with Us</h3>
            <p class="text-sm">Facebook</p>
            <p class="text-sm">Twitter</p>
            <p class="text-sm">Instagram</p>
        </div>

        <div>
            <h3 class="font-bold mb-2">Make Money with Us</h3>
            <p class="text-sm">Sell on Amazon</p>
            <p class="text-sm">Affiliate Program</p>
        </div>

        <div>
            <h3 class="font-bold mb-2">Let Us Help You</h3>
            <p class="text-sm">Your Account</p>
            <p class="text-sm">Returns</p>
            <p class="text-sm">Help</p>
        </div>

    </div>

    <div class="text-center mt-6 text-sm text-gray-300">
        © 2025 YourStore — Made with ❤️ in Laravel
    </div>
</footer>

@endsection
