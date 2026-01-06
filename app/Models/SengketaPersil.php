<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SengketaPersil extends Model
{
    use HasFactory;

    protected $table      = 'sengketa_persil';
    protected $primaryKey = 'sengketa_id';
    protected $fillable   = [
        'persil_id',
        'pihak_1',
        'pihak_2',
        'kronologi',
        'status',
        'penyelesaian',
    ];

    // Status enum values: pending, proses, selesai
    const STATUS_PENDING = 'pending';
    const STATUS_PROSES  = 'proses';
    const STATUS_SELESAI = 'selesai';

    public function persil()
    {
        return $this->belongsTo(Persil::class, 'persil_id', 'persil_id');
    }

    /**
     * Media files (bukti sengketa)
     */
    public function media()
    {
        return $this->hasMany(Media::class, 'ref_id', 'sengketa_id')
            ->where('ref_table', 'sengketa_persil')
            ->orderBy('sort_order');
    }
}
