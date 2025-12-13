<?php
namespace App\Http\Controllers;

use App\Models\Persil;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GuestPersilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = Persil::with('pemilik');

            // Filter hanya data milik user yang login
            if (auth()->check()) {
                $query->where('pemilik_warga_id', auth()->id());
            }

            // Handle search functionality
            if ($request->has('search') && $request->search != '') {
                $search = $request->search;

                $query->where(function ($q) use ($search) {
                    $q->where('kode_persil', 'LIKE', "%{$search}%")
                        ->orWhere('alamat_lahan', 'LIKE', "%{$search}%")
                        ->orWhere('penggunaan', 'LIKE', "%{$search}%")
                        ->orWhere('rt', 'LIKE', "%{$search}%")
                        ->orWhere('rw', 'LIKE', "%{$search}%")
                        ->orWhereHas('pemilik', function ($q) use ($search) {
                            $q->where('name', 'LIKE', "%{$search}%");
                        });
                });
            }

            $persils = $query->latest()->paginate(perPage: 3)->appends($request->query());

            return view('guest.persil.index', compact('persils'));
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat memuat data: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Guest hanya bisa membuat data dengan pemiliknya sendiri
        return view('guest.persil.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'kode_persil'     => 'required|string|max:50|unique:persil,kode_persil',
                'luas_m2'         => 'nullable|numeric|min:0',
                'penggunaan'      => 'nullable|string|max:100',
                'alamat_lahan'    => 'nullable|string',
                'rt'              => 'nullable|string|max:5',
                'rw'              => 'nullable|string|max:5',
                'files.*'         => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
                'jenis_dokumen.*' => 'nullable|string|max:100',
                'owner_photo'     => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            ], [
                'kode_persil.required' => 'Kode persil wajib diisi',
                'kode_persil.unique'   => 'Kode persil sudah terdaftar',
                'luas_m2.numeric'      => 'Luas harus berupa angka',
                'luas_m2.min'          => 'Luas tidak boleh negatif',
                'files.*.mimes'        => 'Format file harus: PDF, DOC, DOCX, JPG, JPEG, PNG',
                'files.*.max'          => 'Ukuran file maksimal 5MB',
                'owner_photo.image'    => 'File harus berupa gambar',
                'owner_photo.mimes'    => 'Format foto harus: JPG, JPEG, PNG',
                'owner_photo.max'      => 'Ukuran foto maksimal 2MB',
            ]);

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            }

            // Auto set pemilik ke user yang login
            $data = $request->only([
                'kode_persil',
                'luas_m2',
                'penggunaan',
                'alamat_lahan',
                'rt',
                'rw',
            ]);
            $data['pemilik_warga_id'] = auth()->id();

            $persil = Persil::create($data);

            // Sinkronisasi data ke admin - buat record tambahan untuk admin access
            $adminUser = User::where('role', 'admin')->first();
            if ($adminUser) {
                // Buat copy data untuk admin dengan kode yang berbeda
                $adminData                     = $data;
                $adminData['kode_persil']      = $data['kode_persil'] . '_ADMIN_SYNC';
                $adminData['pemilik_warga_id'] = $adminUser->id;

                try {
                    Persil::create($adminData);
                } catch (\Exception $e) {
                    // Jika gagal (misal kode duplikat), skip saja
                    // Data utama guest sudah tersimpan
                }
            }

            // Handle owner photo upload
            if ($request->hasFile('owner_photo')) {
                $user = auth()->user();
                if ($user) {
                    // Delete old photo if exists
                    if ($user->photo_path && \Storage::disk('public')->exists($user->photo_path)) {
                        \Storage::disk('public')->delete($user->photo_path);
                    }

                    // Upload new photo
                    $photoPath = $request->file('owner_photo')->store('users/photos', 'public');
                    $user->update(['photo_path' => $photoPath]);
                }
            }

            // Handle multiple dokumen upload
            $uploadedCount = 0;
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $index => $file) {
                    $filePath = $file->store('dokumen_persil', 'public');

                    \App\Models\DokumenPersil::create([
                        'persil_id'     => $persil->persil_id,
                        'jenis_dokumen' => $request->jenis_dokumen[$index] ?? 'Dokumen',
                        'nomor'         => $request->nomor[$index] ?? null,
                        'keterangan'    => $request->keterangan[$index] ?? null,
                        'file_path'     => $filePath,
                    ]);

                    $uploadedCount++;
                }
            }

            $message = 'Data persil berhasil ditambahkan!';
            if ($uploadedCount > 0) {
                $message .= " {$uploadedCount} dokumen berhasil diupload.";
            }

            return redirect()->route('guest.persil.show', $persil->persil_id)
                ->with('success', $message);
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $persil = Persil::with(['pemilik', 'dokumen', 'peta', 'sengketa'])->findOrFail($id);

            // Check if user owns this persil
            if ($persil->pemilik_warga_id !== auth()->id()) {
                abort(403, 'Anda tidak memiliki akses untuk melihat data ini.');
            }

            return view('guest.persil.show', compact('persil'));
        } catch (\Exception $e) {
            return back()->with('error', 'Data tidak ditemukan: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $persil = Persil::findOrFail($id);

            // Check if user owns this persil
            if ($persil->pemilik_warga_id !== auth()->id()) {
                abort(403, 'Anda tidak memiliki akses untuk edit data ini.');
            }

            return view('guest.persil.edit', compact('persil'));
        } catch (\Exception $e) {
            return back()->with('error', 'Data tidak ditemukan: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $persil = Persil::findOrFail($id);

            // Check if user owns this persil
            if ($persil->pemilik_warga_id !== auth()->id()) {
                abort(403, 'Anda tidak memiliki akses untuk update data ini.');
            }

            $validator = Validator::make($request->all(), [
                'kode_persil'  => 'required|string|max:50|unique:persil,kode_persil,' . $id . ',persil_id',
                'luas_m2'      => 'nullable|numeric|min:0',
                'penggunaan'   => 'nullable|string|max:100',
                'alamat_lahan' => 'nullable|string',
                'rt'           => 'nullable|string|max:5',
                'rw'           => 'nullable|string|max:5',
                'owner_photo'  => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            ], [
                'kode_persil.required' => 'Kode persil wajib diisi',
                'kode_persil.unique'   => 'Kode persil sudah terdaftar',
                'luas_m2.numeric'      => 'Luas harus berupa angka',
                'luas_m2.min'          => 'Luas tidak boleh negatif',
                'owner_photo.image'    => 'File harus berupa gambar',
                'owner_photo.mimes'    => 'Format foto harus: JPG, JPEG, PNG',
                'owner_photo.max'      => 'Ukuran foto maksimal 2MB',
            ]);

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $persil->update($request->only([
                'kode_persil',
                'luas_m2',
                'penggunaan',
                'alamat_lahan',
                'rt',
                'rw',
            ]));

            // Handle owner photo upload
            if ($request->hasFile('owner_photo')) {
                $user = auth()->user();
                if ($user) {
                    // Delete old photo if exists
                    if ($user->photo_path && \Storage::disk('public')->exists($user->photo_path)) {
                        \Storage::disk('public')->delete($user->photo_path);
                    }

                    // Upload new photo
                    $photoPath = $request->file('owner_photo')->store('users/photos', 'public');
                    $user->update(['photo_path' => $photoPath]);
                }
            }

            return redirect()->route('guest.persil.show', $persil->persil_id)
                ->with('success', 'Data persil berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $persil = Persil::findOrFail($id);

            // Check if user owns this persil
            if ($persil->pemilik_warga_id !== auth()->id()) {
                abort(403, 'Anda tidak memiliki akses untuk menghapus data ini.');
            }

            $persil->delete();

            return redirect()->route('guest.persil.index')
                ->with('success', 'Data persil berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}
