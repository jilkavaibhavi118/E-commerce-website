@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-xl p-6">

    <div class="bg-white shadow rounded-lg p-6 border">
        <h2 class="text-xl font-semibold mb-4">Add Roles</h2>

        <form action="{{ route('roles.store') }}" method="POST" id="crudForm">
            @csrf

            {{-- Category Name --}}
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Role Name</label>
                <input type="text" name="name"
                       class="w-full px-3 py-2 border rounded-md focus:ring focus:ring-blue-300 focus:border-blue-500"
                       placeholder="Enter category name" required>
            </div>



            {{-- Buttons --}}
            <div class="flex justify-end gap-3">
                <a href="{{ route('roles.index') }}"
                   class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition">
                    Cancel
                </a>

                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                    Create
                </button>
            </div>

        </form>
    </div>

</div>
@endsection
