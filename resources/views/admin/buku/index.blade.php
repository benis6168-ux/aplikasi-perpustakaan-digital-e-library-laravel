@extends('admin.layout.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-1">Koleksi Buku</h3>
        <p class="text-muted small mb-0">Total katalog buku yang tersedia di perpustakaan digital.</p>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 py-3 mt-2">
        <div class="row g-3 justify-content-between">
            <div class="col-md-auto d-flex gap-2">
                <a href="{{ route('admin.buku.create') }}" class="btn btn-primary px-3 shadow-none">
                    <i class="fa-solid fa-plus me-1"></i> Tambah Buku
                </a>

                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle px-3 shadow-none" type="button" data-bs-toggle="dropdown">
                        <i class="fa-solid fa-file-export me-1"></i> Export
                    </button>
                    <ul class="dropdown-menu border-0 shadow-sm">
                        <li><a class="dropdown-item text-danger" href="{{ route('admin.buku.pdf') }}"><i class="fa-solid fa-file-pdf me-2"></i> PDF</a></li>
                        <li><a class="dropdown-item text-success" href="{{ route('admin.buku.excel') }}"><i class="fa-solid fa-file-excel me-2"></i> Excel</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-4">
                <form method="GET" action="{{ route('admin.buku.index') }}">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i class="fa-solid fa-magnifying-glass text-muted small"></i></span>
                        <input type="text" name="search" class="form-control bg-light border-0 shadow-none" placeholder="Cari judul, penulis..." value="{{ request('search') }}">
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
                    <th class="ps-4 py-3 border-0">SAMPUL & DETAIL BUKU</th>
                    <th class="py-3 border-0">KATEGORI</th> {{-- Kolom Kategori --}}
                    <th class="py-3 border-0">PENULIS</th>
                    <th class="py-3 border-0 text-center">STOK</th>
                    <th class="py-3 border-0 text-center">STATUS</th>
                    <th class="py-3 border-0 text-end pe-4" width="150">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($buku as $b)
                    <tr>
                        <td class="ps-4 py-3 border-bottom border-light">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    @if($b->foto_sampul)
                                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#viewModal{{ $b->id }}">
                                            <img src="{{ asset('storage/' . $b->foto_sampul) }}" 
                                                 alt="{{ $b->judul }}" 
                                                 class="rounded shadow-sm img-thumbnail" 
                                                 style="width: 45px; height: 60px; object-fit: cover; cursor: zoom-in;">
                                        </a>
                                    @else
                                        <div class="bg-primary bg-opacity-10 text-primary rounded d-flex align-items-center justify-content-center shadow-sm" style="width: 45px; height: 60px;">
                                            <i class="fa-solid fa-book opacity-50"></i>
                                        </div>
                                    @endif
                                </div>
                                
                                <div>
                                    <span class="fw-semibold text-dark d-block">{{ $b->judul }}</span>
                                    <span class="text-muted small">{{ $b->penerbit }} ({{ $b->tahun_terbit }})</span>
                                </div>
                            </div>
                        </td>

                        {{-- Menampilkan List Kategori dengan Badge --}}
                        <td class="py-3 border-bottom border-light">
                            @forelse($b->kategori as $kat)
                                <span class="badge bg-light text-primary border border-primary border-opacity-10 fw-normal mb-1">
                                    {{ $kat->nama_kategori }}
                                </span>
                            @empty
                                <span class="text-muted small"><em>-</em></span>
                            @endforelse
                        </td>

                        <td class="py-3 border-bottom border-light">
                            <span class="text-muted small"><i class="fa-solid fa-user-pen me-1 opacity-50"></i> {{ $b->penulis }}</span>
                        </td>
                        <td class="py-3 border-bottom border-light text-center">
                            <span class="fw-bold {{ $b->stok > 0 ? 'text-dark' : 'text-danger' }}">
                                {{ $b->stok }}
                            </span>
                        </td>
                        <td class="py-3 border-bottom border-light text-center">
                            @if($b->stok > 0)
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3">Tersedia</span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-3">Habis</span>
                            @endif
                        </td>
                        <td class="py-3 border-bottom border-light text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.buku.edit', $b->id) }}" class="btn btn-light btn-sm text-warning border shadow-sm px-2">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>

                                <form method="POST" action="{{ route('admin.buku.destroy', $b->id) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-light btn-sm text-danger border shadow-sm px-2" onclick="return confirm('Hapus data buku ini?')">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    {{-- MODAL VIEW SAMPUL --}}
                    @if($b->foto_sampul)
                    <div class="modal fade" id="viewModal{{ $b->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow-lg">
                                <div class="modal-header border-0 pb-0">
                                    <h6 class="modal-title fw-bold">{{ $b->judul }}</h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-center p-4">
                                    <img src="{{ asset('storage/' . $b->foto_sampul) }}" class="img-fluid rounded shadow" style="max-height: 500px;" alt="{{ $b->judul }}">
                                    <div class="mt-3 text-muted small">
                                        <p class="mb-1"><strong>Penulis:</strong> {{ $b->penulis }}</p>
                                        <p class="mb-0"><strong>Kategori:</strong> 
                                            {{ $b->kategori->pluck('nama_kategori')->implode(', ') ?: '-' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="text-muted opacity-50 mb-3"><i class="fa-solid fa-book-open fs-1"></i></div>
                            <p class="mb-0">Belum ada buku dalam katalog.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection