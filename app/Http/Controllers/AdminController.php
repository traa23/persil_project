<?php
namespace App\Http\Controllers;

use App\Models\DokumenPersil;
use App\Models\FotoPersil;
use App\Models\JenisPenggunaan;
use App\Models\Persil;
use App\Models\PetaPersil;
use App\Models\SengketaPersil;
use App\Models\User;
use App\Models\Warga;
use App\Services\AdminInheritanceService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Get route prefix based on user role
     */
    protected function getPrefix()
    {
        return auth()->user()->role === 'super_admin' ? 'super-admin' : 'admin';
    }

    public function dashboard()
    {
        $totalPersil  = Persil::count();
        $totalUser    = User::where('role', 'user')->count();
        $totalWarga   = Warga::count();
        $recentPersil = Persil::with('pemilik')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('totalPersil', 'totalUser', 'totalWarga', 'recentPersil'));
    }

    // Persil Management
    public function persilList()
    {
        $search = request('search');

        $persils = Persil::with('pemilik');

        // Apply search filter
        if ($search) {
            $persils->where(function ($query) use ($search) {
                $query->where('kode_persil', 'LIKE', '%' . $search . '%')
                    ->orWhere('alamat_lahan', 'LIKE', '%' . $search . '%')
                    ->orWhere('penggunaan', 'LIKE', '%' . $search . '%')
                    ->orWhereHas('pemilik', function ($q) use ($search) {
                        $q->where('nama', 'LIKE', '%' . $search . '%');
                    });
            });
        }

        $persils = $persils->paginate(15)->appends(request()->query());

        return view('admin.persil.index', compact('persils', 'search'));
    }

    public function persilDetail($id)
    {
        $persil = Persil::with('pemilik', 'dokumenPersil', 'petaPersil', 'sengketa', 'fotoPersil', 'media')
            ->findOrFail($id);

        return view('admin.persil.detail', compact('persil'));
    }

    public function persilCreate()
    {
        $wargaList       = Warga::orderBy('nama')->get();
        $jenisPenggunaan = JenisPenggunaan::orderBy('nama_penggunaan')->get();

        return view('admin.persil.create', compact('wargaList', 'jenisPenggunaan'));
    }

    public function persilStore(Request $request)
    {
        $validated = $request->validate([
            'kode_persil'             => 'required|unique:persil',
            'pemilik_warga_id'        => 'required|exists:warga,warga_id',
            'luas_m2'                 => 'required|numeric',
            'jenis_penggunaan_custom' => 'required|string',
            'alamat_lahan'            => 'required',
            'rt'                      => 'nullable|string|max:3',
            'rw'                      => 'nullable|string|max:3',
            'foto_persil'             => 'nullable|array',
            'foto_persil.*'           => 'image|max:2048',
        ]);

        // Siapkan data untuk disimpan
        $persilData = [
            'kode_persil'      => $validated['kode_persil'],
            'pemilik_warga_id' => $validated['pemilik_warga_id'],
            'luas_m2'          => $validated['luas_m2'],
            'penggunaan'       => $validated['jenis_penggunaan_custom'],
            'alamat_lahan'     => $validated['alamat_lahan'],
            'rt'               => $validated['rt'] ?? null,
            'rw'               => $validated['rw'] ?? null,
        ];

        // Create persil
        $persil = Persil::create($persilData);

        // Store multiple photos
        if ($request->hasFile('foto_persil')) {
            $fotos = $request->file('foto_persil', []);
            foreach ($fotos as $foto) {
                $path = $foto->store('persil', 'public');
                FotoPersil::create([
                    'persil_id'     => $persil->persil_id,
                    'file_path'     => $path,
                    'original_name' => $foto->getClientOriginalName(),
                    'file_size'     => $foto->getSize(),
                ]);
            }
        }

        return redirect()->route($this->getPrefix() . '.persil.list')->with('success', 'Data persil berhasil ditambahkan');
    }

    public function persilEdit($id)
    {
        $persil          = Persil::findOrFail($id);
        $wargaList       = Warga::orderBy('nama')->get();
        $jenisPenggunaan = JenisPenggunaan::orderBy('nama_penggunaan')->get();

        return view('admin.persil.edit', compact('persil', 'wargaList', 'jenisPenggunaan'));
    }

    public function persilUpdate(Request $request, $id)
    {
        $persil = Persil::findOrFail($id);

        $validated = $request->validate([
            'kode_persil'      => 'required|unique:persil,kode_persil,' . $id . ',persil_id',
            'pemilik_warga_id' => 'required|exists:warga,warga_id',
            'luas_m2'          => 'required|numeric',
            'penggunaan'       => 'required|string',
            'alamat_lahan'     => 'required',
            'rt'               => 'nullable|string|max:3',
            'rw'               => 'nullable|string|max:3',
            'foto_persil'      => 'nullable|array',
            'foto_persil.*'    => 'image|max:2048',
        ]);

        // Siapkan data untuk diupdate
        $persilData = [
            'kode_persil'      => $validated['kode_persil'],
            'pemilik_warga_id' => $validated['pemilik_warga_id'],
            'luas_m2'          => $validated['luas_m2'],
            'penggunaan'       => $validated['penggunaan'],
            'alamat_lahan'     => $validated['alamat_lahan'],
            'rt'               => $validated['rt'],
            'rw'               => $validated['rw'],
        ];

        $persil->update($persilData);

        // Store additional photos (keep existing)
        if ($request->hasFile('foto_persil')) {
            $fotos = $request->file('foto_persil', []);
            foreach ($fotos as $foto) {
                $path = $foto->store('persil', 'public');
                FotoPersil::create([
                    'persil_id'     => $persil->persil_id,
                    'file_path'     => $path,
                    'original_name' => $foto->getClientOriginalName(),
                    'file_size'     => $foto->getSize(),
                ]);
            }
        }

        return redirect()->route($this->getPrefix() . '.persil.list')->with('success', 'Data persil berhasil diperbarui');
    }

    public function persilDelete($id)
    {
        $persil = Persil::findOrFail($id);

        // Delete all related photos
        foreach ($persil->fotoPersil as $foto) {
            \Storage::disk('public')->delete($foto->file_path);
            $foto->delete();
        }

        $persil->delete();

        return redirect()->route($this->getPrefix() . '.persil.list')->with('success', 'Data persil berhasil dihapus');
    }

    // Delete single photo
    public function fotoPersilDelete($id)
    {
        $foto = FotoPersil::findOrFail($id);
        \Storage::disk('public')->delete($foto->file_path);
        $foto->delete();

        return back()->with('success', 'Foto berhasil dihapus');
    }

    // Warga Management (menggantikan Guest Management)
    public function wargaList()
    {
        $search = request('search');

        $wargaList = Warga::query();

        // Apply search filter
        if ($search) {
            $wargaList->where(function ($query) use ($search) {
                $query->where('nama', 'LIKE', '%' . $search . '%')
                    ->orWhere('no_ktp', 'LIKE', '%' . $search . '%')
                    ->orWhere('email', 'LIKE', '%' . $search . '%');
            });
        }

        $wargaList = $wargaList->paginate(15)->appends(request()->query());

        return view('admin.warga.index', compact('wargaList', 'search'));
    }

    public function wargaCreate()
    {
        return view('admin.warga.create');
    }

    public function wargaStore(Request $request)
    {
        $validated = $request->validate([
            'no_ktp'        => 'required|string|size:16|unique:warga,no_ktp',
            'nama'          => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'agama'         => 'required|string|max:50',
            'pekerjaan'     => 'required|string|max:100',
            'telp'          => 'nullable|string|max:20',
            'email'         => 'nullable|email|max:255',
        ]);

        Warga::create($validated);

        return redirect()->route($this->getPrefix() . '.warga.list')->with('success', 'Data warga berhasil ditambahkan');
    }

    public function wargaEdit($id)
    {
        $warga = Warga::findOrFail($id);

        return view('admin.warga.edit', compact('warga'));
    }

    public function wargaUpdate(Request $request, $id)
    {
        $warga = Warga::findOrFail($id);

        $validated = $request->validate([
            'no_ktp'        => 'required|string|size:16|unique:warga,no_ktp,' . $id . ',warga_id',
            'nama'          => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'agama'         => 'required|string|max:50',
            'pekerjaan'     => 'required|string|max:100',
            'telp'          => 'nullable|string|max:20',
            'email'         => 'nullable|email|max:255',
        ]);

        $warga->update($validated);

        return redirect()->route($this->getPrefix() . '.warga.list')->with('success', 'Data warga berhasil diperbarui');
    }

    public function wargaDelete($id)
    {
        $warga = Warga::findOrFail($id);
        $warga->delete();

        return redirect()->route($this->getPrefix() . '.warga.list')->with('success', 'Data warga berhasil dihapus');
    }

    public function wargaDetail($id)
    {
        $warga = Warga::with('persil')->findOrFail($id);
        return view('admin.warga.detail', compact('warga'));
    }

    // User Management (Create admin/user only - no guest)
    public function userCreate()
    {
        return view('admin.user.create');
    }

    public function userStore(Request $request)
    {
        // OLD: 'role' => 'required|in:admin,user' - tidak support super_admin
        // NEW: Super admin bisa buat semua role, admin hanya bisa buat admin dan user
        $allowedRoles = auth()->user()->role === 'super_admin'
            ? 'required|in:super_admin,admin,user'
            : 'required|in:admin,user';

        $validated = $request->validate([
            'name'     => 'required|string',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role'     => $allowedRoles,
        ]);

        $validated['password'] = bcrypt($validated['password']);

        if ($validated['role'] === 'admin') {
            // Jika role admin, set parent_admin_id dari current admin
            $validated['parent_admin_id'] = auth()->id();
        }

        $newUser = User::create($validated);

        // Jika role admin, inherit data dari parent admin
        if ($validated['role'] === 'admin') {
            try {
                $inheritanceService = new AdminInheritanceService();
                $inheritanceService->inheritDataFromParentAdmin($newUser, auth()->user());
            } catch (\Exception $e) {
                \Log::error('Admin inheritance failed: ' . $e->getMessage(), [
                    'new_admin_id'    => $newUser->id,
                    'parent_admin_id' => auth()->id(),
                    'error'           => $e,
                ]);
                return back()->with('error', 'Akun admin dibuat, tapi gagal copy data: ' . $e->getMessage());
            }
        }

        $roleLabel = $validated['role'] === 'admin' ? 'Admin' : 'User';
        return back()->with('success', 'Akun ' . $roleLabel . ' berhasil dibuat');
    }

    // ========================================
    // DOKUMEN PERSIL MANAGEMENT
    // ========================================
    public function dokumenList()
    {
        $search   = request('search');
        $dokumens = DokumenPersil::with('persil.pemilik');

        if ($search) {
            $dokumens->where(function ($query) use ($search) {
                $query->where('jenis_dokumen', 'LIKE', '%' . $search . '%')
                    ->orWhere('nomor', 'LIKE', '%' . $search . '%')
                    ->orWhereHas('persil', function ($q) use ($search) {
                        $q->where('kode_persil', 'LIKE', '%' . $search . '%');
                    });
            });
        }

        $dokumens = $dokumens->latest()->paginate(15)->appends(request()->query());
        return view('admin.dokumen.index', compact('dokumens', 'search'));
    }

    public function dokumenDetail($id)
    {
        $dokumen = DokumenPersil::with('persil.pemilik')->findOrFail($id);
        return view('admin.dokumen.detail', compact('dokumen'));
    }

    // ========================================
    // PETA PERSIL MANAGEMENT
    // ========================================
    public function petaList()
    {
        $search = request('search');
        $petas  = PetaPersil::with('persil.pemilik');

        if ($search) {
            $petas->whereHas('persil', function ($q) use ($search) {
                $q->where('kode_persil', 'LIKE', '%' . $search . '%')
                    ->orWhere('alamat_lahan', 'LIKE', '%' . $search . '%');
            });
        }

        $petas = $petas->latest()->paginate(15)->appends(request()->query());
        return view('admin.peta.index', compact('petas', 'search'));
    }

    public function petaDetail($id)
    {
        $peta = PetaPersil::with('persil.pemilik')->findOrFail($id);
        return view('admin.peta.detail', compact('peta'));
    }

    // ========================================
    // SENGKETA PERSIL MANAGEMENT
    // ========================================
    public function sengketaList()
    {
        $search    = request('search');
        $status    = request('status');
        $sengketas = SengketaPersil::with('persil.pemilik');

        if ($search) {
            $sengketas->where(function ($query) use ($search) {
                $query->where('pihak_1', 'LIKE', '%' . $search . '%')
                    ->orWhere('pihak_2', 'LIKE', '%' . $search . '%')
                    ->orWhereHas('persil', function ($q) use ($search) {
                        $q->where('kode_persil', 'LIKE', '%' . $search . '%');
                    });
            });
        }

        if ($status) {
            $sengketas->where('status', $status);
        }

        $sengketas = $sengketas->latest()->paginate(15)->appends(request()->query());
        return view('admin.sengketa.index', compact('sengketas', 'search', 'status'));
    }

    public function sengketaDetail($id)
    {
        $sengketa = SengketaPersil::with('persil.pemilik')->findOrFail($id);
        return view('admin.sengketa.detail', compact('sengketa'));
    }

    // ========================================
    // JENIS PENGGUNAAN MANAGEMENT
    // ========================================
    public function jenisPenggunaanList()
    {
        $search    = request('search');
        $jenisList = JenisPenggunaan::query();

        if ($search) {
            $jenisList->where('nama_penggunaan', 'LIKE', '%' . $search . '%');
        }

        $jenisList = $jenisList->orderBy('nama_penggunaan')->paginate(15)->appends(request()->query());
        return view('admin.jenis-penggunaan.index', compact('jenisList', 'search'));
    }

    public function jenisPenggunaanCreate()
    {
        return view('admin.jenis-penggunaan.create');
    }

    public function jenisPenggunaanStore(Request $request)
    {
        $validated = $request->validate([
            'nama_penggunaan' => 'required|string|max:255|unique:jenis_penggunaan,nama_penggunaan',
            'keterangan'      => 'nullable|string',
        ]);

        JenisPenggunaan::create($validated);
        return redirect()->route($this->getPrefix() . '.jenis-penggunaan.list')->with('success', 'Jenis penggunaan berhasil ditambahkan');
    }

    public function jenisPenggunaanEdit($id)
    {
        $jenis = JenisPenggunaan::findOrFail($id);
        return view('admin.jenis-penggunaan.edit', compact('jenis'));
    }

    public function jenisPenggunaanUpdate(Request $request, $id)
    {
        $jenis = JenisPenggunaan::findOrFail($id);

        $validated = $request->validate([
            'nama_penggunaan' => 'required|string|max:255|unique:jenis_penggunaan,nama_penggunaan,' . $id . ',jenis_id',
            'keterangan'      => 'nullable|string',
        ]);

        $jenis->update($validated);
        return redirect()->route($this->getPrefix() . '.jenis-penggunaan.list')->with('success', 'Jenis penggunaan berhasil diperbarui');
    }

    public function jenisPenggunaanDelete($id)
    {
        $jenis = JenisPenggunaan::findOrFail($id);
        $jenis->delete();
        return redirect()->route($this->getPrefix() . '.jenis-penggunaan.list')->with('success', 'Jenis penggunaan berhasil dihapus');
    }

    public function jenisPenggunaanDetail($id)
    {
        $jenis = JenisPenggunaan::with('persil.pemilik')->findOrFail($id);
        return view('admin.jenis-penggunaan.detail', compact('jenis'));
    }

    // ========================================
    // USER MANAGEMENT (Full CRUD)
    // ========================================
    public function userList()
    {
        $search = request('search');
        $role   = request('role');
        $users  = User::query();

        if ($search) {
            $users->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('email', 'LIKE', '%' . $search . '%');
            });
        }

        if ($role) {
            $users->where('role', $role);
        }

        // Sort by role: super_admin first, then admin, then warga (A-Z)
        $users = $users->orderByRaw("FIELD(role, 'super_admin', 'admin', 'warga', 'user') ASC")
            ->orderBy('name', 'asc')
            ->paginate(15)
            ->appends(request()->query());

        return view('admin.user.index', compact('users', 'search', 'role'));
    }

    public function userEdit($id)
    {
        $user = User::findOrFail($id);

        // OLD: tidak ada proteksi
        // NEW: Admin tidak bisa edit super_admin
        if ($user->role === 'super_admin' && auth()->user()->role !== 'super_admin') {
            return redirect()->route($this->getPrefix() . '.user.list')
                ->with('error', 'Admin tidak memiliki akses untuk mengedit Super Admin');
        }

        return view('admin.user.edit', compact('user'));
    }

    public function userUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // OLD: tidak ada proteksi
        // NEW: Admin tidak bisa update super_admin
        if ($user->role === 'super_admin' && auth()->user()->role !== 'super_admin') {
            return redirect()->route($this->getPrefix() . '.user.list')
                ->with('error', 'Admin tidak memiliki akses untuk mengubah data Super Admin');
        }

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6|confirmed',
            'role'     => 'required|in:admin,user,super_admin',
        ]);

        if ($validated['password']) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);
        return redirect()->route($this->getPrefix() . '.user.list')->with('success', 'Data user berhasil diperbarui');
    }

    public function userDelete($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri');
        }

        if ($user->role === 'super_admin' && auth()->user()->role !== 'super_admin') {
            return back()->with('error', 'Tidak dapat menghapus Super Admin');
        }

        $user->delete();
        return redirect()->route($this->getPrefix() . '.user.list')->with('success', 'User berhasil dihapus');
    }

    /**
     * Get or create warga for a user (for Tambah Data feature)
     * This creates a warga record with the same email as the user if it doesn't exist
     */
    public function getOrCreateWargaForUser(Request $request)
    {
        try {
            // Log incoming request for debugging
            \Log::info('getOrCreateWargaForUser called', [
                'user_id'   => $request->user_id,
                'all_input' => $request->all(),
            ]);

            $request->validate([
                'user_id' => 'required|exists:users,id',
            ]);

            $user = User::findOrFail($request->user_id);

            \Log::info('User found', ['user_id' => $user->id, 'email' => $user->email]);

            // Check if warga with same email exists
            $warga = Warga::where('email', $user->email)->first();

            if (! $warga) {
                // Generate unique no_ktp (16 digits) based on timestamp + random
                $noKtp = date('ymdHis') . sprintf('%04d', rand(0, 9999));

                // Ensure no_ktp is unique
                while (Warga::where('no_ktp', $noKtp)->exists()) {
                    $noKtp = date('ymdHis') . sprintf('%04d', rand(0, 9999));
                }

                // Create new warga with user's data
                // Fill all required fields with default values
                $warga = Warga::create([
                    'no_ktp'        => $noKtp,
                    'nama'          => $user->name,
                    'jenis_kelamin' => 'L',          // Default to 'L', can be updated later
                    'agama'         => 'Islam',      // Default, can be updated later
                    'pekerjaan'     => 'Wiraswasta', // Default, can be updated later
                    'telp'          => null,
                    'email'         => $user->email,
                ]);

                \Log::info('Warga created', ['warga_id' => $warga->warga_id]);
            } else {
                \Log::info('Warga already exists', ['warga_id' => $warga->warga_id]);
            }

            return response()->json([
                'success'     => true,
                'warga_id'    => $warga->warga_id,
                'warga_name'  => $warga->nama,
                'warga_email' => $warga->email,
                'is_new'      => $warga->wasRecentlyCreated,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error', ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal: ' . implode(', ', array_merge(...array_values($e->errors()))),
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error creating warga', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat data warga: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get persil list for a specific warga (AJAX)
     */
    public function getPersilByWarga(Request $request)
    {
        $wargaId = $request->warga_id;

        $persils = Persil::where('pemilik_warga_id', $wargaId)
            ->select('persil_id', 'kode_persil', 'alamat_lahan')
            ->get();

        return response()->json([
            'success' => true,
            'persils' => $persils,
        ]);
    }
}
