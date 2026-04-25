@extends('user.layout.app')

@section('content')

<div class="mb-4">
    <h3 class="fw-bold text-dark">Dashboard User</h3>
    <p class="text-muted">
        Selamat datang kembali, <span class="fw-bold text-primary">{{ Auth::user()->nama_lengkap }}</span>! 
        Berikut ringkasan aktivitas perpustakaan Anda.
    </p>
</div>

{{-- Stats Card --}}
<div class="row g-4 mb-5">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100 p-3" style="border-left: 5px solid #2563eb !important;">
            <div class="d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3 text-primary">
                    <i class="fa-solid fa-book-bookmark fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 fw-medium">Total Pinjam</p>
                    <h3 class="fw-bold mb-0">{{ $total_pinjam_saya ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100 p-3" style="border-left: 5px solid #f59e0b !important;">
            <div class="d-flex align-items-center">
                <div class="bg-warning bg-opacity-10 p-3 rounded-circle me-3 text-warning">
                    <i class="fa-solid fa-spinner fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 fw-medium">Pinjaman Aktif</p>
                    <h3 class="fw-bold mb-0">{{ $pinjam_aktif ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100 p-3" style="border-left: 5px solid #10b981 !important;">
            <div class="d-flex align-items-center">
                <div class="bg-success bg-opacity-10 p-3 rounded-circle me-3 text-success">
                    <i class="fa-solid fa-comment-dots fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 fw-medium">Ulasan Saya</p>
                    <h3 class="fw-bold mb-0">{{ $ulasan_saya ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100 p-3" style="border-left: 5px solid #ef4444 !important;">
            <div class="d-flex align-items-center">
                <div class="bg-danger bg-opacity-10 p-3 rounded-circle me-3 text-danger">
                    <i class="fa-solid fa-wallet fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 fw-medium">Total Denda</p>
                    <h3 class="fw-bold mb-0 text-danger" style="font-size: 1.2rem;">Rp {{ number_format($total_denda ?? 0, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Riwayat Section --}}
<div class="card border-0 shadow-sm overflow-hidden">
    <div class="card-header bg-white py-3 d-flex flex-column flex-md-row justify-content-between align-items-md-center border-bottom-0">
        <h5 class="fw-bold mb-3 mb-md-0"><i class="fa-solid fa-history me-2 text-primary"></i>Riwayat Terbaru</h5>

        {{-- SEARCH --}}
        <form method="GET" action="{{ route('user.dashboard') }}" class="d-flex">
            <div class="input-group">
                <span class="input-group-text bg-light border-0" id="basic-addon1">
                    <i class="fa-solid fa-magnifying-glass text-muted"></i>
                </span>
                <input type="text"
                       name="search"
                       class="form-control bg-light border-0 py-2 shadow-none"
                       placeholder="Cari buku..."
                       value="{{ request('search') }}"
                       style="font-size: 0.9rem;">
                <button class="btn btn-primary px-4 fw-semibold" type="submit">Cari</button>
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">Judul Buku</th>
                    <th class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayat_pinjam ?? [] as $r)
                <tr>
                    <td class="ps-4">
                        <div class="d-flex align-items-center">
                            <div class="p-2 bg-light rounded me-3 text-secondary">
                                <i class="fa-solid fa-book"></i>
                            </div>
                            <span class="fw-medium text-dark">{{ $r->buku->judul ?? 'Buku tidak ditemukan' }}</span>
                        </div>
                    </td>
                    <td class="text-center">
                        @if($r->status_peminjaman == 'dipinjam')
                            <span class="badge rounded-pill bg-warning text-dark px-3 py-2">
                                <i class="fa-solid fa-clock me-1"></i> Dipinjam
                            </span>
                        @else
                            <span class="badge rounded-pill bg-success px-3 py-2">
                                <i class="fa-solid fa-check-circle me-1"></i> {{ ucfirst($r->status_peminjaman) }}
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="2" class="text-center py-5">
                        <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="80" class="mb-3 opacity-25">
                        <p class="text-muted mb-0">Belum ada riwayat peminjaman</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
