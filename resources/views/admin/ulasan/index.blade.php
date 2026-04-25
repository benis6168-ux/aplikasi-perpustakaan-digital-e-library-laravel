@extends('admin.layout.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-1">Ulasan Pengguna</h3>
        <p class="text-muted small mb-0">Moderasi ulasan untuk menjaga kualitas konten koleksi buku.</p>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 py-3 mt-2">
        <div class="row justify-content-end">
            <div class="col-md-4">
                <form method="GET" action="{{ route('admin.ulasan') }}">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i class="fa-solid fa-magnifying-glass text-muted small"></i></span>
                        <input type="text" name="search" class="form-control bg-light border-0 shadow-none"
                               placeholder="Cari user, buku, atau isi ulasan..." value="{{ request('search') }}">
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
                    <th class="ps-4 py-3 border-0" width="180">PENGGUNA</th>
                    <th class="py-3 border-0" width="200">BUKU</th>
                    <th class="py-3 border-0 text-center" width="100">RATING</th>
                    <th class="py-3 border-0">ULASAN</th>
                    <th class="py-3 border-0 text-end pe-4" width="100">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ulasan as $u)
                    <tr>
                        <td class="ps-4 py-3 border-bottom border-light">
                            <div class="d-flex align-items-center">
                                <div class="bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; font-size: 12px;">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                                <span class="fw-semibold text-dark">{{ $u->user->username ?? '-' }}</span>
                            </div>
                        </td>
                        <td class="py-3 border-bottom border-light">
                            <span class="text-dark fw-medium">{{ $u->buku->judul ?? '-' }}</span>
                        </td>
                        <td class="py-3 border-bottom border-light text-center">
                            <div class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 rounded-pill px-3">
                                <i class="fa-solid fa-star me-1 small"></i>{{ $u->rating }}
                            </div>
                        </td>
                        <td class="py-3 border-bottom border-light">
                            <p class="mb-0 text-muted small" style="line-height: 1.6;">
                                <i class="fa-solid fa-quote-left me-1 opacity-25"></i>
                                {{ $u->ulasan }}
                                <i class="fa-solid fa-quote-right ms-1 opacity-25"></i>
                            </p>
                        </td>
                        <td class="py-3 border-bottom border-light text-end pe-4">
                            {{-- Hanya Tombol Hapus --}}
                            <form method="POST" action="{{ route('admin.ulasan.destroy', $u->id) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm border-0 px-2 py-1" 
                                        onclick="return confirm('Hapus ulasan ini secara permanen?')">
                                    <i class="fa-solid fa-trash-can me-1"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="text-muted opacity-50 mb-3">
                                <i class="fa-solid fa-comment-slash fs-1"></i>
                            </div>
                            <p class="mb-0">Belum ada ulasan yang tersedia.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection