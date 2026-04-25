<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('buku_id')
                ->constrained('buku')
                ->cascadeOnDelete();

            $table->date('tanggal_peminjaman');
            $table->date('tanggal_kembali_seharusnya');
            $table->date('tanggal_pengembalian')->nullable();
            $table->integer('denda')->default(0);

            $table->enum('status_peminjaman', ['dipinjam', 'dikembalikan'])
                ->default('dipinjam');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};