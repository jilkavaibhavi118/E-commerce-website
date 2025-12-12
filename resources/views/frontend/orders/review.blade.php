@extends('frontend.layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-10 px-4">

    {{-- Page Title --}}
    <h2 class="text-2xl font-semibold mb-6">Write a Product Review</h2>

    {{-- Order Info --}}
    <div class="bg-white shadow rounded-lg p-5 mb-6">
        <h3 class="font-semibold text-lg mb-2">
            Order #{{ $order->id }}
        </h3>

        <p class="text-gray-600 text-sm">
            Placed on {{ $order->created_at->format('d M, Y') }}
        </p>
    </div>

    {{-- Product List --}}
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h3 class="font-semibold text-lg mb-3">Products in this order</h3>

        @foreach($order->items as $item)
            <div class="flex gap-4 border-b pb-4 mb-4">
                <img src="{{ asset('storage/' . ($item->product->images->first()->image_path ?? 'placeholder.jpg')) }}"
                     class="w-20 h-20 object-cover rounded">

                <div>
                    <h4 class="font-medium text-gray-800">
                        {{ $item->product->name }}
                    </h4>
                    <p class="text-gray-600">₹{{ number_format($item->price, 2) }}</p>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Review Form --}}
    <form action="{{ route('frontend.orders.review.submit', $order->id) }}"
          method="POST"
          class="bg-white shadow rounded-lg p-6">

        @csrf

        {{-- Rating --}}
        <div class="mb-5">
            <label class="block font-medium mb-1">Rating <span class="text-red-500">*</span></label>

            <select name="rating" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">

                <option value="">Select Rating</option>
                <option value="5">⭐⭐⭐⭐⭐ - Excellent</option>
                <option value="4">⭐⭐⭐⭐ - Good</option>
                <option value="3">⭐⭐⭐ - Average</option>
                <option value="2">⭐⭐ - Poor</option>
                <option value="1">⭐ - Very Bad</option>
            </select>

            @error('rating')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Comment --}}
        <div class="mb-5">
            <label class="block font-medium mb-1">Review Message <span class="text-red-500">*</span></label>

            <textarea name="comment" rows="5" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500"
                placeholder="Write your experience about the product...">{{ old('comment') }}</textarea>

            @error('comment')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Submit --}}
        <button type="submit"
                class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
            Submit Review
        </button>

        {{-- Back --}}
        <a href="{{ route('orders.show', $order->id) }}"
           class="ml-4 text-gray-
@endsection