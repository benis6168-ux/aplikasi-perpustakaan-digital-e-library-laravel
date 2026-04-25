<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\UlasanBuku;
use Illuminate\Http\Request;
use App\Exports\BukuExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::with('kategori');

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                ->orWhere('penulis', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->kategori_id) {
            $query->whereHas('kategori', function($q) use ($request) {
                $q->where('kategori_buku.id', $request->kategori_id);
            });
        }

        $buku = $query->latest()->get();

        return view('admin.buku.index', compact('buku'));
    }

    public function userIndex(Request $request)
    {
        $kategoriList = \App\Models\KategoriBuku::all();
        $query = Buku::with('kategori');

        if ($request->search) {
            $buku->where(function ($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                ->orWhere('penulis', 'like', '%' . $request->search . '%')
                ->orWhere('penerbit', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->kategori_id) {
            $query->whereHas('kategori', function($q) use ($request) {
                $q->where('kategori_buku.id', $request->kategori_id);
            });
        }

        $buku = $query->latest()->get();

        return view('user.buku.index', [
            'buku' => $buku,
            'kategoriList' => $kategoriList
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required|numeric',
            'stok' => 'required|numeric',
            'foto_sampul' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'kategori'     => 'required|array',
        ]);

        $fotoPath = null;

        if ($request->hasFile('foto_sampul')) {
            $fotoPath = $request->file('foto_sampul')->store('sampul', 'public');
        }

        $buku = Buku::create([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'stok' => $request->stok,
            'foto_sampul' => $fotoPath,
            'status' => $request->stok > 0 ? 'tersedia' : 'habis'
        ]);

        if ($request->has('kategori')) {
            $buku->kategori()->attach($request->kategori);
        }

        return redirect()
            ->route('admin.buku.index')
            ->with('success', 'Buku berhasil ditambahkan');
    }

    public function show($id)
    {
        $buku = Buku::findOrFail($id);

        $ulasan = UlasanBuku::with('user')
            ->where('buku_id', $id)
            ->latest()
            ->get();

        return view('user.buku.detail', compact('buku', 'ulasan'));
    }

    public function update(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);

        $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required|numeric',
            'stok' => 'required|numeric',
            'foto_sampul' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'kategori' => 'nullable|array'
        ]);

        $data = [
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'stok' => $request->stok,
            'status' => $request->stok > 0 ? 'tersedia' : 'habis'
        ];

        if ($request->hasFile('foto_sampul')) {

            if ($buku->foto_sampul) {
                Storage::disk('public')->delete($buku->foto_sampul);
            }

            $data['foto_sampul'] = $request->file('foto_sampul')->store('sampul', 'public');
        }

        $buku->update($data);

        if ($request->has('kategori')) {
            $buku->kategori()->sync($request->kategori);
        } else {
            $buku->kategori()->detach();
        }

        return redirect()->route('admin.buku.index')
            ->with('success', 'Buku berhasil diupdate');
    }

    public function create()
    {
        $kategori = \App\Models\KategoriBuku::all();
        return view('admin.buku.create', compact('kategori'));
    }

    public function edit($id)
    {
        $buku = \App\Models\Buku::findOrFail($id);
        $kategori = \App\Models\KategoriBuku::all();
        return view('admin.buku.edit', compact('buku', 'kategori'));
    }

    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);
        $buku->delete();

        return back()->with('success', 'Buku dihapus (soft delete)');
    }

    public function exportPdf()
    {
        $buku = Buku::all();
        $pdf = Pdf::loadView('admin.buku.pdf', compact('buku'));

        return $pdf->download('data-buku.pdf');
        return $pdf->stream('data-buku.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new BukuExport, 'data-buku.xlsx');
    }
}
