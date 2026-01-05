<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FotoPersil extends Model
{
    protected $table    = 'foto_persil';
    protected $fillable = ['persil_id', 'file_path', 'original_name', 'file_size'];

    public function persil()
    {
        return $this->belongsTo(Persil::class);
    }
}
