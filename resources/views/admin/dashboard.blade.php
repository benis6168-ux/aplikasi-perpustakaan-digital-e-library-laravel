@extends('admin.layout.app')

@section('content')

{{-- Header --}}
<div class="mb-4">
    <h3 class="fw-bold text-dark mb-1">Dashboard Admin</h3>
    <p class="text-muted small">Selamat datang kembali, <span class="text-primary fw-bold">{{ auth()->user()->username }}</span>. Berikut adalah ringkasan perpustakaan Anda hari ini.</p>
</div>

{{-- Statistik Row 1 --}}
<div class="row g-4 mb-4">
    {{-- User --}}
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100 overflow-hidden">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small fw-bold text-uppercase mb-1">Total User</p>
                        <h2 class="fw-bold mb-0 text-dark">{{ $total_user }}</h2>
                    </div>
                    <div class="bg-primary bg-opacity-10 p-3 rounded-3 text-primary">
                        <i class="fa-solid fa-users fs-4"></i>
                    </div>
                </div>
            </div>
            <div class="bg-primary" style="height: 4px; opacity: 0.5;"></div>
        </div>
    </div>

    {{-- Total Buku --}}
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100 overflow-hidden">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small fw-bold text-uppercase mb-1">Total Buku</p>
                        <h2 class="fw-bold mb-0 text-dark">{{ $total_buku }}</h2>
                    </div>
                    <div class="bg-info bg-opacity-10 p-3 rounded-3 text-info">
                        <i class="fa-solid fa-book fs-4"></i>
                    </div>
                </div>
            </div>
            <div class="bg-info" style="height: 4px; opacity: 0.5;"></div>
        </div>
    </div>

    {{-- Tersedia --}}
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100 overflow-hidden">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small fw-bold text-uppercase mb-1">Tersedia</p>
                        <h2 class="fw-bold mb-0 text-success">{{ $buku_tersedia }}</h2>
                    </div>
                    <div class="bg-success bg-opacity-10 p-3 rounded-3 text-success">
                        <i class="fa-solid fa-check-double fs-4"></i>
                    </div>
                </div>
            </div>
            <div class="bg-success" style="height: 4px; opacity: 0.5;"></div>
        </div>
    </div>

    {{-- Habis --}}
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100 overflow-hidden">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small fw-bold text-uppercase mb-1">Stok Habis</p>
                        <h2 class="fw-bold mb-0 text-danger">{{ $buku_habis }}</h2>
                    </div>
                    <div class="bg-danger bg-opacity-10 p-3 rounded-3 text-danger">
                        <i class="fa-solid fa-box-archive fs-4"></i>
                    </div>
                </div>
            </div>
            <div class="bg-danger" style="height: 4px; opacity: 0.5;"></div>
        </div>
    </div>
</div>

{{-- Statistik Row 2 --}}
<div class="row g-4 mb-5">
    {{-- Pinjam Aktif --}}
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-primary text-white">
            <div class="card-body p-4">
                <p class="opacity-75 small fw-bold text-uppercase mb-1">Pinjam Aktif</p>
                <div class="d-flex align-items-end justify-content-between">
                    <h2 class="fw-bold mb-0">{{ $peminjaman_aktif }}</h2>
                    <i class="fa-solid fa-clock-rotate-left fs-1 opacity-25"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Total Transaksi --}}
    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-4 bg-white">
            <p class="text-muted small fw-bold text-uppercase mb-1">Total Transaksi</p>
            <h2 class="fw-bold mb-0 text-dark">{{ $total_peminjaman }}</h2>
        </div>
    </div>

    {{-- Ulasan --}}
    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-4 bg-white text-dark">
            <p class="text-muted small fw-bold text-uppercase mb-1">Total Ulasan</p>
            <h2 class="fw-bold mb-0">{{ $total_ulasan }} <i class="fa-solid fa-star text-warning fs-5 ms-1"></i></h2>
        </div>
    </div>

    {{-- Denda --}}
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-dark text-white">
            <div class="card-body p-4">
                <p class="opacity-75 small fw-bold text-uppercase mb-1 text-warning">Total Denda</p>
                <h3 class="fw-bold mb-0">Rp {{ number_format($total_denda, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
</div>

{{-- Tabel Aktivitas --}}
<div class="card border-0 shadow-sm overflow-hidden">
    <div class="card-header bg-white border-0 py-4 px-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <h5 class="fw-bold text-dark mb-0"><i class="fa-solid fa-list-check me-2 text-primary"></i>Aktivitas Peminjaman Terbaru</h5>

        <form method="GET" action="{{ route('admin.dashboard') }}" class="d-flex">
            <div class="input-group">
                <input type="text" name="search" class="form-control bg-light border-0 py-2 ps-3"
                       placeholder="Cari user / buku..." value="{{ request('search') }}">
                <button class="btn btn-primary px-3 shadow-none"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light text-muted small">
                <tr>
                    <th class="ps-4 py-3 border-0">USER</th>
                    <th class="py-3 border-0">BUKU</th>
                    <th class="py-3 border-0 text-center">STATUS</th>
                    <th class="py-3 border-0 text-end pe-4">DENDA</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayat as $r)
                    <tr>
                        <td class="ps-4 py-3 border-bottom border-light">
                            <div class="d-flex align-items-center">
                                <div class="bg-secondary bg-opacity-10 rounded-circle p-2 me-2 text-center" style="width: 35px; height: 35px;">
                                    <i class="fa-solid fa-user text-secondary small"></i>
                                </div>
                                <span class="fw-bold text-dark">{{ $r->user->username ?? '-' }}</span>
                            </div>
                        </td>
                        <td class="py-3 border-bottom border-light">{{ $r->buku->judul ?? '-' }}</td>
                        <td class="py-3 border-bottom border-light text-center">
                            @if($r->status_peminjaman == 'dipinjam')
                                <span class="badge bg-warning bg-opacity-10 text-warning px-3 border border-warning border-opacity-25 rounded-pill">
                                    <i class="fa-solid fa-hourglass-half me-1"></i> Dipinjam
                                </span>
                            @else
                                <span class="badge bg-success bg-opacity-10 text-success px-3 border border-success border-opacity-25 rounded-pill">
                                    <i class="fa-solid fa-circle-check me-1"></i> Dikembalikan
                                </span>
                            @endif
                        </td>
                        <td class="py-3 border-bottom border-light text-end pe-4 fw-bold {{ $r->denda > 0 ? 'text-danger' : 'text-muted' }}">
                            Rp {{ number_format($r->denda, 0, ',', '.') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <i class="fa-solid fa-folder-open fs-1 text-muted opacity-25 d-block mb-2"></i>
                            <span class="text-muted italic">Tidak ditemukan aktivitas peminjaman.</span>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
