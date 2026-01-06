<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DebugController extends Controller
{
    public function database()
    {
        // Database Connection Info
        $connectionName = config('database.default');
        $connection     = [
            'driver' => config("database.connections.{$connectionName}.driver"),
            'host' => config("database.connections.{$connectionName}.host"),
            'database' => config("database.connections.{$connectionName}.database"),
        ];

        // Table Counts
        $tables       = ['users', 'warga', 'persil', 'dokumen_persil', 'peta_persil', 'sengketa_persil', 'media', 'jenis_penggunaan'];
        $tableCounts  = [];
        $totalRecords = 0;

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                $count               = DB::table($table)->count();
                $tableCounts[$table] = $count;
                $totalRecords += $count;
            } else {
                $tableCounts[$table] = 0;
            }
        }

        // Users by Role
        $usersByRole = DB::table('users')
            ->select('role', DB::raw('count(*) as total'))
            ->groupBy('role')
            ->get();

        // Sample Credentials
        $superAdmin = DB::table('users')->where('role', 'super_admin')->first();
        $admin      = DB::table('users')->where('role', 'admin')->first();
        $user       = DB::table('users')->where('role', 'user')->first();

        // Persil Statistics
        $persilByPenggunaan = DB::table('persil')
            ->select('penggunaan', DB::raw('count(*) as total'), DB::raw('SUM(luas_m2) as total_luas'))
            ->groupBy('penggunaan')
            ->orderBy('penggunaan')
            ->get();

        // Sengketa Statistics
        $sengketaByStatus = DB::table('sengketa_persil')
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        // Media Statistics
        $mediaByRef = DB::table('media')
            ->select('ref_table', DB::raw('count(*) as total'))
            ->groupBy('ref_table')
            ->get();

        // Warga Statistics
        $wargaByGender = DB::table('warga')
            ->select('jenis_kelamin', DB::raw('count(*) as total'))
            ->groupBy('jenis_kelamin')
            ->get();

        $wargaByAgama = DB::table('warga')
            ->select('agama', DB::raw('count(*) as total'))
            ->groupBy('agama')
            ->orderByDesc('total')
            ->get();

        // Sample Data
        $samplePersil = DB::table('persil')
            ->join('warga', 'persil.pemilik_warga_id', '=', 'warga.warga_id')
            ->select('persil.kode_persil', 'warga.nama as pemilik', 'persil.penggunaan', 'persil.luas_m2', 'persil.alamat_lahan')
            ->limit(5)
            ->get();

        $sampleWarga = DB::table('warga')->limit(5)->get();

        $sampleSengketa = DB::table('sengketa_persil')
            ->join('persil', 'sengketa_persil.persil_id', '=', 'persil.persil_id')
            ->select('persil.kode_persil', 'sengketa_persil.pihak_1', 'sengketa_persil.pihak_2', 'sengketa_persil.status')
            ->limit(5)
            ->get();

        // Foreign Key Integrity Check
        $integrityChecks = [
            [
                'relation'    => 'persil → warga',
                'description' => 'persil.pemilik_warga_id references warga.warga_id',
                'status'      => DB::table('persil')
                    ->leftJoin('warga', 'persil.pemilik_warga_id', '=', 'warga.warga_id')
                    ->whereNull('warga.warga_id')
                    ->count() == 0,
            ],
            [
                'relation'    => 'dokumen_persil → persil',
                'description' => 'dokumen_persil.persil_id references persil.persil_id',
                'status'      => DB::table('dokumen_persil')
                    ->leftJoin('persil', 'dokumen_persil.persil_id', '=', 'persil.persil_id')
                    ->whereNull('persil.persil_id')
                    ->count() == 0,
            ],
            [
                'relation'    => 'peta_persil → persil',
                'description' => 'peta_persil.persil_id references persil.persil_id',
                'status'      => DB::table('peta_persil')
                    ->leftJoin('persil', 'peta_persil.persil_id', '=', 'persil.persil_id')
                    ->whereNull('persil.persil_id')
                    ->count() == 0,
            ],
            [
                'relation'    => 'sengketa_persil → persil',
                'description' => 'sengketa_persil.persil_id references persil.persil_id',
                'status'      => DB::table('sengketa_persil')
                    ->leftJoin('persil', 'sengketa_persil.persil_id', '=', 'persil.persil_id')
                    ->whereNull('persil.persil_id')
                    ->count() == 0,
            ],
        ];

        return view('debug.database', compact(
            'connection',
            'tableCounts',
            'totalRecords',
            'usersByRole',
            'superAdmin',
            'admin',
            'user',
            'persilByPenggunaan',
            'sengketaByStatus',
            'mediaByRef',
            'wargaByGender',
            'wargaByAgama',
            'samplePersil',
            'sampleWarga',
            'sampleSengketa',
            'integrityChecks'
        ));
    }
}
