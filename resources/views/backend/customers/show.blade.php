@extends('layouts.app')

@section('title', 'Customer Details')

@section('content')
<div class="container mx-auto max-w-xl p-6">

    <div class="bg-white shadow rounded border p-6">

        <h2 class="text-xl font-semibold mb-4">{{ $customer->name }}</h2>

        <div class="space-y-4">
            <div><b>Email:</b> {{ $customer->email }}</div>
            <div><b>Phone:</b> {{ $customer->phone ?? '—' }}</div>
            <div><b>Status:</b>
                <span class="px-3 py-1 text-white rounded
                    {{ $customer->status ? 'bg-green-600' : 'bg-red-600' }}">
                    {{ $customer->status ? 'Active' : 'Inactive' }}
                </span>
            </div>
        </div>

        <a href="{{ route('customers.index') }}"
           class="mt-4 inline-block px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
            Back
        </a>

    </div>

</div>
@endsection
