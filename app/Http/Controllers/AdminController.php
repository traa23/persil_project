<?php
namespace App\Http\Controllers;

use App\Models\FotoPersil;
use App\Models\JenisPenggunaan;
use App\Models\Persil;
use App\Models\User;
use App\Services\AdminInheritanceService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalPersil  = Persil::count();
        $totalGuest   = User::where('role', 'guest')->where('admin_id', auth()->id())->count();
        $recentPersil = Persil::where('pemilik_warga_id', auth()->id())
            ->orWhereHas('pemilik', function ($q) {
                $q->where('admin_id', auth()->id());
            })
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('totalPersil', 'totalGuest', 'recentPersil'));
    }

    // Persil Management
    public function persilList()
    {
        $search = request('search');

        $persils = Persil::with('pemilik', 'jenisPenggunaan');

        // Apply search filter
        if ($search) {
            $persils->where(function ($query) use ($search) {
                $query->where('kode_persil', 'LIKE', '%' . $search . '%')
                    ->orWhere('alamat_lahan', 'LIKE', '%' . $search . '%')
                    ->orWhereHas('pemilik', function ($q) use ($search) {
                        $q->where('name', 'LIKE', '%' . $search . '%');
                    })
                    ->orWhereHas('jenisPenggunaan', function ($q) use ($search) {
                        $q->where('nama_penggunaan', 'LIKE', '%' . $search . '%');
                    });
            });
        }

        $persils = $persils->paginate(15)->appends(request()->query());

        return view('admin.persil.index', compact('persils', 'search'));
    }

    public function persilDetail($id)
    {
        $persil = Persil::with('pemilik', 'jenisPenggunaan', 'dokumenPersil', 'petaPersil', 'sengketa', 'fotoPersil')
            ->findOrFail($id);

        return view('admin.persil.detail', compact('persil'));
    }

    public function persilCreate()
    {
        $jenisPenggunaan = JenisPenggunaan::all();
        $guests          = User::where('role', 'guest')->get();

        return view('admin.persil.create', compact('jenisPenggunaan', 'guests'));
    }

    public function persilStore(Request $request)
    {
        $validated = $request->validate([
            'kode_persil'             => 'required|unique:persil',
            'pemilik_warga_id'        => 'required|exists:users,id',
            'luas_m2'                 => 'required|numeric',
            'jenis_penggunaan_custom' => 'required|string',
            'alamat_lahan'            => 'required',
            'rt'                      => 'nullable|integer',
            'rw'                      => 'nullable|integer',
            'foto_persil'             => 'nullable|array',
            'foto_persil.*'           => 'image|max:2048',
        ]);

        // Handle jenis penggunaan - cari atau buat baru
        $jenisPenggunaan = JenisPenggunaan::where('nama_penggunaan', $validated['jenis_penggunaan_custom'])->first();

        if (! $jenisPenggunaan) {
            // Jika tidak ada, buat yang baru
            $jenisPenggunaan = JenisPenggunaan::create([
                'nama_penggunaan' => $validated['jenis_penggunaan_custom'],
            ]);
        }

        // Siapkan data untuk disimpan
        $persilData = [
            'kode_persil'      => $validated['kode_persil'],
            'pemilik_warga_id' => $validated['pemilik_warga_id'],
            'luas_m2'          => $validated['luas_m2'],
            'jenis_id'         => $jenisPenggunaan->jenis_id,
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
        $persil          = Persil::findOrFail($id);
        $jenisPenggunaan = JenisPenggunaan::all();
        $guests          = User::where('role', 'guest')->get();

        return view('admin.persil.edit', compact('persil', 'jenisPenggunaan', 'guests'));
    }

    public function persilUpdate(Request $request, $id)
    {
        $persil = Persil::findOrFail($id);

        $validated = $request->validate([
            'kode_persil'             => 'required|unique:persil,kode_persil,' . $id . ',persil_id',
            'pemilik_warga_id'        => 'required|exists:users,id',
            'luas_m2'                 => 'required|numeric',
            'jenis_penggunaan_custom' => 'required|string',
            'alamat_lahan'            => 'required',
            'rt'                      => 'nullable|integer',
            'rw'                      => 'nullable|integer',
            'foto_persil'             => 'nullable|array',
            'foto_persil.*'           => 'image|max:2048',
        ]);

        // Handle jenis penggunaan - cari atau buat baru
        $jenisPenggunaan = JenisPenggunaan::where('nama_penggunaan', $validated['jenis_penggunaan_custom'])->first();

        if (! $jenisPenggunaan) {
            // Jika tidak ada, buat yang baru
            $jenisPenggunaan = JenisPenggunaan::create([
                'nama_penggunaan' => $validated['jenis_penggunaan_custom'],
            ]);
        }

        // Siapkan data untuk diupdate
        $persilData = [
            'kode_persil'      => $validated['kode_persil'],
            'pemilik_warga_id' => $validated['pemilik_warga_id'],
            'luas_m2'          => $validated['luas_m2'],
            'jenis_id'         => $jenisPenggunaan->jenis_id,
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

    // User Guest Management
    public function guestList()
    {
        $search = request('search');

        $guests = User::where('role', 'guest');

        // Apply search filter
        if ($search) {
            $guests->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('email', 'LIKE', '%' . $search . '%');
            });
        }

        $guests = $guests->paginate(15)->appends(request()->query());

        return view('admin.guest.index', compact('guests', 'search'));
    }

    public function guestCreate()
    {
        return view('admin.guest.create');
    }

    public function guestStore(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $validated['role']     = 'guest';
        $validated['admin_id'] = auth()->id();

        User::create($validated);

        return redirect()->route('admin.guest.list')->with('success', 'Akun guest berhasil dibuat');
    }

    public function guestEdit($id)
    {
        $guest = User::findOrFail($id);

        return view('admin.guest.edit', compact('guest'));
    }

    public function guestUpdate(Request $request, $id)
    {
        $guest = User::findOrFail($id);

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email,' . $guest->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = bcrypt($validated['password']);
        }

        $guest->update($validated);

        return redirect()->route('admin.guest.list')->with('success', 'Data guest berhasil diperbarui');
    }

    public function guestDelete($id)
    {
        $guest = User::findOrFail($id);
        $guest->delete();

        return redirect()->route('admin.guest.list')->with('success', 'Akun guest berhasil dihapus');
    }

    // User Management (Create any user with role selection)
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
            'role'     => 'required|in:admin,guest',
        ]);

        $validated['password'] = bcrypt($validated['password']);

        // Jika role guest, tambah admin_id dari current admin
        if ($validated['role'] === 'guest') {
            $validated['admin_id'] = auth()->id();
        } elseif ($validated['role'] === 'admin') {
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

        $roleLabel = $validated['role'] === 'admin' ? 'Admin' : 'Guest';
        return back()->with('success', 'Akun ' . $roleLabel . ' berhasil dibuat');
    }
}
