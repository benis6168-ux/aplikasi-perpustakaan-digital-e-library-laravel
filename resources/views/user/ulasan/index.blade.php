@extends('user.layout.app')

@section('content')

{{-- Header & Action --}}
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
    <div>
        <h3 class="fw-bold text-dark mb-1">Ulasan Saya</h3>
        <p class="text-muted mb-0">Bagikan pendapat Anda mengenai buku-buku yang telah Anda baca.</p>
    </div>

    <a href="{{ route('user.ulasan.create') }}" class="btn btn-primary px-4 py-2 fw-bold shadow-sm">
        <i class="fa-solid fa-plus me-2"></i> Tambah Ulasan Baru
    </a>
</div>

<div class="row">
@forelse($ulasan as $u)
    <div class="col-12 mb-3">
        <div class="card border-0 shadow-sm overflow-hidden h-100">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    {{-- Informasi Buku & Rating --}}
                    <div class="col-md-8">
                        <div class="d-flex align-items-center mb-2">
                            <div class="text-warning me-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fa-{{ $i <= $u->rating ? 'solid' : 'regular' }} fa-star"></i>
                                @endfor
                            </div>
                            <span class="badge bg-warning bg-opacity-10 text-dark fw-bold rounded-pill px-3">
                                {{ $u->rating }}.0
                            </span>
                        </div>

                        <h5 class="fw-bold text-dark mb-2">{{ $u->buku->judul }}</h5>
                        <p class="text-muted mb-0 fst-italic">
                            <i class="fa-solid fa-quote-left me-2 opacity-25"></i>
                            {{ $u->ulasan }}
                            <i class="fa-solid fa-quote-right ms-2 opacity-25"></i>
                        </p>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="col-md-4 mt-3 mt-md-0 text-md-end">
                        <div class="d-flex justify-content-md-end gap-2">
                            <a href="{{ route('user.ulasan.edit', $u->id) }}"
                               class="btn btn-outline-warning btn-sm px-3 fw-bold rounded-pill">
                                <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                            </a>

                            <form method="POST" action="{{ route('user.ulasan.delete', $u->id) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm px-3 rounded-pill fw-bold"
                                        onclick="return confirm('Hapus ulasan ini secara permanen?')">
                                    <i class="fa-solid fa-trash-can me-1"></i> Hapus
                                </button>
                            </form>
                        </div>
                        <div class="mt-2 text-md-end">
                            <small class="text-muted" style="font-size: 0.75rem;">
                                Diulas pada {{ $u->created_at->format('d M Y') ?? '' }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="col-12">
        <div class="card border-0 shadow-sm p-5 text-center">
            <div class="mb-3">
                <i class="fa-solid fa-pen-nib fs-1 text-muted opacity-25"></i>
            </div>
            <h5 class="text-muted">Anda belum pernah menulis ulasan.</h5>
            <p class="text-muted small">Ulasan Anda sangat membantu pembaca lain dalam memilih buku!</p>
            <div class="mt-3">
                <a href="{{ route('user.buku') }}" class="btn btn-light btn-sm text-primary fw-bold">
                    Cari Buku untuk Diulas
                </a>
            </div>
        </div>
    </div>
@endforelse
</div>

<style>
    /* Klasik namun Modern: Font yang lebih bersih dan spacing yang pas */
    .card {
        transition: all 0.3s ease;
        border-left: 0px solid #2563eb;
    }
    .card:hover {
        transform: translateX(5px);
        border-left: 5px solid #2563eb;
    }
    .fa-star {
        font-size: 0.85rem;
    }
    .btn-outline-warning {
        border-color: #f59e0b;
        color: #f59e0b;
    }
    .btn-outline-warning:hover {
        background-color: #f59e0b;
        color: white;
    }
</style>

@endsection
