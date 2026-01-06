<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Debug - Persil Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .card { transition: transform 0.2s; }
        .card:hover { transform: translateY(-2px); }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-xl shadow-lg p-6 mb-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold flex items-center gap-3">
                        <i class="fas fa-database"></i>
                        Database Debug
                    </h1>
                    <p class="mt-2 text-blue-100">Persil Admin Project - {{ now()->format('d M Y H:i:s') }}</p>
                </div>
                <div class="text-right">
                    <a href="{{ url('/') }}" class="bg-white/20 hover:bg-white/30 px-4 py-2 rounded-lg transition">
                        <i class="fas fa-home mr-2"></i>Back to Home
                    </a>
                </div>
            </div>
        </div>

        <!-- Database Connection -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-6 card">
            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-plug text-green-500"></i>
                Database Connection
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-500">Driver</p>
                    <p class="font-semibold text-gray-800">{{ $connection['driver'] }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-500">Host</p>
                    <p class="font-semibold text-gray-800">{{ $connection['host'] }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-500">Database</p>
                    <p class="font-semibold text-gray-800">{{ $connection['database'] }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-500">Status</p>
                    <p class="font-semibold text-green-600"><i class="fas fa-check-circle mr-1"></i>Connected</p>
                </div>
            </div>
        </div>

        <!-- Table Summary -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-6 card">
            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-table text-blue-500"></i>
                Table Summary
            </h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($tableCounts as $table => $count)
                <div class="bg-gradient-to-br from-gray-50 to-gray-100 p-4 rounded-lg border border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">{{ $table }}</p>
                            <p class="text-2xl font-bold text-gray-800">{{ number_format($count) }}</p>
                        </div>
                        <div class="text-3xl {{ $count > 0 ? 'text-green-500' : 'text-gray-300' }}">
                            @if($count > 0)
                                <i class="fas fa-check-circle"></i>
                            @else
                                <i class="fas fa-minus-circle"></i>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mt-4 p-4 bg-blue-50 rounded-lg">
                <p class="text-blue-800 font-semibold">
                    <i class="fas fa-chart-bar mr-2"></i>
                    Total Records: {{ number_format($totalRecords) }}
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Users by Role -->
            <div class="bg-white rounded-xl shadow-md p-6 card">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-users text-purple-500"></i>
                    Users by Role
                </h2>
                <div class="space-y-3">
                    @foreach($usersByRole as $role)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center gap-3">
                            @if($role->role == 'super_admin')
                                <span class="text-2xl">👑</span>
                            @elseif($role->role == 'admin')
                                <span class="text-2xl">🔧</span>
                            @else
                                <span class="text-2xl">👤</span>
                            @endif
                            <span class="font-medium text-gray-700 capitalize">{{ str_replace('_', ' ', $role->role) }}</span>
                        </div>
                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full font-semibold">{{ $role->total }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Login Credentials -->
            <div class="bg-white rounded-xl shadow-md p-6 card">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-key text-yellow-500"></i>
                    Sample Login Credentials
                </h2>
                <div class="space-y-3">
                    @if($superAdmin)
                    <div class="p-4 bg-purple-50 rounded-lg border border-purple-200">
                        <p class="font-semibold text-purple-800">👑 Super Admin</p>
                        <p class="text-sm text-gray-600 mt-1">Email: <code class="bg-white px-2 py-1 rounded">{{ $superAdmin->email }}</code></p>
                        <p class="text-sm text-gray-600">Password: <code class="bg-white px-2 py-1 rounded">password</code></p>
                    </div>
                    @endif
                    @if($admin)
                    <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <p class="font-semibold text-blue-800">🔧 Admin</p>
                        <p class="text-sm text-gray-600 mt-1">Email: <code class="bg-white px-2 py-1 rounded">{{ $admin->email }}</code></p>
                        <p class="text-sm text-gray-600">Password: <code class="bg-white px-2 py-1 rounded">password</code></p>
                    </div>
                    @endif
                    @if($user)
                    <div class="p-4 bg-green-50 rounded-lg border border-green-200">
                        <p class="font-semibold text-green-800">👤 User</p>
                        <p class="text-sm text-gray-600 mt-1">Email: <code class="bg-white px-2 py-1 rounded">{{ $user->email }}</code></p>
                        <p class="text-sm text-gray-600">Password: <code class="bg-white px-2 py-1 rounded">password</code></p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <!-- Persil Statistics -->
            <div class="bg-white rounded-xl shadow-md p-6 card">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-home text-green-500"></i>
                    Persil by Penggunaan
                </h2>
                <div class="space-y-2">
                    @foreach($persilByPenggunaan as $p)
                    <div class="flex items-center justify-between p-2 hover:bg-gray-50 rounded">
                        <span class="text-gray-600">{{ $p->penggunaan }}</span>
                        <div class="text-right">
                            <span class="font-semibold text-gray-800">{{ $p->total }}</span>
                            <span class="text-xs text-gray-500 ml-1">({{ number_format($p->total_luas) }} m²)</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Sengketa Statistics -->
            <div class="bg-white rounded-xl shadow-md p-6 card">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-balance-scale text-red-500"></i>
                    Sengketa Status
                </h2>
                <div class="space-y-3">
                    @foreach($sengketaByStatus as $s)
                    <div class="flex items-center justify-between p-3 rounded-lg
                        @if($s->status == 'selesai') bg-green-50
                        @elseif($s->status == 'proses') bg-yellow-50
                        @else bg-gray-50
                        @endif">
                        <div class="flex items-center gap-2">
                            @if($s->status == 'selesai')
                                <span class="text-green-500"><i class="fas fa-check-circle"></i></span>
                            @elseif($s->status == 'proses')
                                <span class="text-yellow-500"><i class="fas fa-sync-alt"></i></span>
                            @else
                                <span class="text-gray-500"><i class="fas fa-clock"></i></span>
                            @endif
                            <span class="font-medium capitalize">{{ $s->status }}</span>
                        </div>
                        <span class="font-bold">{{ $s->total }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Media Statistics -->
            <div class="bg-white rounded-xl shadow-md p-6 card">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-photo-video text-indigo-500"></i>
                    Media Files
                </h2>
                <div class="space-y-2">
                    @foreach($mediaByRef as $m)
                    <div class="flex items-center justify-between p-2 hover:bg-gray-50 rounded">
                        <span class="text-gray-600">
                            <i class="fas fa-folder text-yellow-500 mr-2"></i>
                            {{ $m->ref_table }}
                        </span>
                        <span class="bg-indigo-100 text-indigo-800 px-2 py-1 rounded text-sm font-semibold">{{ $m->total }} files</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Warga Statistics -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-6 card">
            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-id-card text-teal-500"></i>
                Warga Statistics
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="font-semibold text-gray-700 mb-3">By Gender</h3>
                    <div class="flex gap-4">
                        @foreach($wargaByGender as $w)
                        <div class="flex-1 p-4 rounded-lg {{ $w->jenis_kelamin == 'L' ? 'bg-blue-50' : 'bg-pink-50' }}">
                            <div class="text-3xl mb-2">{{ $w->jenis_kelamin == 'L' ? '👨' : '👩' }}</div>
                            <p class="font-semibold text-gray-800">{{ $w->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                            <p class="text-2xl font-bold {{ $w->jenis_kelamin == 'L' ? 'text-blue-600' : 'text-pink-600' }}">{{ $w->total }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-700 mb-3">By Agama</h3>
                    <div class="grid grid-cols-3 gap-2">
                        @foreach($wargaByAgama as $w)
                        <div class="p-2 bg-gray-50 rounded text-center">
                            <p class="text-sm text-gray-600">{{ $w->agama }}</p>
                            <p class="font-bold text-gray-800">{{ $w->total }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Foreign Key Integrity -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-6 card">
            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-link text-orange-500"></i>
                Foreign Key Integrity Check
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($integrityChecks as $check)
                <div class="flex items-center justify-between p-3 rounded-lg {{ $check['status'] ? 'bg-green-50' : 'bg-red-50' }}">
                    <div>
                        <p class="font-medium text-gray-800">{{ $check['relation'] }}</p>
                        <p class="text-xs text-gray-500">{{ $check['description'] }}</p>
                    </div>
                    @if($check['status'])
                        <span class="text-green-500 text-xl"><i class="fas fa-check-circle"></i></span>
                    @else
                        <span class="text-red-500 text-xl"><i class="fas fa-times-circle"></i></span>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

        <!-- Sample Data -->
        <div class="bg-white rounded-xl shadow-md p-6 card">
            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-list text-cyan-500"></i>
                Sample Data Preview
            </h2>

            <!-- Sample Persil -->
            <h3 class="font-semibold text-gray-700 mt-4 mb-3">🏠 Sample Persil</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left">Kode</th>
                            <th class="px-4 py-2 text-left">Pemilik</th>
                            <th class="px-4 py-2 text-left">Penggunaan</th>
                            <th class="px-4 py-2 text-left">Luas</th>
                            <th class="px-4 py-2 text-left">Alamat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach($samplePersil as $p)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 font-mono text-blue-600">{{ $p->kode_persil }}</td>
                            <td class="px-4 py-2">{{ $p->pemilik }}</td>
                            <td class="px-4 py-2"><span class="bg-gray-100 px-2 py-1 rounded text-xs">{{ $p->penggunaan }}</span></td>
                            <td class="px-4 py-2">{{ number_format($p->luas_m2) }} m²</td>
                            <td class="px-4 py-2 text-gray-600">{{ $p->alamat_lahan }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Sample Warga -->
            <h3 class="font-semibold text-gray-700 mt-6 mb-3">👥 Sample Warga</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left">No KTP</th>
                            <th class="px-4 py-2 text-left">Nama</th>
                            <th class="px-4 py-2 text-left">JK</th>
                            <th class="px-4 py-2 text-left">Email</th>
                            <th class="px-4 py-2 text-left">Telp</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach($sampleWarga as $w)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 font-mono text-xs">{{ $w->no_ktp }}</td>
                            <td class="px-4 py-2">{{ $w->jenis_kelamin == 'L' ? '👨' : '👩' }} {{ $w->nama }}</td>
                            <td class="px-4 py-2">{{ $w->jenis_kelamin }}</td>
                            <td class="px-4 py-2 text-gray-600">{{ $w->email }}</td>
                            <td class="px-4 py-2">{{ $w->telp }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Sample Sengketa -->
            <h3 class="font-semibold text-gray-700 mt-6 mb-3">⚖️ Sample Sengketa</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left">Persil</th>
                            <th class="px-4 py-2 text-left">Pihak 1</th>
                            <th class="px-4 py-2 text-left">Pihak 2</th>
                            <th class="px-4 py-2 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach($sampleSengketa as $s)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 font-mono text-blue-600">{{ $s->kode_persil }}</td>
                            <td class="px-4 py-2">{{ $s->pihak_1 }}</td>
                            <td class="px-4 py-2">{{ $s->pihak_2 }}</td>
                            <td class="px-4 py-2">
                                @if($s->status == 'selesai')
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">✅ Selesai</span>
                                @elseif($s->status == 'proses')
                                    <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs">🔄 Proses</span>
                                @else
                                    <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-xs">🕐 Pending</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center text-gray-500 text-sm">
            <p>Persil Admin Database Debug Tool &copy; {{ date('Y') }}</p>
        </div>
    </div>
</body>
</html>
