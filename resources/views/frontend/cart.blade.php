<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart</title>

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <!-- HEADER -->
    <header class="bg-blue-600 text-white p-4">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">My Cart</h1>
            <a href="{{ route('dashboard') }}" class="bg-green-500 px-3 py-1 rounded hover:bg-green-700">Back to Dashboard</a>
        </div>
    </header>

    <main class="max-w-6xl mx-auto mt-6 p-4">

        <!-- Success / Error Messages -->
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @if($cart->count() == 0)
            <div class="bg-white p-6 rounded shadow text-center">
                <h3 class="text-lg font-medium mb-3">Your cart is empty 😢</h3>
                <a href="{{ route('dashboard') }}"
                   class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Continue Shopping
                </a>
            </div>
        @else

        <!-- CART ITEMS -->
        <div class="bg-white p-6 rounded-lg shadow border mb-8">
            @foreach($cart as $item)
                <div class="flex items-center gap-4 border-b pb-4 mb-4">

                    <!-- Product Image -->
                    @php
                        $image = $item->product->images->first()->image_path ?? null;
                    @endphp
                    <img src="{{ $image ? asset('storage/'.$image) : 'https://via.placeholder.com/80x80?text=No+Image' }}"
                         class="w-20 h-20 rounded border object-cover">

                    <div class="flex-1">
                        <h3 class="font-semibold text-lg">{{ $item->product->name }}</h3>
                        <p class="text-gray-500 text-sm">₹{{ number_format($item->product->price, 2) }}</p>

                        <!-- Update Quantity -->
                        <form action="{{ route('cart.update') }}" method="POST" class="flex items-center mt-2">
                            @csrf
                            <input type="hidden" name="cart_id" value="{{ $item->id }}">
                            <input type="number"
                                   name="quantity"
                                   value="{{ $item->quantity }}"
                                   min="1"
                                   class="w-20 border rounded px-2 py-1">

                            <button type="submit"
                                    class="ml-2 px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                                Update
                            </button>
                        </form>
                    </div>

                    <!-- Remove Button -->
                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Remove this item?')"
                                class="text-red-600 font-semibold hover:underline">
                            Remove
                        </button>
                    </form>

                </div>
            @endforeach
        </div>

        <!-- APPLY COUPON -->
        <div class="bg-white p-6 rounded-lg shadow border mb-8">
            <h3 class="text-lg font-semibold mb-4">Apply Coupon</h3>

            <form action="{{ route('cart.applyCoupon') }}" method="POST" class="flex gap-3">
                @csrf
                <input type="text"
                       name="code"
                       placeholder="Enter coupon code"
                       class="flex-1 border px-3 py-2 rounded">

                <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Apply
                </button>
            </form>
        </div>


       <!-- CART SUMMARY -->
<div class="bg-white p-6 rounded-lg shadow border">

    <h3 class="text-xl font-semibold mb-4">Order Summary</h3>

    <!-- Subtotal -->
    <div class="flex justify-between mb-2">
        <p class="text-gray-600">Subtotal</p>
        <p class="font-medium">₹{{ number_format($subtotal, 2) }}</p>
    </div>

   <!-- Discount -->
<div class="flex justify-between mb-2">
    <p class="text-gray-600">
        Discount
        @if(session('coupon_code') && $couponType && $couponValue)
            ({{ session('coupon_code') }} -
            {{ $couponType === 'percent' ? $couponValue.'%' : '₹'.$couponValue }})
        @endif
    </p>
    <p class="font-medium text-green-600">- ₹{{ number_format($discountAmount, 2) }}</p>
</div>


    <hr class="my-3">

    <!-- Total -->
    <div class="flex justify-between text-lg font-semibold mb-4">
        <p>Total</p>
        <p>₹{{ number_format($total, 2) }}</p>
    </div>

    <a href="{{ route('checkout.index') }}"
       class="block w-full text-center px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
        Proceed to Checkout
    </a>
</div>

        </div>

        @endif

    </main>

</body>
</html>
