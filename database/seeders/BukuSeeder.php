<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Buku;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'judul' => 'Belajar Laravel 12',
                'penulis' => 'Achmad Beni',
                'penerbit' => 'Tech Publisher',
                'tahun_terbit' => 2025,
                'stok' => 10,
                'status' => 'tersedia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Laskar Pelangi',
                'penulis' => 'Andrea Hirata',
                'penerbit' => 'Bentang',
                'tahun_terbit' => 2005,
                'stok' => 5,
                'status' => 'tersedia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Algoritma Dasar',
                'penulis' => 'John Doe',
                'penerbit' => 'Edu Press',
                'tahun_terbit' => 2022,
                'stok' => 7,
                'status' => 'tersedia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Buku::insert($data);
    }
}