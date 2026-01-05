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
        'file_dokumen',
    ];

    public function persil()
    {
        return $this->belongsTo(Persil::class, 'persil_id', 'persil_id');
    }
}
