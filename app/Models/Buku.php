<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\KategoriBukuRelasi;

class Buku extends Model
{
   use HasFactory, SoftDeletes;

    protected $table = 'buku';

    protected $fillable = [
        'judul',
        'foto_sampul',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'stok',
        'status'
    ];
    public function getFotoUrlAttribute()
    {
        if ($this->foto_sampul) {
            return asset('storage/' . $this->foto_sampul);
        }

        return asset('images/no-cover.jpg'); 
    }

    public function kategori()
    {
        
        return $this->belongsToMany(KategoriBuku::class, 'kategori_buku_relasi', 'buku_id', 'kategori_id');
    }

    public function kategoriRelasi()
    {
        return $this->belongsToMany(KategoriBuku::class, 'kategori_buku_relasi', 'buku_id', 'kategori_id');
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }

    public function ulasan()
    {
        return $this->hasMany(UlasanBuku::class);
    }
}
