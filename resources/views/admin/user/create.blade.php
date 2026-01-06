@extends('layouts.admin')

@section('title', 'Buat User')
@section('page-title', 'Buat User Baru')

@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    {{-- OLD: action="{{ route('admin.user.store') }}" --}}
    <form action="{{ getAdminRoute('user.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Role Selection -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-3">
                Pilih Role <span class="text-red-500">*</span>
            </label>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                {{-- Super Admin hanya bisa dibuat oleh Super Admin --}}
                @if(auth()->user()->role == 'super_admin')
                <!-- Super Admin Card -->
                <label class="relative cursor-pointer">
                    <input type="radio" name="role" value="super_admin" class="hidden peer" {{ old('role') == 'super_admin' ? 'checked' : '' }}>
                    <div class="border-2 border-gray-300 rounded-lg p-4 hover:border-red-500 transition peer-checked:border-red-600 peer-checked:bg-red-50"
                         id="superAdminCard">
                        <div class="flex items-center gap-3 mb-2">
                            <i class="fas fa-shield-alt text-red-600 text-2xl"></i>
                            <h3 class="text-lg font-bold text-gray-800">Super Admin</h3>
                        </div>
                        <p class="text-gray-600 text-sm">
                            Akses penuh ke semua fitur dan manajemen sistem.
                        </p>
                    </div>
                </label>
                @endif

                <!-- Admin Card -->
                <label class="relative cursor-pointer">
                    <input type="radio" name="role" value="admin" class="hidden peer" {{ old('role') == 'admin' ? 'checked' : '' }}>
                    <div class="border-2 border-gray-300 rounded-lg p-4 hover:border-purple-500 transition peer-checked:border-purple-600 peer-checked:bg-purple-50"
                         id="adminCard">
                        <div class="flex items-center gap-3 mb-2">
                            <i class="fas fa-crown text-purple-600 text-2xl"></i>
                            <h3 class="text-lg font-bold text-gray-800">Admin</h3>
                        </div>
                        <p class="text-gray-600 text-sm">
                            User dengan akses penuh ke sistem. Bisa membuat dan mengelola user.
                        </p>
                    </div>
                </label>

                <!-- User/Warga Card -->
                {{-- OLD: value="guest" - tapi di database role-nya adalah 'user' --}}
                <label class="relative cursor-pointer">
                    <input type="radio" name="role" value="user" class="hidden peer" {{ old('role', 'user') == 'user' ? 'checked' : '' }}>
                    <div class="border-2 border-gray-300 rounded-lg p-4 hover:border-blue-500 transition peer-checked:border-blue-600 peer-checked:bg-blue-50"
                         id="userCard">
                        <div class="flex items-center gap-3 mb-2">
                            <i class="fas fa-user text-blue-600 text-2xl"></i>
                            <h3 class="text-lg font-bold text-gray-800">Warga</h3>
                        </div>
                        <p class="text-gray-600 text-sm">
                            User terbatas. Hanya bisa melihat data persil yang dimiliki.
                        </p>
                    </div>
                </label>
            </div>
            @if ($errors->has('role'))
                <p class="text-red-500 text-sm mt-2">{{ $errors->first('role') }}</p>
            @endif
        </div>

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
                class="w-full px-4 py-2 border @if($errors->has('name')) border-red-500 @else border-gray-300 @endif rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                required
            >
            @if ($errors->has('name'))
                <p class="text-red-500 text-sm mt-1">{{ $errors->first('name') }}</p>
            @endif
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
                class="w-full px-4 py-2 border @if($errors->has('email')) border-red-500 @else border-gray-300 @endif rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                required
            >
            @if ($errors->has('email'))
                <p class="text-red-500 text-sm mt-1">{{ $errors->first('email') }}</p>
            @endif
        </div>

        <!-- Password -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    Password <span class="text-red-500">*</span>
                </label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="w-full px-4 py-2 border @if($errors->has('password')) border-red-500 @else border-gray-300 @endif rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                    required
                >
                @if ($errors->has('password'))
                    <p class="text-red-500 text-sm mt-1">{{ $errors->first('password') }}</p>
                @endif
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                    Konfirmasi Password <span class="text-red-500">*</span>
                </label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                    required
                >
            </div>
        </div>

        <!-- Buttons -->
        <div class="flex space-x-4 pt-4">
            <button
                type="submit"
                class="px-6 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 font-medium transition"
            >
                <i class="fas fa-save mr-2"></i>Buat User
            </button>
            {{-- OLD: href="{{ route('admin.dashboard') }}" --}}
            <a href="{{ getAdminRoute('user.list') }}" class="px-6 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 font-medium transition">
                <i class="fas fa-times mr-2"></i>Batal
            </a>
        </div>
    </form>
</div>

{{-- OLD: Custom JS for radio styling - now using Tailwind peer classes --}}
@endsection
