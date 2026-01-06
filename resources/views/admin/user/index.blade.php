@extends('layouts.admin')

@section('title', 'Manajemen User')
@section('page-title', 'Manajemen User')

@section('content')
{{-- Tombol Tambah User dan Tambah Data --}}
<div class="mb-4 flex gap-3">
    <a href="{{ getAdminRoute('user.create') }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 font-medium transition">
        <i class="fas fa-plus mr-2"></i>Tambah User
    </a>
    <button type="button" onclick="openTambahDataModal()" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-medium transition">
        <i class="fas fa-database mr-2"></i>Tambah Data
    </button>
</div>

<div class="mb-6 flex flex-wrap gap-4 items-center justify-between">
    <div class="flex gap-2">
        <a href="?role=" class="px-4 py-2 rounded font-medium transition {{ !request('role') ? 'bg-purple-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
            Semua
        </a>
        <a href="?role=admin" class="px-4 py-2 rounded font-medium transition {{ request('role') == 'admin' ? 'bg-purple-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
            Admin
        </a>
        <a href="?role=super_admin" class="px-4 py-2 rounded font-medium transition {{ request('role') == 'super_admin' ? 'bg-purple-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
            Super Admin
        </a>
        {{-- OLD: ?role=warga - tapi di database role-nya adalah 'user' --}}
        <a href="?role=user" class="px-4 py-2 rounded font-medium transition {{ request('role') == 'user' ? 'bg-purple-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
            Warga
        </a>
    </div>

    <form method="GET" action="{{ getAdminRoute('user.list') }}" class="flex gap-2">
        @if(request('role'))
            <input type="hidden" name="role" value="{{ request('role') }}">
        @endif
        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama/email..."
            class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
        <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 font-medium transition">
            <i class="fas fa-search"></i>
        </button>
        @if($search)
            <a href="{{ getAdminRoute('user.list') }}{{ request('role') ? '?role=' . request('role') : '' }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 font-medium transition">
                <i class="fas fa-times"></i>
            </a>
        @endif
    </form>
</div>

<div class="bg-white rounded-lg shadow overflow-x-auto">
    @if ($users->count() > 0)
        <table class="w-full">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Nama</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Email</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Role</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Tanggal Daftar</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm font-medium">{{ $user->name }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $user->email }}</td>
                        <td class="px-4 py-3 text-sm">
                            @if($user->role == 'super_admin')
                                <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs font-medium">Super Admin</span>
                            @elseif($user->role == 'admin')
                                <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs font-medium">Admin</span>
                            @else
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-medium">Warga</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $user->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-3 text-sm">
                            <div class="flex gap-2">
                                {{-- Admin tidak bisa edit/delete super_admin --}}
                                @if($user->role == 'super_admin' && auth()->user()->role == 'admin')
                                    <span class="text-gray-400" title="Tidak bisa mengedit Super Admin">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                @else
                                    <a href="{{ getAdminRoute('user.edit', $user->id) }}" class="text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($user->id != auth()->id())
                                        {{-- OLD: onsubmit="return confirm('Yakin ingin menghapus user ini?')" --}}
                                        <form action="{{ getAdminRoute('user.delete', $user->id) }}" method="POST" class="inline" onsubmit="event.preventDefault(); confirmDelete('Yakin ingin menghapus user {{ $user->name }}?', this);">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4">
            {{ $users->appends(request()->query())->links() }}
        </div>
    @else
        <div class="p-8 text-center text-gray-500">
            <i class="fas fa-users text-4xl mb-4"></i>
            <p>Belum ada data user</p>
        </div>
    @endif
</div>

