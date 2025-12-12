@extends('frontend.layouts.app')

@section('title', 'Your Order Details')

@section('content')
<div class="max-w-6xl mx-auto mt-6 px-4">

    {{-- Breadcrumb --}}
    <nav class="text-sm text-gray-600 mb-4">
        <ol class="flex items-center gap-2">
            <li>
                <a href="{{ route('frontend.orders.index') }}" class="text-blue-600 hover:underline">
                    Your Orders
                </a>
            </li>
            <li>/</li>
            <li class="text-gray-900">Order Details</li>
        </ol>
    </nav>

    <h2 class="text-2xl font-semibold mb-2">Order Details</h2>
    <p class="text-gray-600 mb-4">
        Order placed {{ $order->created_at->format('j F Y') }} |
        Order number {{ $order->order_number }}
    </p>

    {{-- Order Info Card --}}
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- Shipping --}}
            <div>
                <h3 class="font-semibold mb-2">Ship to</h3>
                <p class="text-gray-700 leading-6">
                    {{ $order->customer->name }}<br>
                    {{ $order->address }}<br>
                </p>
            </div>

            {{-- Payment --}}
            <div>
                <h3 class="font-semibold mb-2">Payment</h3>
                <p class="text-gray-700">
                    Status: <span class="font-semibold">{{ ucfirst($order->payment_status) }}</span>
                </p>
            </div>

            {{-- Order Summary --}}
            <div>
                <h3 class="font-semibold mb-2">Order Summary</h3>
                <p class="text-gray-700 leading-6">
                    Item(s) Subtotal: ₹{{ number_format($order->subtotal, 2) }} <br>
                    Shipping: ₹{{ number_format($order->shipping_cost, 2) }} <br>
                    COD Fee: ₹{{ number_format($order->cod_fee, 2) }} <br>
                    Total: ₹{{ number_format($order->total, 2) }} <br>

                    @if($order->promotion_discount)
                        Promotion Applied:
                        <span class="text-red-600">-₹{{ number_format($order->promotion_discount, 2) }}</span><br>
                    @endif

                    <span class="font-bold text-lg">
                        Grand Total: ₹{{ number_format($order->grand_total, 2) }}
                    </span>
                </p>

                <a href="{{ route('frontend.orders.invoice', $order->id) }}"
                   class="text-blue-600 hover:underline mt-2 inline-block">
                    Download Invoice
                </a>
            </div>

        </div>
    </div>

    {{-- Delivery & Items --}}
    <div class="bg-white shadow rounded-lg p-6">

        <h3 class="font-semibold text-lg mb-1">
            Delivered {{ optional($order->delivered_at)->format('j F Y') ?? 'Pending' }}
        </h3>

        <p class="text-gray-600 mb-4">Package was handed to resident</p>

        @foreach($order->items as $item)

        <div class="flex gap-4 border-b pb-4 mb-4">
            <img src="{{ asset('storage/' . $item->product->images->first()->image_path) }}"
            alt="Product Image"
            class="w-16 h-16 object-cover rounded">


            <div class="flex-1">
                <a href="{{ route('product.details', $item->product->id) }}"
                   class="font-semibold text-blue-600 hover:underline">
                   {{ $item->product->name }}
                </a>

                <p class="text-gray-700">Sold by: {{ $item->product->vendor_name }}</p>

                <p class="text-gray-600">
                    Return window closes on
                    <strong>
                        {{ optional($order->return_window_end)->format('j F Y') ?? 'Pending' }}
                    </strong>
                </p>

                <p class="mt-1 font-semibold">₹{{ number_format($item->price, 2) }}</p>

                <div class="flex gap-2 mt-2">
                    <a href="{{ route('checkout.placeOrder', $item->product->id) }}"
                       class="px-3 py-1 bg-yellow-500 text-white rounded text-sm">
                       Buy again
                    </a>

                    <a href="{{ route('product.details', $item->product->id) }}"
                       class="px-3 py-1 border border-gray-400 rounded text-sm">
                       View item
                    </a>
                </div>
            </div>
        </div>

        @endforeach

        {{-- Feedback + Review Buttons --}}
        <div class="flex gap-3 mt-4">
            <a href="{{ route('frontend.orders.feedback', $order->id) }}"
               class="px-4 py-2 border border-blue-600 text-blue-600 rounded hover:bg-blue-50">
               Leave seller feedback
            </a>

            <a href="{{ route('frontend.orders.review', $order->id) }}"
               class="px-4 py-2 border border-blue-600 text-blue-600 rounded hover:bg-blue-50">
               Write a product review
            </a>
        </div>

    </div>

</div>
@endsection
