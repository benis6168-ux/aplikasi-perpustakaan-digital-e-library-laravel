@extends('admin.layout.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-1">Kategori Buku</h3>
        <p class="text-muted small mb-0">Kelola kategori untuk mengelompokkan koleksi buku perpustakaan.</p>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 py-3 mt-2">
        <div class="row g-3 justify-content-between">
            <div class="col-md-auto">
                <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary px-3 shadow-none">
                    <i class="fa-solid fa-plus me-1"></i> Tambah Kategori
                </a>
            </div>

            <div class="col-md-4">
                <form method="GET" action="{{ route('admin.kategori.index') }}">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i class="fa-solid fa-magnifying-glass text-muted small"></i></span>
                        <input type="text" name="search" class="form-control bg-light border-0 shadow-none" placeholder="Cari nama kategori..." value="{{ request('search') }}">
                        <button class="btn btn-secondary px-3">Cari</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light text-muted small">
                <tr>
                    <th class="ps-4 py-3 border-0">NAMA KATEGORI</th>
                    <th class="py-3 border-0 text-center">JUMLAH JUDUL</th>
                    <th class="py-3 border-0 text-center">TOTAL STOK</th>
                    <th class="py-3 border-0 text-end pe-4" width="150">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kategori as $k)
                    <tr>
                        <td class="ps-4 py-3 border-bottom border-light">
                            <a href="{{ route('admin.buku.index', ['kategori_id' => $k->id]) }}" class="text-decoration-none text-dark fw-semibold transition-link">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px;">
                                        <i class="fa-solid fa-tag small"></i>
                                    </div>
                                    <span>{{ $k->nama_kategori }}</span>
                                </div>
                            </a>
                        </td>
                        <td class="py-3 border-bottom border-light text-center">
                            <span class="text-dark fw-medium">{{ $k->buku->count() }} Judul</span>
                        </td>
                        <td class="py-3 border-bottom border-light text-center">
                            @php
                                // Menghitung total stok dari semua buku dalam kategori ini
                                $totalStok = $k->buku->sum('stok');
                            @endphp
                            <span class="badge {{ $totalStok > 0 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 {{ $totalStok > 0 ? 'text-success' : 'text-danger' }} border {{ $totalStok > 0 ? 'border-success' : 'border-danger' }} border-opacity-25 px-3">
                                {{ $totalStok }} Buku
                            </span>
                        </td>
                        <td class="py-3 border-bottom border-light text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.kategori.edit', $k->id) }}" class="btn btn-light btn-sm text-warning border shadow-sm px-2" title="Edit Kategori">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>

                                <form method="POST" action="{{ route('admin.kategori.destroy', $k->id) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-light btn-sm text-danger border shadow-sm px-2" onclick="return confirm('Hapus kategori ini? Semua relasi buku dengan kategori ini akan dilepas.')" title="Hapus Kategori">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <div class="text-muted opacity-50 mb-3"><i class="fa-solid fa-tags fs-1"></i></div>
                            <p class="mb-0">Belum ada kategori yang ditemukan.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
    .transition-link:hover span {
        text-decoration: underline;
        color: #0d6efd !important;
    }
</style>

@endsection