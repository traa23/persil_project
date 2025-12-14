<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }
    //fuction login dimana jika berhasil login akan diarahkan sesuai role masing-masing
    public function login(Request $request)
    {
        \Log::info('Login attempt', [
            'email'          => $request->input('email'),
            'session_id'     => session()->getId(),
            'has_csrf_token' => $request->has('_token'),
        ]);

        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            \Log::info('Login successful', [
                'user_id'        => Auth::id(),
                'role'           => Auth::user()->role,
                'new_session_id' => session()->getId(),
            ]);

            // Redirect berdasarkan role
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('guest.persil.index');
        }

        \Log::warning('Login failed', [
            'email' => $request->input('email'),
        ]);

        return back()->withErrors([
            'email' => 'Email atau password tidak sesuai.',
        ])->onlyInput('email');
    }
    // fuction logout dimana jika logout akan kembali ke halaman login
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
    //mengarahkan ke halaman login setelah logout
        return redirect()->route('login');
    }
}
