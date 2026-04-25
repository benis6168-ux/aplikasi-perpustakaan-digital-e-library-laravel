<?php

namespace App\Http\Controllers;

use App\Models\UlasanBuku;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UlasanController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | USER
    |--------------------------------------------------------------------------
    */
    public function indexUser()
    {
        $user = auth()->user();

        $bukuDipinjam = Buku::whereHas('peminjaman', function($query) {
            $query->where('user_id', auth()->id());
        })->get();

        return view('user.ulasan.index', [
            'ulasan' => UlasanBuku::with('buku')
                ->where('user_id', $user->id)
                ->latest()
                ->get(),
            'buku' => $bukuDipinjam
        ]);
    }

    public function edituser($id)
    {
        $ulasan = UlasanBuku::where('user_id', auth()->id())
            ->findOrFail($id);

        $bukuDipinjam = Buku::whereHas('peminjaman', function($query) {
            $query->where('user_id', auth()->id());
        })->get();

        return view('user.ulasan.edit', [
            'ulasan' => $ulasan,
            'buku' => \App\Models\Buku::all()
        ]);
    }

    public function updateuser(Request $request, $id)
    {
        $ulasan = UlasanBuku::where('user_id', auth()->id())
            ->findOrFail($id);

        $pernahPinjam = Peminjaman::where('user_id', auth()->id())
            ->where('buku_id', $request->buku_id)
            ->exists();

        $ulasan->update([
            'buku_id' => $request->buku_id,
            'ulasan' => $request->ulasan,
            'rating' => $request->rating
        ]);

        return redirect()->route('user.ulasan.index')
            ->with('success', 'Ulasan berhasil diupdate');
    }

    public function storeuser(Request $request)
    {
        $pernahPinjam = Peminjaman::where('user_id', auth()->id())
            ->where('buku_id', $request->buku_id)
            ->exists();

        if (!$pernahPinjam) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Anda belum pernah meminjam buku ini.'], 403);
            }
            return back()->with('error', 'Anda hanya bisa mengulas buku yang sudah pernah dipinjam.');
        }

        UlasanBuku::create([
            'user_id' => Auth::id(),
            'buku_id' => $request->buku_id,
            'ulasan' => $request->ulasan,
            'rating' => $request->rating
        ]);

        if (auth()->user()->role === 'admin') {
        return redirect()
            ->route('admin.ulasan.index')
            ->with('success', 'Ulasan berhasil ditambahkan');
        }

        return response()->json([
            'success' => true,
            'message' => 'Ulasan berhasil ditambahkan'
        ]);
    }

    public function createuser()
    {
        $buku = Buku::whereHas('peminjaman', function($query) {
            $query->where('user_id', auth()->id());
        })->get();

        return view('user.ulasan.create', compact('buku'));
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */
    public function indexAdmin(Request $request)
    {
        $query = UlasanBuku::with(['user', 'buku']);

        if ($request->search) {
            $query->where(function ($q) use ($request) {

                $q->where('ulasan', 'like', '%' . $request->search . '%')

                ->orWhereHas('user', function ($q2) use ($request) {
                    $q2->where('username', 'like', '%' . $request->search . '%');
                })

                ->orWhereHas('buku', function ($q3) use ($request) {
                    $q3->where('judul', 'like', '%' . $request->search . '%');
                });

            });
        }

        $ulasan = $query->latest()->get();

        return view('admin.ulasan.index', compact('ulasan'));
    }

    public function destroy($id)
    {
        UlasanBuku::findOrFail($id)->delete();
        return back()->with('success', 'Ulasan dihapus');
    }
}
