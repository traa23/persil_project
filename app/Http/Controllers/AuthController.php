<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = auth()->user();
            // Arahkan sesuai role
            return match ($user->role) {
                'admin'       => redirect()->intended(route('admin.dashboard')),
                'super_admin' => redirect()->intended(route('super-admin.dashboard')),
                'guest'       => redirect()->intended(route('guest.dashboard')),
                default       => redirect()->intended(route('login')), // user atau role lain
            };
        }

        return back()->withErrors([
            'email' => 'Email atau password salah',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
