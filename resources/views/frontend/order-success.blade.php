@extends('layouts.app')

@section('title', 'Order Successful')

@section('content')
<div class="max-w-lg mx-auto p-6">

    <div class="bg-white p-8 rounded-lg shadow text-center">

        <div class="text-green-600 text-5xl mb-4">✔</div>

        <h2 class="text-2xl font-semibold mb-3">Order Placed Successfully!</h2>

        <p class="text-gray-600 mb-6">Thank you for shopping with us.  
            Your order has been placed and is currently being processed.</p>

        <a href="{{ route('orders.index') }}"
           class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            View My Orders
        </a>

        <a href="{{ route('home') }}"
           class="ml-2 px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
            Continue Shopping
        </a>

    </div>

</div>
@endsection
