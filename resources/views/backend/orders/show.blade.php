@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white p-5 shadow rounded">

        <h2 class="text-xl font-bold mb-4">Order Details</h2>

        <p><strong>Order ID:</strong> {{ $order->id }}</p>

        <p><strong>Customer:</strong>
            {{ $order->user->name ?? 'Guest User' }}
        </p>

        <p><strong>Email:</strong>
            {{ $order->user->email ?? '-' }}
        </p>

        <p><strong>Total Amount:</strong>
            ₹{{ number_format($order->total_amount, 2) }}
        </p>

        <p><strong>Status:</strong>
            <span class="badge {{ $order->status == 'completed' ? 'bg-success' : 'bg-secondary' }}">
                {{ ucfirst($order->status) }}
            </span>
        </p>

        <p><strong>Payment Status:</strong>
            <span class="badge {{ $order->payment_status == 'paid' ? 'bg-success' : 'bg-warning' }}">
                {{ ucfirst($order->payment_status) }}
            </span>
        </p>

        <p><strong>Created At:</strong>
            {{ $order->created_at->format('d M, Y H:i A') }}
        </p>

        <h3 class="text-lg font-bold mt-4 mb-2">Order Items</h3>

        <ul class="list-group">
            @foreach ($order->items as $item)
                <li class="list-group-item d-flex justify-content-between">
                    <span>{{ $item->product->name }}</span>
                    <span>Qty: {{ $item->quantity }}</span>
                    <span>₹{{ number_format($item->price * $item->quantity, 2) }}</span>
                </li>
            @endforeach
        </ul>

        <a href="{{ route('admin.orders.index') }}" class="btn btn-primary mt-3">
            Back
        </a>

    </div>
</div>
@endsection
