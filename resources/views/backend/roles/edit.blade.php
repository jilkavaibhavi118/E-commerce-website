@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Role</h2>

    <form action="{{ route('roles.update', $role->id) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-3">
            <label class="form-label">Role Name</label>
            <input type="text" name="name" class="form-control" value="{{ $role->name }}">
        </div>

        <button class="btn btn-success">Update</button>
        <a href="{{ route('roles.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
