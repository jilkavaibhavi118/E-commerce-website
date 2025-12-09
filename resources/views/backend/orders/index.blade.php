@extends('layouts.app')

@section('title', 'Manage Orders')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-semibold mb-6">Orders</h2>

    <div class="bg-white p-6 rounded shadow border">
        <table class="w-full">
            <thead>
            <tr class="bg-gray-100 border-b">
                <th class="p-2">Order ID</th>
                <th class="p-2">Customer</th>
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
                    <td class="p-2">{{ $order->name }}</td>
                    <td class="p-2">₹{{ $order->total }}</td>
                    <td class="p-2">
                        <span class="px-3 py-1 text-sm rounded text-white 
                            @if($order->status=='pending') bg-yellow-600
                            @elseif($order->status=='processing') bg-blue-600
                            @elseif($order->status=='shipped') bg-purple-600
                            @elseif($order->status=='delivered') bg-green-600
                            @else bg-red-600 @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td class="p-2">{{ $order->created_at->format('d M, Y') }}</td>
                    <td class="p-2">
                        <a href="{{ route('orders.show', $order->id) }}" class="text-blue-600">View</a>
                        |
                        <a href="{{ route('orders.edit', $order->id) }}" class="text-yellow-600">Edit</a>
                        |
                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Delete order?')" class="text-red-600">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>

        </table>
    </div>
</div>
@endsection
