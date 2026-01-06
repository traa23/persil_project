<?php
namespace App\Http\Controllers;

use App\Models\DokumenPersil;
use App\Models\Persil;
use App\Models\PetaPersil;
use App\Models\SengketaPersil;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Get warga linked to current user by email
     */
    private function getLinkedWarga()
    {
        $userEmail = Auth::user()->email;
        return Warga::where('email', $userEmail)->first();
    }

    /**
     * Get persil IDs owned by linked warga
     */
    private function getMyPersilIds()
    {
        $warga = $this->getLinkedWarga();

        if (! $warga) {
            return [];
        }

        return Persil::where('pemilik_warga_id', $warga->warga_id)
            ->pluck('persil_id')
            ->toArray();
    }

    /**
     * Dashboard - Summary of user's data
     */
    public function dashboard()
    {
        $warga     = $this->getLinkedWarga();
        $persilIds = $this->getMyPersilIds();

        $stats = [
            'totalPersil'   => count($persilIds),
            'totalDokumen'  => DokumenPersil::whereIn('persil_id', $persilIds)->count(),
            'totalPeta'     => PetaPersil::whereIn('persil_id', $persilIds)->count(),
            'totalSengketa' => SengketaPersil::whereIn('persil_id', $persilIds)->count(),
        ];

        $persils = Persil::with('pemilik')
            ->whereIn('persil_id', $persilIds)
            ->latest()
            ->take(5)
            ->get();

        return view('user.dashboard', compact('warga', 'stats', 'persils'));
    }

    /**
     * List all persil owned by user
     */
    public function persilList()
    {
        $warga     = $this->getLinkedWarga();
        $persilIds = $this->getMyPersilIds();

        $search = request('search');

        $persils = Persil::with('pemilik')
            ->whereIn('persil_id', $persilIds);

        if ($search) {
            $persils->where(function ($query) use ($search) {
                $query->where('kode_persil', 'LIKE', '%' . $search . '%')
                    ->orWhere('alamat_lahan', 'LIKE', '%' . $search . '%')
                    ->orWhere('penggunaan', 'LIKE', '%' . $search . '%');
            });
        }

        $persils = $persils->paginate(10)->appends(request()->query());

        return view('user.persil.index', compact('persils', 'warga', 'search'));
    }

    /**
     * Show persil detail
     */
    public function persilDetail($id)
    {
        $persilIds = $this->getMyPersilIds();

        // Only allow viewing own persil
        if (! in_array($id, $persilIds)) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        $persil = Persil::with('pemilik', 'dokumenPersil', 'petaPersil', 'sengketa', 'fotoPersil', 'media')
            ->findOrFail($id);

        return view('user.persil.detail', compact('persil'));
    }

    /**
     * List all dokumen for user's persil
     */
    public function dokumenList()
    {
        $warga     = $this->getLinkedWarga();
        $persilIds = $this->getMyPersilIds();

        $search = request('search');

        $dokumens = DokumenPersil::with('persil')
            ->whereIn('persil_id', $persilIds);

        if ($search) {
            $dokumens->where(function ($query) use ($search) {
                $query->where('jenis_dokumen', 'LIKE', '%' . $search . '%')
                    ->orWhere('nomor', 'LIKE', '%' . $search . '%')
                    ->orWhere('keterangan', 'LIKE', '%' . $search . '%');
            });
        }

        $dokumens = $dokumens->paginate(10)->appends(request()->query());

        return view('user.dokumen.index', compact('dokumens', 'warga', 'search'));
    }

    /**
     * Show dokumen detail
     */
    public function dokumenDetail($id)
    {
        $persilIds = $this->getMyPersilIds();

        $dokumen = DokumenPersil::with('persil')
            ->whereIn('persil_id', $persilIds)
            ->findOrFail($id);

        return view('user.dokumen.detail', compact('dokumen'));
    }

    /**
     * List all peta for user's persil
     */
    public function petaList()
    {
        $warga     = $this->getLinkedWarga();
        $persilIds = $this->getMyPersilIds();

        $petas = PetaPersil::with('persil')
            ->whereIn('persil_id', $persilIds)
            ->paginate(10);

        return view('user.peta.index', compact('petas', 'warga'));
    }

    /**
     * Show peta detail
     */
    public function petaDetail($id)
    {
        $persilIds = $this->getMyPersilIds();

        $peta = PetaPersil::with('persil')
            ->whereIn('persil_id', $persilIds)
            ->findOrFail($id);

        return view('user.peta.detail', compact('peta'));
    }

    /**
     * List all sengketa for user's persil
     */
    public function sengketaList()
    {
        $warga     = $this->getLinkedWarga();
        $persilIds = $this->getMyPersilIds();

        $search = request('search');

        $sengketas = SengketaPersil::with('persil')
            ->whereIn('persil_id', $persilIds);

        if ($search) {
            $sengketas->where(function ($query) use ($search) {
                $query->where('pihak_1', 'LIKE', '%' . $search . '%')
                    ->orWhere('pihak_2', 'LIKE', '%' . $search . '%')
                    ->orWhere('status', 'LIKE', '%' . $search . '%')
                    ->orWhere('kronologi', 'LIKE', '%' . $search . '%');
            });
        }

        $sengketas = $sengketas->paginate(10)->appends(request()->query());

        return view('user.sengketa.index', compact('sengketas', 'warga', 'search'));
    }

    /**
     * Show sengketa detail
     */
    public function sengketaDetail($id)
    {
        $persilIds = $this->getMyPersilIds();

        $sengketa = SengketaPersil::with('persil')
            ->whereIn('persil_id', $persilIds)
            ->findOrFail($id);

        return view('user.sengketa.detail', compact('sengketa'));
    }

    /**
     * Show jenis penggunaan list (read only)
     */
    public function jenisPenggunaanList()
    {
        $jenisPenggunaan = \App\Models\JenisPenggunaan::orderBy('nama_penggunaan')->get();

        return view('user.jenis-penggunaan.index', compact('jenisPenggunaan'));
    }
}
