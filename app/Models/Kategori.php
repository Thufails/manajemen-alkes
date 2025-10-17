<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';
    protected $fillable = [
    'kode', 'nama'
    ];


    public function masterItems()
    {
        return $this->hasMany(\App\Models\MasterItem::class, 'kategori_id', 'id');
    }
}
