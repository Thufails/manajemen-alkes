<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
    'nama', 'harga_beli', 'laba', 'kode', 'supplier', 'jenis', 'kategori_id', 'foto'
    ];

    public function kategori()
    {
        return $this->belongsTo(\App\Models\Kategori::class, 'kategori_id', 'id');
    }
}
