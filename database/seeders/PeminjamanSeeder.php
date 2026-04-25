<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Peminjaman;

class PeminjamanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'user_id' => 2,
                'buku_id' => 1,
                'tanggal_peminjaman' => now()->subDays(3),
                'tanggal_kembali_seharusnya' => now()->addDays(4),
                'tanggal_pengembalian' => null,
                'denda' => 0,
                'status_peminjaman' => 'dipinjam',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Peminjaman::insert($data);
    }
}