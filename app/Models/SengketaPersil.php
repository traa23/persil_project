<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SengketaPersil extends Model
{
    protected $table = 'sengketa_persil';
    protected $primaryKey = 'sengketa_id';

    protected $fillable = [
        'persil_id',
        'tanggal_sengketa',
        'pihak_terlibat',
        'deskripsi',
        'status',
        'penyelesaian',
    ];

    protected $casts = [
        'tanggal_sengketa' => 'date',
    ];

    public function persil(): BelongsTo
    {
        return $this->belongsTo(Persil::class, 'persil_id', 'persil_id');
    }
}
