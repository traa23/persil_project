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
    ];

    protected $casts = [
        'geojson' => 'json',
    ];

    public function persil()
    {
        return $this->belongsTo(Persil::class, 'persil_id', 'persil_id');
    }

    /**
     * Media files for this peta
     */
    public function media()
    {
        return $this->hasMany(Media::class, 'ref_id', 'peta_id')
            ->where('ref_table', 'peta_persil')
            ->orderBy('sort_order');
    }
}
