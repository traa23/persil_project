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
        'penggunaan', // Changed from jenis_id to varchar penggunaan
        'alamat_lahan',
        'rt',
        'rw',
    ];

    /**
     * Relasi ke Warga (pemilik)
     */
    public function pemilik()
    {
        return $this->belongsTo(Warga::class, 'pemilik_warga_id', 'warga_id');
    }

    /**
     * Relasi ke JenisPenggunaan (optional, untuk backward compatibility)
     * Sekarang penggunaan disimpan sebagai varchar
     */
    public function jenisPenggunaan()
    {
        return $this->belongsTo(JenisPenggunaan::class, 'penggunaan', 'nama_penggunaan');
    }

    /**
     * Media files (universal media storage)
     */
    public function media()
    {
        return $this->hasMany(Media::class, 'ref_id', 'persil_id')
            ->where('ref_table', 'persil')
            ->orderBy('sort_order');
    }

    public function dokumenPersil()
    {
        return $this->hasMany(DokumenPersil::class, 'persil_id', 'persil_id');
    }

    public function petaPersil()
    {
        return $this->hasMany(PetaPersil::class, 'persil_id', 'persil_id');
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
     * Get first available image for display from media table
     */
    public function getDisplayImage()
    {
        // Priority 1: From media table
        $media = $this->media()->first();
        if ($media) {
            return $media->file_url;
        }

        // Priority 2: From dokumen media
        foreach ($this->dokumenPersil as $dokumen) {
            $mediaDoc = $dokumen->media()->first();
            if ($mediaDoc) {
                return $mediaDoc->file_url;
            }
        }

        // Priority 3: From peta media
        $petaPersil = $this->petaPersil()->first();
        if ($petaPersil) {
            $mediaPeta = $petaPersil->media()->first();
            if ($mediaPeta) {
                return $mediaPeta->file_url;
            }
        }

        return null;
    }
}
