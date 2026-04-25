<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\UlasanBuku;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ADMIN DASHBOARD
    |--------------------------------------------------------------------------
    */
    public function admin(Request $request)
    {
        $riwayatQuery = Peminjaman::with(['user', 'buku']);

        if ($request->search) {
            $riwayatQuery->where(function ($q) use ($request) {

                $q->whereHas('user', function ($u) use ($request) {
                    $u->where('username', 'like', '%' . $request->search . '%');
                })

                ->orWhereHas('buku', function ($b) use ($request) {
                    $b->where('judul', 'like', '%' . $request->search . '%');
                });

            });
        }

        return view('admin.dashboard', [

            'total_user' => User::count(),
            'total_buku' => Buku::count(),

            'buku_tersedia' => Buku::sum('stok'),
            'buku_habis' => Buku::where('stok', 0)->count(),

            'total_peminjaman' => Peminjaman::count(),

            'peminjaman_aktif' => Peminjaman::where('status_peminjaman', 'dipinjam')
                ->distinct('user_id')
                ->count('user_id'),

            'buku_dipinjam' => Peminjaman::where('status_peminjaman', 'dipinjam')->count(),

            'total_ulasan' => UlasanBuku::count(),

            'total_denda' => Peminjaman::sum('denda'),

            'riwayat' => $riwayatQuery
                ->latest()
                ->take(10)
                ->get(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | USER DASHBOARD (FIXED + SAFE)
    |--------------------------------------------------------------------------
    */
    public function user(Request $request)
    {
        $user = auth()->user();
        $search = $request->search;

        $riwayat = Peminjaman::with('buku')
            ->where('user_id', $user->id)
            ->when($search, function ($q) use ($search) {
                $q->whereHas('buku', function ($q2) use ($search) {
                    $q2->where('judul', 'like', "%$search%");
                });
            })
            ->latest()
            ->take(5)
            ->get();

        return view('user.dashboard', [
            'total_pinjam_saya' => Peminjaman::where('user_id', $user->id)->count(),

            'pinjam_aktif' => Peminjaman::where('user_id', $user->id)
                ->where('status_peminjaman', 'dipinjam')
                ->count(),

            'riwayat_pinjam' => $riwayat,

            'ulasan_saya' => \App\Models\UlasanBuku::where('user_id', $user->id)->count(),

            'total_denda' => Peminjaman::where('user_id', $user->id)->sum('denda'),
        ]);
    }
}
