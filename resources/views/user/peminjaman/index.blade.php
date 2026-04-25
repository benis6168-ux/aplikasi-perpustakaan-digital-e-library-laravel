@extends('user.layout.app')

@section('content')

{{-- Header --}}
<div class="mb-4">
    <h3 class="fw-bold text-dark">Peminjaman Saya</h3>
    <p class="text-muted">Pantau status buku yang sedang Anda pinjam dan riwayat pengembalian.</p>
</div>

{{-- Filter Card --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-3">
        <form method="GET" action="{{ route('user.peminjaman') }}">
            <div class="row g-2">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0 text-muted">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                        <input type="text"
                               name="search"
                               class="form-control border-start-0 ps-0 shadow-none"
                               placeholder="Cari judul buku..."
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <select name="status" class="form-select shadow-none">
                        <option value="">Semua Status</option>
                        <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                        <option value="dikembalikan" {{ request('status') == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-primary w-100 fw-semibold">
                        <i class="fa-solid fa-filter me-2"></i>Terapkan Filter
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Table Card --}}
<div class="card border-0 shadow-sm overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="ps-4 py-3 text-uppercase small fw-bold text-muted">Buku</th>
                    <th class="py-3 text-uppercase small fw-bold text-muted text-center">Tanggal Pinjam</th>
                    <th class="py-3 text-uppercase small fw-bold text-muted text-center">Jatuh Tempo</th>
                    <th class="py-3 text-uppercase small fw-bold text-muted text-center">Status</th>
                    <th class="py-3 text-uppercase small fw-bold text-muted text-end">Denda</th>
                    <th class="pe-4 py-3 text-uppercase small fw-bold text-muted text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjaman as $p)
                <tr>
                    <td class="ps-4">
                        <div class="fw-bold text-dark">{{ $p->buku->judul ?? '-' }}</div>
                        <small class="text-muted">ID: #{{ $p->id }}</small>
                    </td>
                    <td class="text-center small">
                        {{ \Carbon\Carbon::parse($p->tanggal_peminjaman)->format('d M Y') }}
                    </td>
                    <td class="text-center small">
                        <div class="{{ $p->status_peminjaman == 'dipinjam' && now() > $p->tanggal_kembali_seharusnya ? 'text-danger fw-bold' : '' }}">
                            {{ \Carbon\Carbon::parse($p->tanggal_kembali_seharusnya)->format('d M Y') }}
                        </div>
                    </td>
                    <td class="text-center">
                        @if($p->status_peminjaman == 'dipinjam')
                            <span class="badge rounded-pill bg-warning text-dark px-3 py-2">
                                <i class="fa-solid fa-clock me-1"></i> Dipinjam
                            </span>
                        @else
                            <div class="d-flex flex-column align-items-center">
                                <span class="badge rounded-pill bg-success px-3 py-2">
                                    <i class="fa-solid fa-check-circle me-1"></i> Kembali
                                </span>
                                <small class="text-muted mt-1" style="font-size: 0.7rem;">
                                    {{ $p->tanggal_pengembalian }}
                                </small>
                            </div>
                        @endif
                    </td>
                    <td class="text-end fw-semibold">
                        @if($p->denda > 0)
                            <span class="text-danger">Rp {{ number_format($p->denda, 0, ',', '.') }}</span>
                        @else
                            <span class="text-success small">Rp 0</span>
                        @endif
                    </td>
                    <td class="pe-4 text-center">
                        @if($p->status_peminjaman == 'dipinjam')
                            <form method="POST" action="{{ route('peminjaman.kembali', $p->id) }}">
                                @csrf
                                <button class="btn btn-outline-primary btn-sm px-3 rounded-pill fw-bold"
                                        onclick="return confirm('Apakah Anda yakin ingin mengembalikan buku ini?')">
                                    Kembalikan
                                </button>
                            </form>
                        @else
                            <span class="badge bg-light text-muted fw-normal border">Selesai</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <img src="https://cdn-icons-png.flaticon.com/512/6598/6598519.png" width="60" class="mb-3 opacity-25">
                        <p class="text-muted mb-0">Riwayat peminjaman tidak ditemukan.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
    /* Styling khusus agar baris tabel lebih renggang dan nyaman */
    .table tbody tr {
        transition: background-color 0.2s;
    }
    .table thead th {
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        border-bottom: 1px solid #edf2f7;
    }
    .badge {
        font-weight: 600;
        letter-spacing: 0.02em;
    }
</style>

@endsection
