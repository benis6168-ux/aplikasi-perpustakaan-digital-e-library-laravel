@extends('user.layout.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-xl-10"> {{-- Batasi lebar maksimal agar tidak terlalu melar --}}
        
        <div class="row g-4">
            {{-- Sisi Kiri: Foto Sampul & Form Pinjam --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm overflow-hidden mb-4">
                    <div class="bg-light" style="height: 450px;">
                        @if($buku->foto_sampul)
                            <img src="{{ asset('storage/' . $buku->foto_sampul) }}" class="w-100 h-100" style="object-fit: cover;" alt="{{ $buku->judul }}">
                        @else
                            <div class="d-flex flex-column align-items-center justify-content-center h-100 text-muted opacity-25">
                                <i class="fa-solid fa-book-open fs-1 mb-2"></i>
                                <span>No Cover</span>
                            </div>
                        @endif
                    </div>
                    <div class="card-body p-3">
                        @if($buku->stok > 0)
                            <form method="POST" action="{{ url('/user/peminjaman') }}">
                                @csrf
                                <input type="hidden" name="buku_id" value="{{ $buku->id }}">
                                <button class="btn btn-primary btn-lg w-100 fw-bold shadow-none">
                                    <i class="fa-solid fa-book-reader me-2"></i> Pinjam Buku
                                </button>
                            </form>
                        @else
                            <button class="btn btn-secondary btn-lg w-100 fw-bold border-0" disabled>
                                <i class="fa-solid fa-ban me-2"></i> Stok Habis
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Sisi Kanan: Detail Informasi --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm p-4 h-100">
                    <div class="d-flex align-items-center mb-3">
                        <a href="{{ route('user.buku') }}" class="btn btn-light btn-sm rounded-circle me-3">
                            <i class="fa-solid fa-arrow-left"></i>
                        </a>
                        <span class="text-muted small fw-bold text-uppercase tracking-wider">Informasi Lengkap</span>
                    </div>

                    <div class="mb-2">
                        @foreach($buku->kategori as $kat)
                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-10 px-3 py-2 rounded-pill me-1 mb-1" style="font-size: 0.7rem;">
                                <i class="fa-solid fa-tag me-1 small"></i> {{ $kat->nama_kategori }}
                            </span>
                        @endforeach
                    </div>

                    <h2 class="fw-bold text-dark mb-1">{{ $buku->judul }}</h2>
                    <p class="text-muted fs-5 mb-4">{{ $buku->penulis }}</p>

                    <div class="row g-3">
                        <div class="col-sm-4">
                            <div class="p-3 border rounded-3 bg-light text-center h-100">
                                <small class="text-muted d-block mb-1">Penerbit</small>
                                <span class="fw-bold text-dark small">{{ $buku->penerbit }}</span>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="p-3 border rounded-3 bg-light text-center h-100">
                                <small class="text-muted d-block mb-1">Tahun Terbit</small>
                                <span class="fw-bold text-dark small">{{ $buku->tahun_terbit }}</span>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="p-3 border rounded-3 bg-light text-center h-100">
                                <small class="text-muted d-block mb-1">Ketersediaan</small>
                                <span class="fw-bold {{ $buku->stok > 0 ? 'text-success' : 'text-danger' }} small">
                                    {{ $buku->stok }} Buku
                                </span>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4 opacity-25">
                    
                    <h5 class="fw-bold mb-3">Ulasan Pembaca</h5>
                    <div id="listUlasan" class="overflow-auto" style="max-height: 400px;">
                        @forelse($ulasan as $u)
                            <div class="border-bottom pb-3 mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="fw-bold small text-dark">{{ $u->user->username ?? 'Anonim' }}</span>
                                    <span class="text-warning small">
                                        @for($i=1; $i<=5; $i++)
                                            <i class="fa-{{ $i <= $u->rating ? 'solid' : 'regular' }} fa-star"></i>
                                        @endfor
                                    </span>
                                </div>
                                <p class="text-muted small mb-0">{{ $u->ulasan }}</p>
                            </div>
                        @empty
                            <p class="text-muted small italic">Belum ada ulasan untuk buku ini.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Form Rating di Bawah --}}
            <div class="col-12 mt-4">
                <div class="card border-0 shadow-sm p-4">
                    <h5 class="fw-bold mb-3">Berikan Penilaian Anda</h5>
                    <form id="formUlasan" method="POST" action="{{ url('/user/ulasan') }}">
                        @csrf
                        <input type="hidden" name="buku_id" value="{{ $buku->id }}">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <select name="rating" class="form-select border-0 bg-light rounded-3" required>
                                    <option value="5">⭐⭐⭐⭐⭐</option>
                                    <option value="4">⭐⭐⭐⭐</option>
                                    <option value="3">⭐⭐⭐</option>
                                    <option value="2">⭐⭐</option>
                                    <option value="1">⭐</option>
                                </select>
                            </div>
                            <div class="col-md-7">
                                <input type="text" name="ulasan" class="form-control border-0 bg-light rounded-3" placeholder="Tulis ulasan singkat..." required>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-dark w-100 fw-bold rounded-3">Kirim</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .tracking-wider { letter-spacing: 1px; }
    #listUlasan::-webkit-scrollbar { width: 4px; }
    #listUlasan::-webkit-scrollbar-thumb { background: #ddd; border-radius: 10px; }
</style>

@endsection