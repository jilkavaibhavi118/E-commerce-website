@extends('layouts.app')

@section('title', 'Edit Orders')

@section('content')
<div class="container mx-auto max-w-xl p-6">

    <div class="bg-white shadow rounded-lg p-6 border">
        <h2 class="text-xl font-semibold mb-4">Edit Order</h2>

        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" id="crudForm">
            @csrf
            @method('PUT')


            {{-- Status --}}
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Order Status</label>
                <select name="order_status"
                        class="w-full px-3 py-2 border rounded-md focus:ring focus:ring-blue-300 focus:border-blue-500">
                        <option value="pending" {{ $order->order_status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ $order->order_status == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ $order->order_status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ $order->order_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ $order->order_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Payment Status</label>
                <select name="payment_status"
                class="w-full px-3 py-2 border rounded-md focus:ring focus:ring-blue-300 focus:border-blue-500">
                    <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
            </div>


            {{-- Buttons --}}
            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.orders.index') }}"
                   class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition">
                    Cancel
                </a>

                <button type="submit" id="crudFormSave"
                   class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                    Update
                </button>
            </div>

        </form>
    </div>

</div>
@endsection
