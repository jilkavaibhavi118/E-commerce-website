@extends('layouts.app')

@section('title', 'Create Coupon')

@section('content')
<div class="container mx-auto max-w-xl p-6">

    <div class="bg-white shadow rounded-lg border p-6">
        <h2 class="text-xl font-semibold mb-4">Add Coupon</h2>

        <form action="{{ route('coupons.store') }}" method="POST" id="crudForm">
            @csrf

            @include('backend.coupons.form')

              <div class="flex justify-end gap-3">
                <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700" id="crudFormSave">Save</button>
                  <a href="{{ route('coupons.index') }}"
                 class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>

</div>
@endsection
