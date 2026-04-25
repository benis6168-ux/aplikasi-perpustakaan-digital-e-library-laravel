<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\KategoriBukuRelasi;

class KategoriBuku extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kategori_buku';

    protected $fillable = [
        'nama_kategori'
    ];

    public function buku()
    {
        return $this->belongsToMany(Buku::class, 'kategori_buku_relasi', 'kategori_id', 'buku_id');
    }

    public function relasi()
    {
        return $this->hasMany(KategoriBukuRelasi::class, 'kategori_id');
    }
}