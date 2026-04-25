@extends('user.layout.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-7">
        {{-- Tombol Kembali --}}
        <div class="mb-3">
            <a href="{{ route('user.ulasan.index') }}" class="text-decoration-none text-muted small fw-bold">
                <i class="fa-solid fa-arrow-left me-1"></i> KEMBALI KE ULASAN SAYA
            </a>
        </div>

        <div class="card border-0 shadow-sm overflow-hidden">
            {{-- Header Card --}}
            <div class="card-header bg-primary py-4 text-center">
                <h4 class="text-white fw-bold mb-0">Bagikan Pengalaman Anda</h4>
                <p class="text-white-50 small mb-0">Hanya buku yang pernah Anda pinjam yang dapat diulas</p>
            </div>

            <div class="card-body p-4 p-md-5">
                <form method="POST" action="{{ route('user.ulasan.store') }}">
                    @csrf

                    {{-- Pilih Buku --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark">Pilih Buku yang Telah Dibaca</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-book text-muted"></i></span>
                            <select name="buku_id" class="form-select bg-light border-0 py-2 shadow-none" required>
                                @if($buku->isEmpty())
                                    <option value="" selected disabled>Anda belum meminjam buku apapun...</option>
                                @else
                                    <option value="" selected disabled>Pilih buku yang pernah Anda pinjam...</option>
                                    @foreach($buku as $b)
                                        <option value="{{ $b->id }}">{{ $b->judul }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        @if($buku->isEmpty())
                            <div class="mt-2 p-2 bg-danger bg-opacity-10 rounded">
                                <small class="text-danger fw-medium">
                                    <i class="fa-solid fa-circle-exclamation me-1"></i> 
                                    Maaf, Anda belum memiliki riwayat peminjaman untuk diulas.
                                </small>
                            </div>
                        @endif
                    </div>

                    {{-- Rating --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark d-block">Berikan Rating</label>
                        <div class="rating-select d-flex gap-2">
                            <select name="rating" class="form-select bg-light border-0 py-2 shadow-none" required style="max-width: 200px;">
                                <option value="5">⭐⭐⭐⭐⭐ (5 - Sempurna)</option>
                                <option value="4">⭐⭐⭐⭐ (4 - Bagus)</option>
                                <option value="3">⭐⭐⭐ (3 - Cukup)</option>
                                <option value="2">⭐⭐ (2 - Kurang)</option>
                                <option value="1">⭐ (1 - Buruk)</option>
                            </select>
                        </div>
                    </div>

                    {{-- Textarea Ulasan --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark">Tulis Ulasan Anda</label>
                        <textarea name="ulasan" 
                                  class="form-control bg-light border-0 shadow-none" 
                                  rows="5" 
                                  placeholder="Bagaimana pendapat Anda tentang buku ini?"
                                  required></textarea>
                    </div>

                    {{-- Action Button --}}
                    <div class="d-grid mt-2">
                        <button type="submit" class="btn btn-primary btn-lg fw-bold py-3 shadow-sm" {{ $buku->isEmpty() ? 'disabled' : '' }}>
                            <i class="fa-solid fa-paper-plane me-2"></i> Publikasikan Ulasan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .card-header { background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%); }
    .form-select:focus, .form-control:focus {
        background-color: #fff !important;
        border: 1px solid #2563eb !important;
        box-shadow: 0 0 0 0.25rem rgba(37, 99, 235, 0.1) !important;
    }
</style>

@endsection