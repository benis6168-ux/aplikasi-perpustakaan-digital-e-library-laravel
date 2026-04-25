<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Buku;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Exports\PeminjamanExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class PeminjamanController extends Controller
{
    /*
    |------------------------------------------------------------------
    | LIST PEMINJAMAN (ADMIN)
    |------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $query = Peminjaman::with(['user', 'buku']);

        if ($request->search) {
            $query->where(function ($q) use ($request) {

                $q->whereHas('user', function ($q2) use ($request) {
                    $q2->where('username', 'like', '%' . $request->search . '%');
                })

                ->orWhereHas('buku', function ($q3) use ($request) {
                    $q3->where('judul', 'like', '%' . $request->search . '%');
                });

            });
        }

        $data = $query->latest()->get();

        return view('admin.peminjaman.index', compact('data'));
    }

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'buku_id' => 'required',
            'tanggal_peminjaman' => 'required|date',
            'tanggal_kembali_seharusnya' => 'required|date',
            'status_peminjaman' => 'required'
        ]);

        Peminjaman::create([
            'user_id' => $request->user_id,
            'buku_id' => $request->buku_id,
            'tanggal_peminjaman' => $request->tanggal_peminjaman,
            'tanggal_kembali_seharusnya' => $request->tanggal_kembali_seharusnya,
            'status_peminjaman' => $request->status_peminjaman,
            'denda' => 0
        ]);

        return redirect()->route('admin.peminjaman')
            ->with('success', 'Peminjaman berhasil ditambahkan');
    }

    public function edit($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $users = \App\Models\User::all();
        $buku = \App\Models\Buku::all();

        return view('admin.peminjaman.edit', compact('peminjaman', 'users', 'buku'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required',
            'buku_id' => 'required',
            'tanggal_peminjaman' => 'required|date',
            'tanggal_kembali_seharusnya' => 'required|date',
        ]);

        $peminjaman = Peminjaman::findOrFail($id);

        $peminjaman->update([
            'user_id' => $request->user_id,
            'buku_id' => $request->buku_id,
            'tanggal_peminjaman' => $request->tanggal_peminjaman,
            'tanggal_kembali_seharusnya' => $request->tanggal_kembali_seharusnya,
        ]);

        return redirect()->route('admin.peminjaman')
            ->with('success', 'Data peminjaman berhasil diupdate');
    }

    /*
    |------------------------------------------------------------------
    | PINJAM BUKU (USER)
    |------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $userId = auth()->id();

        // pastikan user login
        if (!$userId) {
            return back()->with('error', 'Silakan login dulu');
        }

        // FIX: hitung lebih robust
        $aktif = Peminjaman::where('user_id', $userId)
            ->where('status_peminjaman', 'dipinjam')
            ->count();

        if ($aktif >= 5) {
            return back()->with('error', 'Maksimal 5 buku dipinjam');
        }

        $buku = Buku::findOrFail($request->buku_id);

        if ($buku->stok <= 0) {
            return back()->with('error', 'Stok buku habis');
        }

        // FIX DOUBLE PINJAM BUKU YANG SAMA
        $sudahPinjam = Peminjaman::where('user_id', $userId)
            ->where('buku_id', $request->buku_id)
            ->where('status_peminjaman', 'dipinjam')
            ->exists();

        if ($sudahPinjam) {
            return back()->with('error', 'Kamu sudah meminjam buku ini');
        }

        Peminjaman::create([
            'user_id' => $userId,
            'buku_id' => $request->buku_id,
            'tanggal_peminjaman' => Carbon::now()->startOfDay(),
            'tanggal_kembali_seharusnya' => Carbon::now()->addDays(7)->startOfDay(),
            'status_peminjaman' => 'dipinjam'
        ]);

        $buku->decrement('stok');

        return back()->with('success', 'Buku berhasil dipinjam');
    }

    /*
    |------------------------------------------------------------------
    | PENGEMBALIAN + DENDA (FIXED)
    |------------------------------------------------------------------
    */
    public function kembali($id)
    {
        $peminjaman = Peminjaman::with('buku')->findOrFail($id);

        // kalau sudah dikembalikan
        if ($peminjaman->status_peminjaman === 'dikembalikan') {
            return back()->with('error', 'Buku sudah dikembalikan');
        }

        $jatuh_tempo = Carbon::parse($peminjaman->tanggal_kembali_seharusnya)->startOfDay();
        $kembali = Carbon::now()->startOfDay();

        // hitung keterlambatan
        $telat = $kembali->gt($jatuh_tempo)
            ? $jatuh_tempo->diffInDays($kembali)
            : 0;

        // denda fix
        $denda = $telat * 1000;

        $peminjaman->update([
            'tanggal_pengembalian' => $kembali,
            'status_peminjaman' => 'dikembalikan',
            'denda' => $denda
        ]);

        // update stok
        $peminjaman->buku->increment('stok');

        return back()->with(
            'success',
            'Buku berhasil dikembalikan. Denda: Rp ' . number_format($denda, 0, ',', '.')
        );
    }

    public function create()
    {
        $users = User::all();
        $buku = Buku::all();

        return view('admin.peminjaman.create', compact('users', 'buku'));
    }

    /*
    |------------------------------------------------------------------
    | DELETE (ADMIN OPTIONAL)
    |------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        // kalau masih dipinjam, balikin stok dulu
        if ($peminjaman->status_peminjaman == 'dipinjam') {
            $peminjaman->buku->increment('stok');
        }

        $peminjaman->delete();

        return back()->with('success', 'Data peminjaman berhasil dihapus');
    }

    /*
    |------------------------------------------------------------------
    | USER VIEW
    |------------------------------------------------------------------
    */
    public function userIndex(Request $request)
    {
        $peminjaman = Peminjaman::with('buku')
            ->where('user_id', auth()->id());

        // 🔍 search judul buku
        if ($request->search) {
            $peminjaman->whereHas('buku', function ($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%');
            });
        }

        // 🔍 filter status
        if ($request->status) {
            $peminjaman->where('status_peminjaman', $request->status);
        }

        return view('user.peminjaman.index', [
            'peminjaman' => $peminjaman->latest()->get()
        ]);
    }

    public function exportPdf()
    {
        $data = Peminjaman::with(['user','buku'])->get();

        $pdf = Pdf::loadView('admin.peminjaman.pdf', compact('data'));

        return $pdf->download('data-peminjaman.pdf');
    }

    public function exportExcel()
    {
        $data = Peminjaman::with('user','buku')->get();

        return Excel::download(new PeminjamanExport($data), 'data-peminjaman.xlsx');
    }
}
