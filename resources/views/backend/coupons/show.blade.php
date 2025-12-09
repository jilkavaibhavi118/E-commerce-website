@extends('layouts.app')

@section('title', 'Coupon Details')

@section('content')
<div class="container mx-auto max-w-xl p-6">

    <div class="bg-white shadow rounded-lg p-6 border">

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">{{ $coupon->code }}</h2>

            <a href="{{ route('coupons.index') }}"
               class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition">
                Back
            </a>
        </div>

        <div class="space-y-4">

            <div>
                <p class="text-sm text-gray-600 font-medium">Code</p>
                <p class="text-lg font-semibold">{{ $coupon->code }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-600 font-medium">Type</p>
                <p class="capitalize">{{ $coupon->type }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-600 font-medium">Value</p>
                <p>{{ $coupon->value }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-600 font-medium">Minimum Cart Value</p>
                <p>{{ $coupon->min_cart_value }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-600 font-medium">Max Uses</p>
                <p>{{ $coupon->max_uses }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-600 font-medium">Max Uses Per User</p>
                <p>{{ $coupon->max_uses_user }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-600 font-medium">Start Date</p>
                <p>{{ $coupon->start_date }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-600 font-medium">End Date</p>
                <p>{{ $coupon->end_date }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-600 font-medium">Status</p>

                @if($coupon->status)
                    <span class="px-3 py-1 bg-green-200 text-green-700 rounded-full text-sm">
                        Active
                    </span>
                @else
                    <span class="px-3 py-1 bg-red-200 text-red-700 rounded-full text-sm">
                        Inactive
                    </span>
                @endif
            </div>

        </div>

    </div>

</div>
@endsection
