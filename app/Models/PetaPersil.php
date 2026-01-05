<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetaPersil extends Model
{
    use HasFactory;

    protected $table      = 'peta_persil';
    protected $primaryKey = 'peta_id';
    protected $fillable   = [
        'persil_id',
        'geojson',
        'panjang_m',
        'lebar_m',
        'file_peta',
    ];

    public function persil()
    {
        return $this->belongsTo(Persil::class, 'persil_id', 'persil_id');
    }
}
