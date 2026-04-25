<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\UlasanController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::get('/register', [AuthController::class, 'registerForm']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/logout', [AuthController::class, 'logout']);


Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return Auth::user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('user.dashboard');

    })->name('dashboard');

    Route::middleware(['role:admin'])->prefix('admin')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'admin'])
            ->name('admin.dashboard');

        Route::get('/user/pdf', [UserController::class, 'exportPdf'])->name('admin.user.pdf');
        Route::get('/user/excel', [UserController::class, 'exportExcel'])->name('admin.user.excel');
        Route::get('/buku/pdf', [BukuController::class, 'exportPdf'])->name('admin.buku.pdf');
        Route::get('/buku/excel', [BukuController::class, 'exportExcel'])->name('admin.buku.excel');
        Route::get('/peminjaman/pdf', [PeminjamanController::class, 'exportPdf'])->name('admin.peminjaman.pdf');
        Route::get('/peminjaman/excel', [PeminjamanController::class, 'exportExcel'])->name('admin.peminjaman.excel');

        Route::resource('/user', UserController::class)->names('admin.user');
        Route::resource('/buku', BukuController::class)->names('admin.buku');
        Route::resource('/kategori', KategoriController::class)->names('admin.kategori');

        Route::get('/peminjaman', [PeminjamanController::class, 'index'])
            ->name('admin.peminjaman');

        Route::get('/peminjaman/create', [PeminjamanController::class, 'create'])
            ->name('admin.peminjaman.create');

        Route::post('/peminjaman', [PeminjamanController::class, 'storeAdmin'])
            ->name('admin.peminjaman.store');

        Route::get('/peminjaman/{id}/edit', [PeminjamanController::class, 'edit'])
            ->name('admin.peminjaman.edit');

        Route::put('/peminjaman/{id}', [PeminjamanController::class, 'update'])
            ->name('admin.peminjaman.update');

        Route::delete('/peminjaman/{id}', [PeminjamanController::class, 'destroy'])
            ->name('admin.peminjaman.destroy');

        Route::post('/peminjaman/kembali/{id}', [PeminjamanController::class, 'kembali'])
            ->name('admin.peminjaman.kembali');
            
        Route::get('/ulasan', [UlasanController::class, 'indexAdmin'])
            ->name('admin.ulasan');

        Route::delete('/ulasan/{id}', [UlasanController::class, 'destroy'])
            ->name('admin.ulasan.destroy');

    });

    Route::middleware(['role:user'])->prefix('user')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'user'])
            ->name('user.dashboard');

        Route::get('/buku', [BukuController::class, 'userIndex'])
            ->name('user.buku');

        Route::get('/buku/{id}', [BukuController::class, 'show'])
            ->name('user.buku.detail');

        Route::post('/peminjaman', [PeminjamanController::class, 'store']);

        Route::get('/peminjaman', [PeminjamanController::class, 'userIndex'])
            ->name('user.peminjaman');

        Route::post('/peminjaman/kembali/{id}', [PeminjamanController::class, 'kembali'])
            ->name('peminjaman.kembali');

        Route::get('/ulasan', [UlasanController::class, 'indexUser'])
            ->name('user.ulasan.index');

        Route::get('/ulasan/create', [UlasanController::class, 'createuser'])
            ->name('user.ulasan.create');

        Route::get('/ulasan/{id}/edit', [UlasanController::class, 'edituser'])
            ->name('user.ulasan.edit');

        Route::post('/ulasan', [UlasanController::class, 'storeuser'])
            ->name('user.ulasan.store');

        Route::put('/ulasan/{id}', [UlasanController::class, 'updateuser'])
            ->name('user.ulasan.update');

        Route::delete('/ulasan/{id}', [UlasanController::class, 'destroyuser'])
            ->name('user.ulasan.delete');

        Route::get('/profile', [UserController::class, 'profileuser'])
            ->name('user.profile');

        Route::get('/profile/edit', [UserController::class, 'editProfileUser'])
            ->name('user.profile.edit');

        Route::post('/profile/update', [UserController::class, 'updateProfile'])
            ->name('user.profile.update');
    });
});
