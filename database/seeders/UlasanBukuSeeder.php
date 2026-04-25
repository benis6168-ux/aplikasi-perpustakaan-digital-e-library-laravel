<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UlasanBuku;
use App\Models\User;
use App\Models\Buku;

class UlasanBukuSeeder extends Seeder
{
    public function run(): void
    {
        // ambil data user & buku
        $users = User::where('role', 'user')->get();
        $bukus = Buku::all();

        if ($users->isEmpty() || $bukus->isEmpty()) {
            return;
        }

        $ulasanList = [
            'Buku ini sangat bagus dan mudah dipahami',
            'Ceritanya menarik dan tidak membosankan',
            'Materinya lengkap dan cocok untuk belajar',
            'Penulis sangat jelas dalam menjelaskan isi buku',
            'Sangat direkomendasikan untuk dibaca',
            'Buku ini cukup membantu tugas sekolah',
            'Bahasanya ringan dan enak dibaca',
        ];

        foreach ($bukus as $buku) {
            foreach ($users as $user) {

                UlasanBuku::create([
                    'user_id' => $user->id,
                    'buku_id' => $buku->id,
                    'ulasan' => $ulasanList[array_rand($ulasanList)],
                    'rating' => rand(3, 5),
                ]);
            }
        }
    }
}