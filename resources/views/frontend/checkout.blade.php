@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="max-w-5xl mx-auto p-6">

    <h2 class="text-2xl font-semibold mb-6">Checkout</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- BILLING FORM -->
        <div class="bg-white p-6 rounded-lg shadow border">
            <h3 class="text-lg font-semibold mb-4">Billing Details</h3>

            <form action="{{ route('checkout.placeOrder') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Full Name</label>
                    <input type="text" name="name"
                           value="{{ auth()->user()->name }}"
                           class="w-full border px-3 py-2 rounded" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Email</label>
                    <input type="email" name="email"
                           value="{{ auth()->user()->email }}"
                           class="w-full border px-3 py-2 rounded" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Phone</label>
                    <input type="text" name="phone"
                           value="{{ auth()->user()->phone }}"
                           class="w-full border px-3 py-2 rounded" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Address</label>
                    <textarea name="address"
                              class="w-full border px-3 py-2 rounded" required></textarea>
                </div>

                <button type="submit"
                        class="w-full px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Place Order
                </button>
            </form>
        </div>

        <!-- ORDER SUMMARY -->
        <div class="bg-white p-6 rounded-lg shadow border">
            <h3 class="text-lg font-semibold mb-4">Order Summary</h3>

            <div class="flex justify-between mb-2">
                <p class="text-gray-600">Subtotal</p>
                <p class="font-medium">₹{{ number_format($subtotal, 2) }}</p>
            </div>

            <div class="flex justify-between mb-2">
                <p class="text-gray-600">Discount</p>
                <p class="font-medium text-green-600">- ₹{{ number_format($discount, 2) }}</p>
            </div>

            <hr class="my-3">

            <div class="flex justify-between text-xl font-semibold">
                <p>Total</p>
                <p>₹{{ number_format($total, 2) }}</p>
            </div>
        </div>

    </div>

</div>
@endsection
