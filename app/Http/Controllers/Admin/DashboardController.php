<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Persil;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard
     */
    public function index()
    {
        try {
            $stats = [
                'total_users' => User::count(),
                'total_admins' => User::where('role', 'admin')->count(),
                'total_guests' => User::where('role', 'guest')->count(),
                'total_persil' => Persil::count(),
            ];

            $recent_users = User::latest()->take(5)->get();
            $recent_persil = Persil::latest()->take(5)->get();

            return view('admin.dashboard_new', compact('stats', 'recent_users', 'recent_persil'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memuat dashboard: '.$e->getMessage());
        }
    }
}
