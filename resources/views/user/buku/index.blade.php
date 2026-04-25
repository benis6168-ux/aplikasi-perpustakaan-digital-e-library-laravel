@extends('user.layout.app')

@section('content')

{{-- Header Halaman --}}
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
    <div>
        <h4 class="fw-bold text-dark mb-1">Koleksi Perpustakaan</h4>
        <p class="text-muted small mb-0">Temukan buku favorit Anda di sini.</p>
    </div>

    {{-- SEARCH & FILTER BAR --}}
    <form method="GET" action="{{ route('user.buku') }}" class="d-flex gap-2 align-items-center">
        {{-- Dropdown Kategori --}}
        <select name="kategori_id" class="form-select form-select-sm border shadow-sm" style="width: 160px; height: 38px; border-radius: 20px;" onchange="this.form.submit()">
            <option value="">Semua Kategori</option>
            @foreach($kategoriList as $kat)
                <option value="{{ $kat->id }}" {{ request('kategori_id') == $kat->id ? 'selected' : '' }}>
                    {{ $kat->nama_kategori }}
                </option>
            @endforeach
        </select>

        {{-- Input Search --}}
        <div class="input-group input-group-sm shadow-sm border rounded-pill overflow-hidden bg-white" style="width: 250px;">
            <input type="text" name="search" class="form-control border-0 ps-3" placeholder="Cari buku..." value="{{ request('search') }}" style="height: 38px;">
            <button class="btn btn-primary px-3 border-0" type="submit">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </div>
    </form>
</div>

<div class="row g-3">

@forelse($buku as $b)
<div class="col-xl-4 col-md-6">
    <div class="card h-100 border-0 shadow-sm transition-hover">
        <div class="row g-0 h-100">
            {{-- Bagian Gambar (Samping) --}}
            <div class="col-4 bg-light d-flex align-items-center justify-content-center overflow-hidden" style="min-height: 180px;">
                @if($b->foto_sampul)
                    <img src="{{ asset('storage/' . $b->foto_sampul) }}" class="w-100 h-100" style="object-fit: cover;" alt="{{ $b->judul }}">
                @else
                    <i class="fa-solid fa-book fs-2 text-muted opacity-25"></i>
                @endif
            </div>

            {{-- Bagian Konten --}}
            <div class="col-8">
                <div class="card-body p-3 d-flex flex-column h-100">
                    <div class="mb-1">
                        @foreach($b->kategori->take(2) as $kat) {{-- Batasi 2 kategori agar tidak penuh --}}
                            <span class="text-primary fw-bold" style="font-size: 0.65rem;">#{{ strtoupper($kat->nama_kategori) }}</span>
                        @endforeach
                    </div>

                    <h6 class="fw-bold mb-1 text-truncate" title="{{ $b->judul }}">
                        <a href="{{ route('user.buku.detail', $b->id) }}" class="text-decoration-none text-dark hover-primary">
                            {{ $b->judul }}
                        </a>
                    </h6>
                    
                    <p class="text-muted mb-2" style="font-size: 0.75rem;">
                        <i class="fa-solid fa-user-pen me-1"></i> {{ $b->penulis }}
                    </p>

                    <div class="mb-3 mt-auto border-top pt-2" style="font-size: 0.7rem;">
                        <div class="d-flex justify-content-between text-muted">
                            <span>Stok: <strong class="{{ $b->stok > 0 ? 'text-success' : 'text-danger' }}">{{ $b->stok }}</strong></span>
                            <span>{{ $b->penerbit }}</span>
                        </div>
                    </div>

                    @if($b->stok > 0)
                    <form method="POST" action="{{ url('/user/peminjaman') }}">
                        @csrf
                        <input type="hidden" name="buku_id" value="{{ $b->id }}">
                        <button class="btn btn-primary btn-sm w-100 fw-bold shadow-none">
                            Pinjam
                        </button>
                    </form>
                    @else
                    <button class="btn btn-light btn-sm w-100 fw-bold text-muted border" disabled>
                        Habis
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@empty
<div class="col-12 text-center py-5">
    <p class="text-muted small">Buku tidak ditemukan.</p>
</div>
@endforelse

</div>

<style>
    .transition-hover {
        transition: transform 0.2s ease;
    }
    .transition-hover:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.08) !important;
    }
    .hover-primary:hover {
        color: #0d6efd !important;
    }
</style>

@endsection