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
        'bukti_sengketa',
    ];

    public function persil()
    {
        return $this->belongsTo(Persil::class, 'persil_id', 'persil_id');
    }
}
