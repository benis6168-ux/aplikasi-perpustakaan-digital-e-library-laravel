<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UlasanBuku extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ulasan_buku';

    protected $fillable = [
        'user_id',
        'buku_id',
        'ulasan',
        'rating'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }
}