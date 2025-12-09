@extends('layouts.app')

@section('title', 'Edit Customer')

@section('content')
<div class="container mx-auto max-w-xl p-6">

    <div class="bg-white shadow rounded border p-6">
        <h2 class="text-xl font-semibold mb-4">Edit Customer</h2>

        <form action="{{ route('customers.update', $customer->id) }}" method="POST">
            @csrf @method('PUT')

            @include('backend.customers.form')

            <div class="flex justify-end mt-4">
                <button class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">Update</button>
            </div>
        </form>

    </div>

</div>
@endsection
