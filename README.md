Saat aplikasi dijalankan dan foto tidak muncul lakukan langkah" ini:
"Hard Reset" Symlink (Lakukan di File Explorer)

1.Buka folder project Anda lewat File Explorer.

2.Masuk ke folder public.

3.Cari folder bernama storage . Hapus folder itu secara permanen.

Buka VS Code, buka terminal, dan pastikan Anda berada di direktori project.

Ketik perintah ini:

php artisan storage:link

Cek lagi di folder public, harusnya muncul folder shortcut storage yang baru.
