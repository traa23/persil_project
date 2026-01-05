<?php
namespace App\Http\Controllers;

use App\Models\Persil;

class GuestController extends Controller
{
    public function dashboard()
    {
        $persils = Persil::where('pemilik_warga_id', auth()->id())
            ->with('jenisPenggunaan', 'pemilik', 'dokumenPersil', 'petaPersil')
            ->paginate(10);

        return view('guest.dashboard', compact('persils'));
    }

    public function persilDetail($id)
    {
        $persil = Persil::where('pemilik_warga_id', auth()->id())
            ->with('jenisPenggunaan', 'dokumenPersil', 'petaPersil', 'sengketa', 'fotoPersil')
            ->findOrFail($id);

        return view('guest.persil-detail', compact('persil'));
    }
}
