@extends('layouts.admin')

@section('title', 'Kelola Guest')
@section('page-title', 'Kelola Guest User')

@section('content')
<div class="mb-6">
    <div class="flex gap-4 items-center">
        <a href="{{ getAdminRoute('guest.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-medium transition">
            <i class="fas fa-user-plus mr-2"></i>Tambah Guest User
        </a>

        <!-- Search Form -->
        <form method="GET" action="{{ getAdminRoute('guest.list') }}" class="flex-1 flex gap-2">
            <div class="flex-1 relative">
                <input
                    type="text"
                    name="search"
                    value="{{ $search ?? '' }}"
                    placeholder="Cari nama atau email..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-medium transition">
                <i class="fas fa-search mr-2"></i>Cari
            </button>
            @if($search)
                <a href="{{ getAdminRoute('guest.list') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 font-medium transition">
                    <i class="fas fa-times mr-2"></i>Reset
                </a>
            @endif
        </form>
    </div>

    @if($search)
        <p class="text-gray-600 text-sm mt-2">
            <i class="fas fa-info-circle mr-1"></i>
            Hasil pencarian untuk: <strong>"{{ $search }}"</strong>
        </p>
    @endif
</div>

<div class="bg-white rounded-lg shadow overflow-x-auto">
    @if ($guests->count() > 0)
        <table class="w-full">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Nama</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Email</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Role</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Tanggal Dibuat</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($guests as $guest)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm font-medium">{{ $guest->name }}</td>
                        <td class="px-4 py-3 text-sm">{{ $guest->email }}</td>
                        <td class="px-4 py-3 text-sm">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                {{ ucfirst($guest->role) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm">{{ $guest->created_at->format('d-m-Y') }}</td>
                        <td class="px-4 py-3 text-sm space-x-2 flex items-center">
                            <a href="{{ getAdminRoute('guest.edit', $guest->id) }}" class="text-blue-600 hover:text-blue-700 hover:scale-110 transition" title="Edit">
                                <i class="fas fa-edit text-lg"></i>
                            </a>
                            <form id="guestDeleteForm-{{ $guest->id }}" action="{{ getAdminRoute('guest.delete', $guest->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                {{-- OLD: showConfirm('Hapus akun guest ...?', document.getElementById('guestDeleteForm-...')) --}}
                                <button type="button" onclick="confirmDelete('guestDeleteForm-{{ $guest->id }}', 'Hapus akun guest {{ $guest->name }}?')" class="text-red-600 hover:text-red-700 hover:scale-110 transition" title="Hapus">
                                    <i class="fas fa-trash text-lg"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="px-4 py-4">
            {{ $guests->links() }}
        </div>
    @else
        <div class="p-8 text-center">
            <p class="text-gray-600">Belum ada guest user</p>
        </div>
    @endif
</div>
@endsection
