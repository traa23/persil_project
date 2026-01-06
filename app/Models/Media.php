<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table      = 'media';
    protected $primaryKey = 'media_id';

    protected $fillable = [
        'ref_table',
        'ref_id',
        'file_url',
        'caption',
        'mime_type',
        'sort_order',
    ];

    /**
     * Get the parent model (polymorphic)
     */
    public function getParent()
    {
        return match ($this->ref_table) {
            'persil'          => Persil::find($this->ref_id),
            'dokumen_persil'  => DokumenPersil::find($this->ref_id),
            'peta_persil'     => PetaPersil::find($this->ref_id),
            'sengketa_persil' => SengketaPersil::find($this->ref_id),
            default           => null,
        };
    }

    /**
     * Scope untuk filter by ref_table
     */
    public function scopeForTable($query, string $table)
    {
        return $query->where('ref_table', $table);
    }

    /**
     * Scope untuk filter by ref_id
     */
    public function scopeForRecord($query, string $table, int $id)
    {
        return $query->where('ref_table', $table)->where('ref_id', $id);
    }
}
