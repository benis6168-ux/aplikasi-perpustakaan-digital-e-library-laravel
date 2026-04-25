<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriBukuRelasi;

class KategoriBukuRelasiSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['buku_id' => 1, 'kategori_id' => 1],
            ['buku_id' => 1, 'kategori_id' => 4],
            ['buku_id' => 2, 'kategori_id' => 2],
            ['buku_id' => 3, 'kategori_id' => 1],
        ];

        KategoriBukuRelasi::insert($data);
    }
}