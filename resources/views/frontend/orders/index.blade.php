@extends('frontend.layouts.app')

@section('title', 'Your Orders')

@section('content')
<div class="max-w-6xl mx-auto p-6">

    <h2 class="text-3xl font-bold mb-6">Your Orders</h2>

    @if($orders->isEmpty())
        <div class="bg-white p-8 text-center rounded shadow">
            <p class="text-gray-600 text-lg">You have no orders yet.</p>
            <a href="{{ route('frontend.dashboard') }}"
               class="mt-4 inline-block px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Browse Products
            </a>
        </div>
    @else
        <div class="space-y-6">
            @foreach($orders as $order)
                <div class="bg-white shadow rounded-lg p-6">
                    <!-- ORDER HEADER -->
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b pb-4 mb-4">
                        <div class="text-gray-700 text-sm">
                            <div><span class="font-semibold">Order Placed:</span> {{ $order->created_at->format('d M Y') }}</div>
                            <div><span class="font-semibold">Total:</span> ₹{{ number_format($order->total, 2) }}</div>
                            <div><span class="font-semibold">Ship To:</span> {{ auth()->user()->name }}</div>
                        </div>

                        <div class="mt-2 sm:mt-0 flex space-x-2">
                            <a href="{{ route('orders.show', $order->id) }}"
                               class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                                View order details
                            </a>
                            <a href="#"
                               class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 text-sm">
                                Invoice
                            </a>
                        </div>
                    </div>

                    <!-- ORDER ITEMS -->
                    <div class="space-y-4">
                        @foreach($order->items as $item)
                            <div class="flex items-center space-x-4 border-b pb-4">
                                <!-- Product Image -->
                                @php
                                    $image = $item->product->images->first()->image_path ?? null;
                                @endphp
                                <img src="{{ $image ? asset('storage/' . $image) : 'https://via.placeholder.com/80' }}"
                                     alt="{{ $item->product->name }}"
                                     class="w-20 h-20 object-cover rounded">

                                <!-- Product Info -->
                                <div class="flex-1">
                                    <h3 class="text-gray-800 font-semibold">{{ $item->product->name }}</h3>
                                    <p class="text-gray-600 text-sm">Qty: {{ $item->quantity }}</p>
                                    <p class="text-gray-600 text-sm">Price: ₹{{ number_format($item->price, 2) }}</p>
                                </div>

                                <!-- ACTION BUTTONS -->
                                <div class="flex flex-col space-y-2">
                                    <a href="#"
                                       class="px-4 py-1 bg-yellow-400 text-white rounded hover:bg-yellow-500 text-sm text-center">
                                        Buy it again
                                    </a>
                                    <a href="#"
                                       class="px-4 py-1 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 text-sm text-center">
                                        View your item
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- DELIVERY STATUS -->
                    <div class="mt-4 text-sm text-gray-500">
                        <span class="font-semibold">Status:</span> {{ ucfirst($order->status) }}
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
