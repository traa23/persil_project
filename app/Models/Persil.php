<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Persil extends Model
{
    protected $table = 'persil';
    protected $primaryKey = 'persil_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'kode_persil',
        'pemilik_warga_id',
        'luas_m2',
        'penggunaan',
        'alamat_lahan',
        'rt',
        'rw',
    ];

    protected $casts = [
        'luas_m2' => 'decimal:2',
    ];

    public function pemilik(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pemilik_warga_id');
    }

    public function dokumen(): HasMany
    {
        return $this->hasMany(DokumenPersil::class, 'persil_id', 'persil_id');
    }

    public function peta(): HasMany
    {
        return $this->hasMany(PetaPersil::class, 'persil_id', 'persil_id');
    }

    public function sengketa(): HasMany
    {
        return $this->hasMany(SengketaPersil::class, 'persil_id', 'persil_id');
    }
}
