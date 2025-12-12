@extends('frontend.layouts.app')

@section('content')
<div class="container my-5">
    <h2 class="mb-4">Invoice for Order #{{ $order->id }}</h2>

    <div class="card p-4">
        <h4>Customer Information</h4>
        <p><strong>Name:</strong> {{ $order->user->name }}</p>
        <p><strong>Email:</strong> {{ $order->user->email }}</p>

        <h4 class="mt-4">Order Details</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>₹{{ number_format($item->price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <h4 class="mt-3">Total: ₹{{ number_format($order->total_price, 2) }}</h4>
    </div>

    <a href="{{ route('frontend.orders.invoice', $order->id) }}" class="btn btn-primary mt-4">Print Invoice</a>
</div>
@endsection
