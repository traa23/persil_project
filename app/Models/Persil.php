<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persil extends Model
{
    use HasFactory;

    protected $table      = 'persil';
    protected $primaryKey = 'persil_id';
    protected $fillable   = [
        'kode_persil',
        'pemilik_warga_id',
        'luas_m2',
        'jenis_id',
        'alamat_lahan',
        'rt',
        'rw',
        'foto_persil',
    ];

    public function pemilik()
    {
        return $this->belongsTo(User::class, 'pemilik_warga_id');
    }

    public function jenisPenggunaan()
    {
        return $this->belongsTo(JenisPenggunaan::class, 'jenis_id', 'jenis_id');
    }

    public function dokumenPersil()
    {
        return $this->hasMany(DokumenPersil::class, 'persil_id', 'persil_id');
    }

    public function petaPersil()
    {
        return $this->hasOne(PetaPersil::class, 'persil_id', 'persil_id');
    }

    public function sengketa()
    {
        return $this->hasMany(SengketaPersil::class, 'persil_id', 'persil_id');
    }

    public function fotoPersil()
    {
        return $this->hasMany(FotoPersil::class, 'persil_id', 'persil_id');
    }

    /**
     * Get first available image for display
     * Priority: foto_persil > dokumenPersil image > petaPersil image
     */
    public function getDisplayImage()
    {
        // Priority 1: foto_persil
        if ($this->foto_persil) {
            return $this->foto_persil;
        }

        // Priority 2: First image from dokumenPersil
        if ($this->dokumenPersil && $this->dokumenPersil->count() > 0) {
            foreach ($this->dokumenPersil as $dokumen) {
                $extension = strtolower(pathinfo($dokumen->file_dokumen, PATHINFO_EXTENSION));
                if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf'])) {
                    return $dokumen->file_dokumen;
                }
            }
        }

        // Priority 3: First image from petaPersil
        if ($this->petaPersil) {
            $extension = strtolower(pathinfo($this->petaPersil->file_peta, PATHINFO_EXTENSION));
            if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf'])) {
                return $this->petaPersil->file_peta;
            }
        }

        return null;
    }
}
