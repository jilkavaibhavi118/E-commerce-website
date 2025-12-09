@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="container mx-auto p-6">

    <h2 class="text-2xl font-semibold mb-6">Order #{{ $order->id }}</h2>

    <!-- ORDER DETAILS -->
    <div class="bg-white p-6 rounded shadow border mb-6">
        <h3 class="text-lg font-semibold mb-4">Customer Details</h3>

        <p><strong>Name:</strong> {{ $order->name }}</p>
        <p><strong>Email:</strong> {{ $order->email }}</p>
        <p><strong>Phone:</strong> {{ $order->phone }}</p>
        <p><strong>Address:</strong> {{ $order->address }}</p>
        <p><strong>Status:</strong>
            <span class="px-3 py-1 rounded text-white bg-blue-600">{{ ucfirst($order->status) }}</span>
        </p>
    </div>

    <!-- ITEMS -->
    <div class="bg-white p-6 rounded shadow border mb-6">

        <h3 class="text-lg font-semibold mb-4">Order Items</h3>

        <table class="w-full">
            <thead>
            <tr class="bg-gray-100 border-b">
                <th class="p-2">Product</th>
                <th class="p-2">Price</th>
                <th class="p-2">Qty</th>
                <th class="p-2">Total</th>
            </tr>
            </thead>
            <tbody>
            @foreach($order->items as $item)
                <tr class="border-b">
                    <td class="p-2">{{ $item->product->name }}</td>
                    <td class="p-2">₹{{ $item->price }}</td>
                    <td class="p-2">{{ $item->quantity }}</td>
                    <td class="p-2">₹{{ $item->total }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>

    <!-- SUMMARY -->
    <div class="bg-white p-6 rounded shadow border">
        <h3 class="text-lg font-semibold mb-4">Summary</h3>

        <p>Subtotal: ₹{{ $order->subtotal }}</p>
        <p>Discount: ₹{{ $order->discount }}</p>

        <div class="text-xl font-bold mt-4">
            Total: ₹{{ $order->total }}
        </div>
    </div>

</div>
@endsection
