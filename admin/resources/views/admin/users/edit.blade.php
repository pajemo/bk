@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">Edit User</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block font-medium text-gray-700">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required class="mt-1 block w-full border border-gray-300 rounded px-3 py-2">
        </div>

        <div class="mb-4">
            <label for="email" class="block font-medium text-gray-700">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required class="mt-1 block w-full border border-gray-300 rounded px-3 py-2">
        </div>

        <div class="mb-4">
            <label for="role" class="block font-medium text-gray-700">Role</label>
            <select name="role" id="role" required class="mt-1 block w-full border border-gray-300 rounded px-3 py-2">
                <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>User</option>
                <option value="super_admin" {{ old('role', $user->role) === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
            </select>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update User</button>
        <a href="{{ route('admin.users') }}" class="ml-4 text-gray-600 hover:underline">Cancel</a>
    </form>
</div>
@endsection
