<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PetaPersil extends Model
{
    protected $table = 'peta_persil';
    protected $primaryKey = 'peta_id';

    protected $fillable = [
        'persil_id',
        'koordinat_json',
        'file_peta',
        'keterangan',
    ];

    protected $casts = [
        'koordinat_json' => 'array',
    ];

    public function persil(): BelongsTo
    {
        return $this->belongsTo(Persil::class, 'persil_id', 'persil_id');
    }
}
