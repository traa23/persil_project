<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman profil user yang sedang login
     * Route: GET /profile
     * Middleware: auth
     */
    public function show()
    {
        // Mengambil data user yang sedang login
        $user = auth()->user();

        // Mengembalikan view profile dengan data user
        return view('guest.profile.show', compact('user'));
    }

    /**
     * Menampilkan form edit profil user
     * Route: GET /profile/edit
     * Middleware: auth
     */
    public function edit()
    {
        // Mengambil data user yang sedang login
        $user = auth()->user();

        // Mengembalikan view edit profile dengan data user
        return view('guest.profile.edit', compact('user'));
    }

    /**
     * Menyimpan perubahan data profil user
     * Route: PUT /profile
     * Middleware: auth
     */
    public function update(Request $request)
    {
        try {
            // Mengambil data user yang sedang login
            $user = auth()->user();

            // Validasi input dari form
            $validator = Validator::make($request->all(), [
                'name'             => 'required|string|max:255',
                'email'            => 'required|email|unique:users,email,' . $user->id,
                'current_password' => 'nullable|string',
                'password'         => 'nullable|string|min:8|confirmed',
                'photo'            => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ], [
                'name.required'      => 'Nama wajib diisi',
                'email.required'     => 'Email wajib diisi',
                'email.email'        => 'Format email tidak valid',
                'email.unique'       => 'Email sudah terdaftar',
                'password.min'       => 'Password minimal 8 karakter',
                'password.confirmed' => 'Konfirmasi password tidak cocok',
                'photo.image'        => 'File harus berupa gambar',
                'photo.mimes'        => 'Format gambar harus jpeg, png, jpg, atau gif',
                'photo.max'          => 'Ukuran gambar maksimal 2MB',
            ]);

            // Jika validasi gagal, kembali ke form dengan error
            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            }

            // Verifikasi password lama jika user ingin mengubah password
            if ($request->filled('password')) {
                if (! \Hash::check($request->current_password, $user->password)) {
                    return back()
                        ->withErrors(['current_password' => 'Password lama tidak sesuai'])
                        ->withInput();
                }
            }

            // Menyiapkan data yang akan diupdate
            $data = [
                'name'  => $request->name,
                'email' => $request->email,
            ];

            // Jika password baru diisi, hash dan tambahkan ke data
            if ($request->filled('password')) {
                $data['password'] = \Hash::make($request->password);
            }

            // Handle upload foto profil jika ada
            if ($request->hasFile('photo')) {
                // Hapus foto lama jika ada
                if ($user->photo_path && Storage::disk('public')->exists($user->photo_path)) {
                    Storage::disk('public')->delete($user->photo_path);
                }

                // Upload foto baru ke storage/public/users/photos
                $photo              = $request->file('photo');
                $photoPath          = $photo->store('users/photos', 'public');
                $data['photo_path'] = $photoPath;
            }

            // Update data user di database
            $user->update($data);

            // Redirect kembali ke halaman profil dengan pesan sukses
            return redirect()->route('profile.show')
                ->with('success', 'Profil berhasil diperbarui!');
        } catch (\Exception $e) {
            // Jika terjadi error, kembali ke form dengan pesan error
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus foto profil user
     * Route: DELETE /profile/photo
     * Middleware: auth
     */
    public function removePhoto()
    {
        try {
            // Mengambil data user yang sedang login
            $user = auth()->user();

            // Cek apakah user memiliki foto
            if ($user->photo_path && Storage::disk('public')->exists($user->photo_path)) {
                // Hapus file foto dari storage
                Storage::disk('public')->delete($user->photo_path);

                // Hapus path foto dari database
                $user->update(['photo_path' => null]);

                // Redirect dengan pesan sukses
                return redirect()->route('profile.edit')
                    ->with('success', 'Foto profil berhasil dihapus!');
            } else {
                // Jika tidak ada foto, redirect dengan pesan warning
                return redirect()->route('profile.edit')
                    ->with('warning', 'Tidak ada foto profil yang dapat dihapus.');
            }
        } catch (\Exception $e) {
            // Jika terjadi error, redirect dengan pesan error
            return redirect()->route('profile.edit')
                ->with('error', 'Terjadi kesalahan saat menghapus foto: ' . $e->getMessage());
        }
    }
}
