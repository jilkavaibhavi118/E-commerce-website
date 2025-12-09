@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="max-w-5xl mx-auto p-6">

    <h2 class="text-2xl font-semibold mb-6">My Orders</h2>

    @if($orders->count() == 0)
        <div class="bg-white p-6 text-center rounded shadow border">
            <h3 class="text-lg font-medium mb-2">No orders found</h3>
            <a href="{{ route('home') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Shop Now
            </a>
        </div>
        @return
    @endif

    <div class="bg-white p-6 rounded-lg shadow border">

        <table class="w-full text-left">
            <thead>
            <tr class="border-b bg-gray-100">
                <th class="p-2">Order ID</th>
                <th class="p-2">Total</th>
                <th class="p-2">Status</th>
                <th class="p-2">Date</th>
                <th class="p-2">Action</th>
            </tr>
            </thead>

            <tbody>
            @foreach($orders as $order)
                <tr class="border-b">
                    <td class="p-2">#{{ $order->id }}</td>
                    <td class="p-2">₹{{ number_format($order->total, 2) }}</td>
                    <td class="p-2">
                        <span class="px-3 py-1 text-sm rounded text-white
                            {{ $order->status == 'pending' ? 'bg-yellow-600' : 'bg-green-600' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td class="p-2">{{ $order->created_at->format('d M, Y') }}</td>

                    <td class="p-2">
                        <a href="{{ route('orders.show', $order->id) }}"
                           class="text-blue-600 hover:underline">View</a>
                    </td>
                </tr>
            @endforeach
            </tbody>

        </table>

    </div>

</div>
@endsection