{{-- Modal Tambah Data --}}
<div id="tambahDataModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-2xl max-w-lg w-full mx-4 transform transition-all">
        {{-- Header --}}
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4 rounded-t-xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <i class="fas fa-database text-white text-xl"></i>
                    <h3 class="text-xl font-bold text-white">Tambah Data untuk User</h3>
                </div>
                <button onclick="closeTambahDataModal()" class="text-white hover:text-gray-200 transition">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>

        {{-- Step 1: Pilih User --}}
        <div id="step1" class="p-6">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-user mr-2"></i>Pilih Akun User/Guest
                </label>
                <p class="text-gray-500 text-xs mb-3">
                    <i class="fas fa-info-circle mr-1"></i>
                    Pilih akun user yang akan ditambahkan datanya. Sistem akan otomatis membuat data warga jika belum ada.
                </p>
                <select id="selectedUser" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                    <option value="">-- Pilih Akun User --</option>
                    @php
                        // Get all users with role 'user'
                        $guestUsers = \App\Models\User::where('role', 'user')->orderBy('name')->get();
                    @endphp
                    @foreach($guestUsers as $guestUser)
                        @php
                            $linkedWarga = \App\Models\Warga::where('email', $guestUser->email)->first();
                        @endphp
                        <option value="{{ $guestUser->id }}"
                                data-user-name="{{ $guestUser->name }}"
                                data-user-email="{{ $guestUser->email }}"
                                data-warga-id="{{ $linkedWarga ? $linkedWarga->warga_id : '' }}"
                                data-has-warga="{{ $linkedWarga ? '1' : '0' }}">
                            {{ $guestUser->name }} ({{ $guestUser->email }}) {{ $linkedWarga ? '✓ Warga Ada' : '' }}
                        </option>
                    @endforeach
                </select>
                @if($guestUsers->isEmpty())
                    <div class="mt-3 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <p class="text-yellow-700 text-sm">
                            <i class="fas fa-exclamation-triangle mr-1"></i>
                            Tidak ada akun user/guest. Tambahkan akun user terlebih dahulu dengan tombol "Tambah User".
                        </p>
                    </div>
                @else
                    <div class="mt-3 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                        <p class="text-blue-700 text-sm">
                            <i class="fas fa-info-circle mr-1"></i>
                            <strong>Info:</strong> User dengan tanda "✓ Warga Ada" berarti sudah ada data warga dengan email yang sama. Jika belum ada, sistem akan otomatis membuatkan data warga.
                        </p>
                    </div>
                @endif
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="closeTambahDataModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 font-medium transition">
                    <i class="fas fa-times mr-2"></i>Batal
                </button>
                <button type="button" onclick="goToStep2()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition" id="btnNextStep">
                    <i class="fas fa-arrow-right mr-2"></i>Lanjut
                </button>
            </div>
        </div>

        {{-- Step 2: Pilih Jenis Data --}}
        <div id="step2" class="p-6 hidden">
            <div class="mb-4">
                <p class="text-sm text-gray-600 mb-4">
                    User terpilih: <span id="selectedUserDisplay" class="font-semibold text-purple-600"></span>
                </p>

                <label class="block text-sm font-medium text-gray-700 mb-3">
                    <i class="fas fa-folder mr-2"></i>Pilih Jenis Data
                </label>

                <div class="grid grid-cols-1 gap-3">
                    {{-- Persil --}}
                    <button type="button" onclick="redirectToForm('persil')" class="flex items-center gap-4 p-4 border-2 border-gray-200 rounded-xl hover:border-green-500 hover:bg-green-50 transition group">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-200 transition">
                            <i class="fas fa-map-marked-alt text-green-600 text-xl"></i>
                        </div>
                        <div class="text-left">
                            <p class="font-semibold text-gray-800">Tambah Persil</p>
                            <p class="text-xs text-gray-500">Data bidang tanah baru</p>
                        </div>
                    </button>

                    {{-- Dokumen Persil --}}
                    <button type="button" onclick="redirectToForm('dokumen')" class="flex items-center gap-4 p-4 border-2 border-gray-200 rounded-xl hover:border-blue-500 hover:bg-blue-50 transition group" id="btnDokumen" disabled>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition">
                            <i class="fas fa-file-alt text-blue-600 text-xl"></i>
                        </div>
                        <div class="text-left">
                            <p class="font-semibold text-gray-800">Tambah Dokumen Persil</p>
                            <p class="text-xs text-gray-500">Dokumen untuk persil yang sudah ada</p>
                        </div>
                    </button>

                    {{-- Peta Persil --}}
                    <button type="button" onclick="redirectToForm('peta')" class="flex items-center gap-4 p-4 border-2 border-gray-200 rounded-xl hover:border-purple-500 hover:bg-purple-50 transition group" id="btnPeta" disabled>
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-200 transition">
                            <i class="fas fa-map text-purple-600 text-xl"></i>
                        </div>
                        <div class="text-left">
                            <p class="font-semibold text-gray-800">Tambah Peta Persil</p>
                            <p class="text-xs text-gray-500">Data peta untuk persil yang sudah ada</p>
                        </div>
                    </button>

                    {{-- Sengketa Persil --}}
                    <button type="button" onclick="redirectToForm('sengketa')" class="flex items-center gap-4 p-4 border-2 border-gray-200 rounded-xl hover:border-red-500 hover:bg-red-50 transition group" id="btnSengketa" disabled>
                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center group-hover:bg-red-200 transition">
                            <i class="fas fa-gavel text-red-600 text-xl"></i>
                        </div>
                        <div class="text-left">
                            <p class="font-semibold text-gray-800">Tambah Sengketa Persil</p>
                            <p class="text-xs text-gray-500">Data sengketa untuk persil yang sudah ada</p>
                        </div>
                    </button>
                </div>

                {{-- Info Persil Milik User --}}
                <div id="persilListInfo" class="mt-4 p-3 bg-gray-50 border border-gray-200 rounded-lg hidden">
                    <p class="text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-list mr-1"></i>Persil milik user ini:
                    </p>
                    <div id="persilListContent" class="text-sm text-gray-600"></div>
                </div>
            </div>

            <div class="flex justify-between gap-3 mt-6">
                <button type="button" onclick="goToStep1()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 font-medium transition">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </button>
                <button type="button" onclick="closeTambahDataModal()" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 font-medium transition">
                    <i class="fas fa-times mr-2"></i>Tutup
                </button>
            </div>
        </div>

        {{-- Step 3: Pilih Persil (untuk dokumen, peta, sengketa) --}}
        <div id="step3" class="p-6 hidden">
            <div class="mb-4">
                <p class="text-sm text-gray-600 mb-2">
                    Warga: <span id="selectedUserDisplay2" class="font-semibold text-purple-600"></span>
                </p>
                <p class="text-sm text-gray-600 mb-4">
                    Jenis: <span id="selectedTypeDisplay" class="font-semibold text-blue-600"></span>
                </p>

                <label class="block text-sm font-medium text-gray-700 mb-3">
                    <i class="fas fa-map-marked-alt mr-2"></i>Pilih Persil
                </label>

                <select id="selectedPersil" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                    <option value="">-- Pilih Persil --</option>
                </select>
            </div>

            <div class="flex justify-between gap-3 mt-6">
                <button type="button" onclick="goToStep2()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 font-medium transition">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </button>
                <button type="button" onclick="submitPersilForm()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition" id="btnSubmitPersil">
                    <i class="fas fa-check mr-2"></i>Lanjut ke Form
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let selectedUserId = null;
    let selectedWargaId = null;
    let selectedUserName = '';
    let selectedDataType = '';
    let userPersils = [];

    // Use Laravel route helper for URLs - this ensures correct URL generation
    const getOrCreateWargaUrl = '{{ route(auth()->user()->role === "super_admin" ? "super-admin.user.get-or-create-warga" : "admin.user.get-or-create-warga") }}';
    const getPersilByWargaUrl = '{{ route(auth()->user()->role === "super_admin" ? "super-admin.user.get-persil-by-warga" : "admin.user.get-persil-by-warga") }}';
    const routePrefix = '{{ auth()->user()->role === "super_admin" ? "super-admin" : "admin" }}';

    // Get CSRF token from meta tag (more reliable)
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

    function openTambahDataModal() {
        document.getElementById('tambahDataModal').classList.remove('hidden');
        document.getElementById('step1').classList.remove('hidden');
        document.getElementById('step2').classList.add('hidden');
        document.getElementById('step3').classList.add('hidden');
        document.getElementById('selectedUser').value = '';
        selectedUserId = null;
        selectedWargaId = null;
        selectedUserName = '';
    }

    function closeTambahDataModal() {
        document.getElementById('tambahDataModal').classList.add('hidden');
    }

    function goToStep1() {
        document.getElementById('step1').classList.remove('hidden');
        document.getElementById('step2').classList.add('hidden');
        document.getElementById('step3').classList.add('hidden');
    }

    async function goToStep2() {
        const select = document.getElementById('selectedUser');
        if (!select.value) {
            alert('Silakan pilih user terlebih dahulu');
            return;
        }

        selectedUserId = select.value;
        const selectedOption = select.options[select.selectedIndex];
        selectedUserName = selectedOption.dataset.userName + ' (' + selectedOption.dataset.userEmail + ')';

        // ALWAYS call API to get or create warga - this ensures consistency
        // The API will return existing warga if already exists, or create new one
        let wargaId = null;

        try {
            document.getElementById('btnNextStep').disabled = true;
            document.getElementById('btnNextStep').innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';

            const response = await fetch(getOrCreateWargaUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ user_id: selectedUserId })
            });

            // Check if response is OK
            if (!response.ok) {
                const errorText = await response.text();
                console.error('Server Error:', response.status, errorText);
                alert('Gagal memproses data. Status: ' + response.status);
                return;
            }

            const data = await response.json();

            if (data.success) {
                wargaId = data.warga_id;
                // Update the option with warga_id
                selectedOption.dataset.wargaId = wargaId;
                selectedOption.dataset.hasWarga = '1';
            } else {
                alert('Gagal memproses data warga: ' + (data.message || 'Unknown error'));
                return;
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan: ' + error.message);
            return;
        } finally {
            document.getElementById('btnNextStep').disabled = false;
            document.getElementById('btnNextStep').innerHTML = '<i class="fas fa-arrow-right mr-2"></i>Lanjut';
        }

        selectedWargaId = wargaId;
        document.getElementById('selectedUserDisplay').textContent = selectedUserName;
        document.getElementById('selectedUserDisplay2').textContent = selectedUserName;

        // Fetch persil data for this warga via API
        try {
            const persilResponse = await fetch(getPersilByWargaUrl + '?warga_id=' + selectedWargaId);

            if (!persilResponse.ok) {
                console.error('Persil fetch error:', persilResponse.status);
                userPersils = [];
            } else {
                const persilData = await persilResponse.json();

                if (persilData.success) {
                    userPersils = persilData.persils.map(p => ({
                        id: p.persil_id,
                        kode: p.kode_persil,
                        alamat: p.alamat_lahan
                    }));
                } else {
                    userPersils = [];
                }
            }
        } catch (error) {
            console.error('Error fetching persil:', error);
            userPersils = [];
        }

        // Enable/disable buttons based on persil ownership
        const hasPersil = userPersils.length > 0;
        document.getElementById('btnDokumen').disabled = !hasPersil;
        document.getElementById('btnPeta').disabled = !hasPersil;
        document.getElementById('btnSengketa').disabled = !hasPersil;

        // Update button styles
        ['btnDokumen', 'btnPeta', 'btnSengketa'].forEach(btnId => {
            const btn = document.getElementById(btnId);
            if (hasPersil) {
                btn.classList.remove('opacity-50', 'cursor-not-allowed');
            } else {
                btn.classList.add('opacity-50', 'cursor-not-allowed');
            }
        });

        // Show persil list info
        const persilListInfo = document.getElementById('persilListInfo');
        const persilListContent = document.getElementById('persilListContent');
        if (hasPersil) {
            persilListInfo.classList.remove('hidden');
            persilListContent.innerHTML = userPersils.map(p =>
                `<span class="inline-block px-2 py-1 bg-green-100 text-green-700 rounded text-xs mr-1 mb-1">${p.kode}</span>`
            ).join('');
        } else {
            persilListInfo.classList.remove('hidden');
            persilListContent.innerHTML = '<span class="text-yellow-600"><i class="fas fa-exclamation-triangle mr-1"></i>User belum memiliki persil. Tambahkan persil terlebih dahulu.</span>';
        }

        document.getElementById('step1').classList.add('hidden');
        document.getElementById('step2').classList.remove('hidden');
        document.getElementById('step3').classList.add('hidden');
    }

    function redirectToForm(type) {
        selectedDataType = type;

        if (type === 'persil') {
            // Redirect langsung ke form persil dengan warga_id
            window.location.href = `/${routePrefix}/persil/create?warga_id=${selectedWargaId}`;
        } else {
            // Untuk dokumen, peta, sengketa - perlu pilih persil dulu
            if (userPersils.length === 0) {
                alert('User ini belum memiliki persil. Silakan tambahkan persil terlebih dahulu.');
                return;
            }

            // Populate persil dropdown
            const persilSelect = document.getElementById('selectedPersil');
            persilSelect.innerHTML = '<option value="">-- Pilih Persil --</option>';
            userPersils.forEach(p => {
                persilSelect.innerHTML += `<option value="${p.id}">${p.kode} - ${p.alamat}</option>`;
            });

            // Update type display
            const typeLabels = {
                'dokumen': 'Dokumen Persil',
                'peta': 'Peta Persil',
                'sengketa': 'Sengketa Persil'
            };
            document.getElementById('selectedTypeDisplay').textContent = typeLabels[type];

            document.getElementById('step2').classList.add('hidden');
            document.getElementById('step3').classList.remove('hidden');
        }
    }

    function submitPersilForm() {
        const persilId = document.getElementById('selectedPersil').value;
        if (!persilId) {
            alert('Silakan pilih persil terlebih dahulu');
            return;
        }

        // Redirect to appropriate form
        const routes = {
            'dokumen': `/${routePrefix}/persil/${persilId}/dokumen/create`,
            'peta': `/${routePrefix}/persil/${persilId}/peta/create`,
            'sengketa': `/${routePrefix}/persil/${persilId}/sengketa/create`
        };

        window.location.href = routes[selectedDataType];
    }

    // Close modal when clicking outside
    document.getElementById('tambahDataModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeTambahDataModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeTambahDataModal();
        }
    });
</script>
@endsection
