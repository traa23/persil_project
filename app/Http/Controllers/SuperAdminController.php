<?php
namespace App\Http\Controllers;

use App\Models\Persil;
use App\Models\User;
use App\Models\Warga;

class SuperAdminController extends AdminController
{
    // Override dashboard to use super-admin views
    public function dashboard()
    {
        $totalPersil  = Persil::count();
        $totalUser    = User::where('role', 'user')->count();
        $totalWarga   = Warga::count();
        $recentPersil = Persil::with('pemilik')
            ->latest()
            ->take(5)
            ->get();

        return view('super-admin.dashboard', compact('totalPersil', 'totalUser', 'totalWarga', 'recentPersil'));
    }

    // All other methods will use parent AdminController methods
    // but we'll override view paths where necessary
}
