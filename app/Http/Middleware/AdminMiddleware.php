<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    /*Middleware ini tugasnya menjaga route yang hanya boleh diakses oleh user dengan role admin.
    Jadi sebelum request masuk ke controller, middleware ini nge-cek dulu: 
    User sudah login belum?
    Role user itu admin atau bukan?*/
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        abort(403, 'Unauthorized action.');
    }
}
