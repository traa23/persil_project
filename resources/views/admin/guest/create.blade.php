@extends('layouts.admin')

@section('title', 'Tambah Guest User')
@section('page-title', 'Tambah Guest User')

@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-md">
    {{-- OLD: route('admin.guest.store') --}}
    <form action="{{ getAdminRoute('guest.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Nama -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                Nama <span class="text-red-500">*</span>
            </label>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name') }}"
                class="w-full px-4 py-2 border @error('name') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                required
            >
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                Email <span class="text-red-500">*</span>
            </label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                class="w-full px-4 py-2 border @error('email') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                required
            >
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                Password <span class="text-red-500">*</span>
            </label>
            <input
                type="password"
                id="password"
                name="password"
                class="w-full px-4 py-2 border @error('password') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                required
            >
            <p class="text-gray-500 text-sm mt-1">Minimal 6 karakter</p>
            @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Konfirmasi Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                Konfirmasi Password <span class="text-red-500">*</span>
            </label>
            <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                required
            >
            @error('password_confirmation')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Buttons -->
        <div class="flex space-x-4">
            <button
                type="submit"
                class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-medium"
            >
                Buat Akun
            </button>
            {{-- OLD: route('admin.guest.list') --}}
            <a href="{{ getAdminRoute('guest.list') }}" class="px-6 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 font-medium">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
