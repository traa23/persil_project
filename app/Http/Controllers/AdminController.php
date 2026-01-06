<?php
namespace App\Http\Controllers;

use App\Models\FotoPersil;
use App\Models\Persil;
use App\Models\User;
use App\Models\Warga;
use App\Services\AdminInheritanceService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
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
        $wargaList = Warga::orderBy('nama')->get();

        return view('admin.persil.create', compact('wargaList'));
    }

    public function persilStore(Request $request)
    {
        $validated = $request->validate([
            'kode_persil'      => 'required|unique:persil',
            'pemilik_warga_id' => 'required|exists:warga,warga_id',
            'luas_m2'          => 'required|numeric',
            'penggunaan'       => 'required|string',
            'alamat_lahan'     => 'required',
            'rt'               => 'nullable|string|max:3',
            'rw'               => 'nullable|string|max:3',
            'foto_persil'      => 'nullable|array',
            'foto_persil.*'    => 'image|max:2048',
        ]);

        // Siapkan data untuk disimpan
        $persilData = [
            'kode_persil'      => $validated['kode_persil'],
            'pemilik_warga_id' => $validated['pemilik_warga_id'],
            'luas_m2'          => $validated['luas_m2'],
            'penggunaan'       => $validated['penggunaan'],
            'alamat_lahan'     => $validated['alamat_lahan'],
            'rt'               => $validated['rt'],
            'rw'               => $validated['rw'],
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

        return redirect()->route('admin.persil.list')->with('success', 'Data persil berhasil ditambahkan');
    }

    public function persilEdit($id)
    {
        $persil    = Persil::findOrFail($id);
        $wargaList = Warga::orderBy('nama')->get();

        return view('admin.persil.edit', compact('persil', 'wargaList'));
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

        return redirect()->route('admin.persil.list')->with('success', 'Data persil berhasil diperbarui');
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

        return redirect()->route('admin.persil.list')->with('success', 'Data persil berhasil dihapus');
    }

    // Delete single photo
    public function fotoPersílDelete($id)
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

        return redirect()->route('admin.warga.list')->with('success', 'Data warga berhasil ditambahkan');
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

        return redirect()->route('admin.warga.list')->with('success', 'Data warga berhasil diperbarui');
    }

    public function wargaDelete($id)
    {
        $warga = Warga::findOrFail($id);
        $warga->delete();

        return redirect()->route('admin.warga.list')->with('success', 'Data warga berhasil dihapus');
    }

    // User Management (Create admin/user only - no guest)
    public function userCreate()
    {
        return view('admin.user.create');
    }

    public function userStore(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role'     => 'required|in:admin,user',
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
}
