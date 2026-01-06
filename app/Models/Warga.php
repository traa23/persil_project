<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warga extends Model
{
    use HasFactory;

    protected $table      = 'warga';
    protected $primaryKey = 'warga_id';
    protected $fillable   = [
        'no_ktp',
        'nama',
        'jenis_kelamin',
        'agama',
        'pekerjaan',
        'telp',
        'email',
    ];

    /**
     * Relasi dengan Persil melalui pemilik_warga_id
     */
    public function persil()
    {
        return $this->hasMany(Persil::class, 'pemilik_warga_id', 'warga_id');
    }
}
