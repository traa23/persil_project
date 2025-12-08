<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    /* Kalau user sudah login, Logikanya → “Eh kamu udah login, jangan balik ke login lagi, sana masuk ke dashboardmu!”
    Kalau belum login → diperbolehkan masuk ke halaman login/register.*/
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Redirect authenticated user based on role
                $user = Auth::user();
                if ($user->role === 'admin') {
                    return redirect()->route('admin.dashboard');
                } else {
                    return redirect()->route('guest.persil.index');
                }
            }
        }

        return $next($request);
    }
}
