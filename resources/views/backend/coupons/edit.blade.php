@extends('layouts.app')

@section('title', 'Edit Coupon')

@section('content')
<div class="container mx-auto max-w-xl p-6">

    <div class="bg-white shadow rounded-lg border p-6">
        <h2 class="text-xl font-semibold mb-4">Edit Coupon</h2>

        <form action="{{ route('coupons.update', $coupon->id) }}" method="POST">
            @csrf @method('PUT')

            @include('backend.coupons.form')

            <div class="flex justify-end mt-4">
                <button class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700">Update</button>
            </div>
        </form>
    </div>

</div>
@endsection
