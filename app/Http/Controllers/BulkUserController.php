<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class BulkUserController extends Controller
{
    public function create()
    {
        return view('guest.users.bulk-create');
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'users' => 'required|array|min:1',
                'users.*.name' => 'required|string|max:255',
                'users.*.email' => 'required|email|unique:users,email',
                'users.*.password' => 'required|string|min:8',
                'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ], [
                'users.required' => 'Minimal harus ada 1 user',
                'users.*.name.required' => 'Nama wajib diisi untuk semua user',
                'users.*.email.required' => 'Email wajib diisi untuk semua user',
                'users.*.email.email' => 'Format email tidak valid',
                'users.*.email.unique' => 'Email sudah terdaftar',
                'users.*.password.required' => 'Password wajib diisi untuk semua user',
                'users.*.password.min' => 'Password minimal 8 karakter',
                'photos.*.image' => 'File harus berupa gambar',
                'photos.*.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
                'photos.*.max' => 'Ukuran gambar maksimal 2MB',
            ]);

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $createdCount = 0;
            $users = $request->input('users');

            foreach ($users as $index => $userData) {
                $data = [
                    'name' => $userData['name'],
                    'email' => $userData['email'],
                    'password' => Hash::make($userData['password']),
                ];

                // Handle photo upload for this user
                if ($request->hasFile("photos.{$index}")) {
                    $photo = $request->file("photos.{$index}");
                    $photoPath = $photo->store('users/photos', 'public');
                    $data['photo_path'] = $photoPath;
                }

                User::create($data);
                $createdCount++;
            }

            return redirect()->route('users.index')
                ->with('success', "{$createdCount} user berhasil ditambahkan!");
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: '.$e->getMessage());
        }
    }
}
