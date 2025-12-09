@extends('layouts.app')

@section('title', 'Add Customer')

@section('content')
<div class="container mx-auto max-w-xl p-6">

    <div class="bg-white shadow rounded border p-6">
        <h2 class="text-xl font-semibold mb-4">Add Customer</h2>

        <form action="{{ route('customers.store') }}" method="POST" enctype="multipart/form-data" id="crudForm">
            @csrf

            @include('backend.customers.form')

            <button type="submit" id="crudFormSave"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                    Save
                </button>
        </form>

    </div>

</div>
@endsection
