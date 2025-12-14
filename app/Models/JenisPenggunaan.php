<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisPenggunaan extends Model
{
    protected $table = 'jenis_penggunaan';
    protected $primaryKey = 'jenis_id';

    protected $fillable = [
        'nama_jenis',
        'deskripsi',
    ];
}
