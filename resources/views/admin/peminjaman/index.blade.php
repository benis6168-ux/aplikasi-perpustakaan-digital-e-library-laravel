@extends('admin.layout.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-1">Data Peminjaman</h3>
        <p class="text-muted small mb-0">Pantau sirkulasi buku, jatuh tempo, dan manajemen denda.</p>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 py-3 mt-2">
        <div class="row g-3 justify-content-between">
            {{-- Grup Tombol Aksi --}}
            <div class="col-md-auto d-flex gap-2">
                <a href="{{ route('admin.peminjaman.create') }}" class="btn btn-primary px-3 shadow-none">
                    <i class="fa-solid fa-plus me-1"></i> Tambah Transaksi
                </a>

                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle px-3 shadow-none" type="button" data-bs-toggle="dropdown">
                        <i class="fa-solid fa-print me-1"></i> Laporan
                    </button>
                    <ul class="dropdown-menu border-0 shadow-sm">
                        <li>
                            <a class="dropdown-item text-danger" href="{{ route('admin.peminjaman.pdf') }}">
                                <i class="fa-solid fa-file-pdf me-2"></i> Cetak PDF
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item text-success" href="{{ route('admin.peminjaman.excel') }}">
                                <i class="fa-solid fa-file-excel me-2"></i> Export Excel
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Kolom Pencarian --}}
            <div class="col-md-4">
                <form method="GET" action="{{ route('admin.peminjaman') }}">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i class="fa-solid fa-magnifying-glass text-muted small"></i></span>
                        <input type="text" name="search" class="form-control bg-light border-0 shadow-none"
                               placeholder="Cari user atau buku..." value="{{ request('search') }}">
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
                    <th class="ps-4 py-3 border-0">PEMINJAM</th>
                    <th class="py-3 border-0">BUKU</th>
                    <th class="py-3 border-0">DURASI PINJAM</th>
                    <th class="py-3 border-0 text-center">STATUS</th>
                    <th class="py-3 border-0 text-center">DENDA</th>
                    <th class="py-3 border-0 text-end pe-4" width="220">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $p)
                    <tr>
                        <td class="ps-4 py-3 border-bottom border-light">
                            <div class="fw-bold text-dark">{{ $p->user->username }}</div>
                            <small class="text-muted">{{ $p->user->email }}</small>
                        </td>
                        <td class="py-3 border-bottom border-light">
                            <span class="text-truncate d-inline-block" style="max-width: 200px;">
                                {{ $p->buku->judul ?? '-' }}
                            </span>
                        </td>
                        <td class="py-3 border-bottom border-light">
                            <div class="small text-dark fw-semibold">{{ $p->tanggal_peminjaman }}</div>
                            <div class="small text-danger italic">s/d {{ $p->tanggal_kembali_seharusnya }}</div>
                        </td>
                        <td class="py-3 border-bottom border-light text-center">
                            @if($p->status_peminjaman == 'dipinjam')
                                <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 rounded-pill px-3">
                                    <i class="fa-solid fa-clock me-1 small"></i> Dipinjam
                                </span>
                            @else
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3">
                                    <i class="fa-solid fa-circle-check me-1 small"></i> Kembali
                                </span>
                            @endif
                        </td>
                        <td class="py-3 border-bottom border-light text-center">
                            <span class="{{ $p->denda > 0 ? 'text-danger fw-bold' : 'text-muted' }}">
                                Rp {{ number_format($p->denda ?? 0) }}
                            </span>
                        </td>
                        <td class="py-3 border-bottom border-light text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                {{-- Tombol Proses Pengembalian --}}
                                @if($p->status_peminjaman == 'dipinjam')
                                <form action="{{ route('admin.peminjaman.kembali', $p->id) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-sm btn-success px-3 shadow-sm" title="Proses Pengembalian">
                                        <i class="fa-solid fa-rotate-left me-1"></i> Kembali
                                    </button>
                                </form>
                                @endif

                                <a href="{{ route('admin.peminjaman.edit', $p->id) }}"
                                   class="btn btn-light btn-sm text-warning border shadow-sm px-2">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>

                                <form action="{{ route('admin.peminjaman.destroy', $p->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-light btn-sm text-danger border shadow-sm px-2"
                                            onclick="return confirm('Hapus transaksi ini?')">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <p class="text-muted mb-0 italic">Tidak ada data peminjaman yang ditemukan.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
