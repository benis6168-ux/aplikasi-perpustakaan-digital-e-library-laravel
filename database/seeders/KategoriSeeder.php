<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriBuku;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama_kategori' => 'Teknologi'],
            ['nama_kategori' => 'Novel'],
            ['nama_kategori' => 'Agama'],
            ['nama_kategori' => 'Pendidikan'],
            ['nama_kategori' => 'Komik'],
        ];

        KategoriBuku::insert($data);
    }
}