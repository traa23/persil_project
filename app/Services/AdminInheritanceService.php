<?php
namespace App\Services;

use App\Models\FotoPersil;
use App\Models\Persil;
use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * Service untuk handle admin data inheritance
 * Ketika admin baru dibuat, inherit data dari parent admin
 *
 * Lokasi: app/Services/AdminInheritanceService.php
 */
class AdminInheritanceService
{
    /**
     * Copy semua data dari parent admin ke admin baru
     * Termasuk: Data Persil, Photo Persil, dan Guest User
     */
    public function inheritDataFromParentAdmin(User $newAdmin, User $parentAdmin): void
    {
        DB::transaction(function () use ($newAdmin, $parentAdmin) {
            // 1. Copy semua Persil dari parent admin
            $this->copyPersilData($newAdmin, $parentAdmin);

            // 2. Copy semua Guest User dari parent admin
            $this->copyGuestUsers($newAdmin, $parentAdmin);
        });
    }

    /**
     * Copy data Persil dari parent admin ke admin baru
     */
    private function copyPersilData(User $newAdmin, User $parentAdmin): void
    {
        // Dapatkan ID semua guest user milik parent admin
        $guestIds = User::where('role', 'guest')
            ->where('admin_id', $parentAdmin->id)
            ->pluck('id')
            ->toArray();

        // Dapatkan semua persil yang bisa diakses parent admin:
        // 1. Persil milik parent admin sendiri
        // 2. Persil milik guest user dari parent admin
        $parentPersils = Persil::with('pemilik', 'jenisPenggunaan', 'dokumenPersil', 'petaPersil', 'sengketa', 'fotoPersil')
            ->where(function ($query) use ($parentAdmin, $guestIds) {
                $query->where('pemilik_warga_id', $parentAdmin->id)
                    ->orWhereIn('pemilik_warga_id', $guestIds);
            })
            ->get();

        foreach ($parentPersils as $persil) {
            // Tentukan pemilik baru
            // Jika persil milik guest user, cari guest user baru yang sesuai
            $newOwner = $newAdmin->id;

            if ($guestIds && in_array($persil->pemilik_warga_id, $guestIds)) {
                // Cari guest user baru dengan nama yang sama
                $oldGuest = User::find($persil->pemilik_warga_id);
                $newGuest = User::where('role', 'guest')
                    ->where('admin_id', $newAdmin->id)
                    ->where('name', $oldGuest->name)
                    ->first();

                if ($newGuest) {
                    $newOwner = $newGuest->id;
                }
            }

            // Create persil baru untuk admin baru
            $newPersil = Persil::create([
                'kode_persil'      => $persil->kode_persil . '_' . $newAdmin->id, // Tambah ID admin untuk unikeness
                'pemilik_warga_id' => $newOwner,
                'luas_m2'          => $persil->luas_m2,
                'jenis_id'         => $persil->jenis_id,
                'alamat_lahan'     => $persil->alamat_lahan,
                'rt'               => $persil->rt,
                'rw'               => $persil->rw,
            ]);

            // Copy foto-foto dari persil lama ke persil baru
            $this->copyFotoPersil($persil, $newPersil);

            // Copy dokumen persil jika ada
            $this->copyDokumenPersil($persil, $newPersil);

            // Copy peta persil jika ada
            $this->copyPetaPersil($persil, $newPersil);

            // Copy sengketa persil jika ada
            $this->copySengketaPersil($persil, $newPersil);
        }
    }

    /**
     * Copy foto persil dari persil lama ke persil baru
     */
    private function copyFotoPersil(Persil $oldPersil, Persil $newPersil): void
    {
        $fotos = FotoPersil::where('persil_id', $oldPersil->persil_id)->get();

        foreach ($fotos as $foto) {
            FotoPersil::create([
                'persil_id'     => $newPersil->persil_id,
                'file_path'     => $foto->file_path,
                'original_name' => $foto->original_name,
                'file_size'     => $foto->file_size,
            ]);
        }
    }

    /**
     * Copy dokumen persil jika ada relasi
     */
    private function copyDokumenPersil(Persil $oldPersil, Persil $newPersil): void
    {
        if (! class_exists('App\Models\DokumenPersil')) {
            return;
        }

        $dokumens = $oldPersil->dokumenPersil()->get();

        foreach ($dokumens as $dokumen) {
            $newDokumen            = $dokumen->replicate();
            $newDokumen->persil_id = $newPersil->persil_id;
            $newDokumen->save();
        }
    }

    /**
     * Copy peta persil jika ada relasi
     */
    private function copyPetaPersil(Persil $oldPersil, Persil $newPersil): void
    {
        if (! class_exists('App\Models\PetaPersil')) {
            return;
        }

        $petas = $oldPersil->petaPersil()->get();

        foreach ($petas as $peta) {
            $newPeta            = $peta->replicate();
            $newPeta->persil_id = $newPersil->persil_id;
            $newPeta->save();
        }
    }

    /**
     * Copy sengketa persil jika ada relasi
     */
    private function copySengketaPersil(Persil $oldPersil, Persil $newPersil): void
    {
        if (! class_exists('App\Models\SengketaPersil')) {
            return;
        }

        $sengketas = $oldPersil->sengketa()->get();

        foreach ($sengketas as $sengketa) {
            $newSengketa            = $sengketa->replicate();
            $newSengketa->persil_id = $newPersil->persil_id;
            $newSengketa->save();
        }
    }

    /**
     * Copy semua Guest User dari parent admin ke admin baru
     */
    private function copyGuestUsers(User $newAdmin, User $parentAdmin): void
    {
        // Dapatkan semua guest user milik parent admin
        $guestUsers = User::where('role', 'guest')
            ->where('admin_id', $parentAdmin->id)
            ->get();

        foreach ($guestUsers as $guest) {
            // Create guest user baru untuk admin baru
            User::create([
                'name'            => $guest->name,
                'email'           => $guest->email . '_' . $newAdmin->id, // Tambah ID untuk unikeness
                'password'        => $guest->password,
                'role'            => 'guest',
                'admin_id'        => $newAdmin->id,
                'parent_admin_id' => null, // Guest tidak punya parent_admin_id
            ]);
        }
    }
}
