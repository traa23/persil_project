<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    /**
     * Display a listing of users
     */
    public function index()
    {
        try {
            $users = User::paginate(10);
            return view('admin.users.index_new', compact('users'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memuat daftar pengguna: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new user
     */
    public function create()
    {
        return view('admin.users.create_new');
    }

    /**
     * Store a newly created user in storage
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name'     => 'required|string|max:255',
                'email'    => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
                'role'     => 'required|in:admin,guest',
            ], [
                'name.required'      => 'Nama pengguna wajib diisi',
                'email.required'     => 'Email wajib diisi',
                'email.email'        => 'Email tidak valid',
                'email.unique'       => 'Email sudah terdaftar',
                'password.required'  => 'Password wajib diisi',
                'password.min'       => 'Password minimal 8 karakter',
                'password.confirmed' => 'Konfirmasi password tidak sesuai',
                'role.required'      => 'Role wajib dipilih',
                'role.in'            => 'Role tidak valid',
            ]);

            User::create([
                'name'     => $validated['name'],
                'email'    => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role'     => $validated['role'],
            ]);

            return redirect()->route('admin.users.index')
                ->with('success', 'Pengguna berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan pengguna: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified user
     */
    public function show(User $user)
    {
        try {
            return view('admin.users.show_new', compact('user'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memuat data pengguna: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified user
     */
    public function edit(User $user)
    {
        try {
            return view('admin.users.edit_new', compact('user'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memuat form edit: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified user in storage
     */
    public function update(Request $request, User $user)
    {
        try {
            $validated = $request->validate([
                'name'     => 'required|string|max:255',
                'email'    => 'required|email|unique:users,email,' . $user->id,
                'role'     => 'required|in:admin,guest',
                'password' => 'nullable|string|min:8|confirmed',
            ], [
                'name.required'      => 'Nama pengguna wajib diisi',
                'email.required'     => 'Email wajib diisi',
                'email.email'        => 'Email tidak valid',
                'email.unique'       => 'Email sudah terdaftar',
                'role.required'      => 'Role wajib dipilih',
                'role.in'            => 'Role tidak valid',
                'password.min'       => 'Password minimal 8 karakter',
                'password.confirmed' => 'Konfirmasi password tidak sesuai',
            ]);

            $user->name  = $validated['name'];
            $user->email = $validated['email'];
            $user->role  = $validated['role'];

            if ($request->filled('password')) {
                $user->password = Hash::make($validated['password']);
            }

            $user->save();

            return redirect()->route('admin.users.index')
                ->with('success', 'Pengguna berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui pengguna: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified user from storage
     */
    public function destroy(User $user)
    {
        try {
            // Prevent deleting own account
            if ($user->id === auth()->id()) {
                return redirect()->back()
                    ->with('error', 'Anda tidak bisa menghapus akun sendiri');
            }

            $user->delete();

            return redirect()->route('admin.users.index')
                ->with('success', 'Pengguna berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus pengguna: ' . $e->getMessage());
        }
    }

    /**
     * Update user role
     */
    public function updateRole(Request $request, User $user)
    {
        try {
            // Prevent changing own role to guest
            if ($user->id === auth()->id() && $request->role === 'guest') {
                return redirect()->back()
                    ->with('error', 'Anda tidak bisa mengubah role Anda menjadi guest');
            }

            $validated = $request->validate([
                'role' => 'required|in:admin,guest',
            ]);

            $user->update(['role' => $validated['role']]);

            return redirect()->back()
                ->with('success', 'Role pengguna berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui role: ' . $e->getMessage());
        }
    }
}
