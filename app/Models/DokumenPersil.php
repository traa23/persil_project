<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenPersil extends Model
{
    use HasFactory;

    protected $table      = 'dokumen_persil';
    protected $primaryKey = 'dokumen_id';
    protected $fillable   = [
        'persil_id',
        'jenis_dokumen',
        'nomor',
        'keterangan',
    ];

    public function persil()
    {
        return $this->belongsTo(Persil::class, 'persil_id', 'persil_id');
    }

    /**
     * Media files for this dokumen
     */
    public function media()
    {
        return $this->hasMany(Media::class, 'ref_id', 'dokumen_id')
            ->where('ref_table', 'dokumen_persil')
            ->orderBy('sort_order');
    }
}
