<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPenggunaan extends Model
{
    use HasFactory;

    protected $table      = 'jenis_penggunaan';
    protected $primaryKey = 'jenis_id';
    protected $fillable   = [
        'nama_penggunaan',
        'keterangan',
    ];

    public function persil()
    {
        return $this->hasMany(Persil::class, 'jenis_id', 'jenis_id');
    }
}
