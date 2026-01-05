@extends('layouts.admin')

@section('title', 'Buat User')
@section('page-title', 'Buat User Baru')

@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <form action="{{ route('admin.user.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Role Selection -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-3">
                Pilih Role <span class="text-red-500">*</span>
            </label>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Admin Card -->
                <label class="relative cursor-pointer">
                    <input type="radio" name="role" value="admin" class="hidden" onchange="updateRoleInfo()">
                    <div class="border-2 border-gray-300 rounded-lg p-4 hover:border-purple-500 transition has-checked:border-purple-600 has-checked:bg-purple-50"
                         id="adminCard">
                        <div class="flex items-center gap-3 mb-2">
                            <i class="fas fa-crown text-purple-600 text-2xl"></i>
                            <h3 class="text-lg font-bold text-gray-800">Admin</h3>
                        </div>
                        <p class="text-gray-600 text-sm">
                            User dengan akses penuh ke sistem. Bisa membuat dan mengelola guest user.
                        </p>
                    </div>
                </label>

                <!-- Guest Card -->
                <label class="relative cursor-pointer">
                    <input type="radio" name="role" value="guest" class="hidden" onchange="updateRoleInfo()">
                    <div class="border-2 border-gray-300 rounded-lg p-4 hover:border-blue-500 transition has-checked:border-blue-600 has-checked:bg-blue-50"
                         id="guestCard">
                        <div class="flex items-center gap-3 mb-2">
                            <i class="fas fa-user text-blue-600 text-2xl"></i>
                            <h3 class="text-lg font-bold text-gray-800">Guest</h3>
                        </div>
                        <p class="text-gray-600 text-sm">
                            User terbatas. Hanya bisa melihat data persil yang ditugaskan.
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
            <a href="{{ route('admin.dashboard') }}" class="px-6 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 font-medium transition">
                <i class="fas fa-times mr-2"></i>Batal
            </a>
        </div>
    </form>
</div>

<style>
    /* Style for checked radio buttons */
    input[type="radio"]:checked + div {
        border-color: currentColor !important;
        background-color: rgba(0, 0, 0, 0.02) !important;
    }

    #adminCard {
        --tw-border-opacity: 1;
    }

    input[value="admin"]:checked + #adminCard {
        @apply border-purple-600 bg-purple-50;
    }

    input[value="guest"]:checked + #guestCard {
        @apply border-blue-600 bg-blue-50;
    }
</style>

<script>
    function updateRoleInfo() {
        const adminCard = document.getElementById('adminCard');
        const guestCard = document.getElementById('guestCard');
        const adminRadio = document.querySelector('input[value="admin"]');
        const guestRadio = document.querySelector('input[value="guest"]');

        if (adminRadio.checked) {
            adminCard.classList.add('border-purple-600', 'bg-purple-50');
            guestCard.classList.remove('border-blue-600', 'bg-blue-50');
        } else {
            guestCard.classList.add('border-blue-600', 'bg-blue-50');
            adminCard.classList.remove('border-purple-600', 'bg-purple-50');
        }
    }

    // Initialize on load
    document.addEventListener('DOMContentLoaded', function() {
        updateRoleInfo();
    });
</script>
@endsection
