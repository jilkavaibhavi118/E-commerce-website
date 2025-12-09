@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="max-w-xl mx-auto p-6">

    <div class="bg-white p-6 shadow rounded border">

        <h2 class="text-2xl font-semibold mb-4">My Profile</h2>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST">
            @csrf

            <label class="font-medium">Name</label>
            <input type="text" name="name" class="w-full border px-3 py-2 rounded mb-4"
                   value="{{ auth()->user()->name }}">

            <label class="font-medium">Email</label>
            <input type="email" name="email" class="w-full border px-3 py-2 rounded mb-4"
                   value="{{ auth()->user()->email }}">

            <label class="font-medium">Phone</label>
            <input type="text" name="phone" class="w-full border px-3 py-2 rounded mb-4"
                   value="{{ auth()->user()->phone }}">

            <button class="w-full px-3 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Update Profile
            </button>
        </form>

    </div>

</div>
@endsection
