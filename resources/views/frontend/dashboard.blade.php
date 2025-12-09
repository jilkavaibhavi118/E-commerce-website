@extends('layouts.app')

@section('title', 'My Dashboard')

@section('content')
<div class="max-w-5xl mx-auto p-6">

    <!-- PAGE TITLE -->
    <h2 class="text-2xl font-semibold mb-6">My Dashboard</h2>

    <!-- TOP CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

        <!-- ORDERS -->
        <a href="{{ route('user.orders.index') }}"
           class="bg-white border rounded-lg p-6 shadow hover:shadow-lg transition block">
            <h3 class="text-lg font-semibold mb-2">My Orders</h3>
            <p class="text-gray-600">View all your orders & status updates.</p>
        </a>

        <!-- CART -->
        <a href="{{ route('cart.index') }}"
           class="bg-white border rounded-lg p-6 shadow hover:shadow-lg transition block">
            <h3 class="text-lg font-semibold mb-2">My Cart</h3>
            <p class="text-gray-600">Check and manage your shopping cart.</p>
        </a>


    </div>

    <!-- ACCOUNT INFO CARD -->
    <div class="bg-white border rounded-lg shadow p-6 mb-8">
        <h3 class="text-xl font-semibold mb-4">Account Information</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div>
                <p class="text-sm text-gray-600 mb-1">Name</p>
                <p class="font-medium">{{ auth()->user()->name }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-600 mb-1">Email</p>
                <p class="font-medium">{{ auth()->user()->email }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-600 mb-1">Phone</p>
                <p class="font-medium">{{ auth()->user()->phone ?? 'Not added' }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-600 mb-1">Status</p>
                <span class="px-3 py-1 text-sm rounded text-white
                    {{ auth()->user()->status == 1 ? 'bg-green-600' : 'bg-red-600' }}">
                    {{ auth()->user()->status == 1 ? 'Active' : 'Inactive' }}
                </span>
            </div>

        </div>
    </div>

    <!-- QUICK LINKS -->
    <div class="bg-white border rounded-lg shadow p-6">
        <h3 class="text-xl font-semibold mb-4">Quick Links</h3>

        <ul class="space-y-3 text-blue-600">
            <li><a href="{{ route('cart.index') }}" class="hover:underline">Go to Cart</a></li>
            <li><a href="{{ route('user.orders.index') }}" class="hover:underline">View My Orders</a></li>
           
            <li><a href="{{ route('dashboard') }}" class="hover:underline">Return to Homepage</a></li>
        </ul>
    </div>

</div>
@endsection
