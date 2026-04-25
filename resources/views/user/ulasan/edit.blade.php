@extends('user.layout.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-7">
        {{-- Breadcrumb / Back Link --}}
        <div class="mb-3">
            <a href="{{ route('user.ulasan.index') }}" class="text-decoration-none text-muted small fw-bold">
                <i class="fa-solid fa-chevron-left me-1"></i> KEMBALI KE DAFTAR ULASAN
            </a>
        </div>

        <div class="card border-0 shadow-sm overflow-hidden">
            {{-- Header Card --}}
            <div class="card-header py-4 text-center" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                <h4 class="text-white fw-bold mb-0">Edit Ulasan Anda</h4>
                <p class="text-white-50 small mb-0">Sesuaikan kembali penilaian Anda untuk buku ini</p>
            </div>

            <div class="card-body p-4 p-md-5">
                <form method="POST" action="{{ route('user.ulasan.update', $ulasan->id) }}">
                    @csrf
                    @method('PUT')

                    {{-- Info Buku (Hanya muncul yang pernah dipinjam) --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark">Buku yang Diulas</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-book-open text-warning"></i></span>
                            <select name="buku_id" class="form-select bg-light border-0 py-2 shadow-none" required>
                                @foreach($buku as $b)
                                    <option value="{{ $b->id }}" {{ $ulasan->buku_id == $b->id ? 'selected' : '' }}>
                                        {{ $b->judul }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <small class="text-muted mt-2 d-block">
                            <i class="fa-solid fa-info-circle me-1"></i> Anda mengedit ulasan untuk koleksi buku yang telah Anda baca.
                        </small>
                    </div>

                    {{-- Rating --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark d-block">Rating</label>
                        <select name="rating" class="form-select bg-light border-0 py-2 shadow-none" required style="max-width: 220px;">
                            <option value="5" {{ $ulasan->rating == 5 ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (5 - Sempurna)</option>
                            <option value="4" {{ $ulasan->rating == 4 ? 'selected' : '' }}>⭐⭐⭐⭐ (4 - Bagus)</option>
                            <option value="3" {{ $ulasan->rating == 3 ? 'selected' : '' }}>⭐⭐⭐ (3 - Cukup)</option>
                            <option value="2" {{ $ulasan->rating == 2 ? 'selected' : '' }}>⭐⭐ (2 - Kurang)</option>
                            <option value="1" {{ $ulasan->rating == 1 ? 'selected' : '' }}>⭐ (1 - Buruk)</option>
                        </select>
                    </div>

                    {{-- Textarea Ulasan --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark">Ulasan Anda</label>
                        <textarea name="ulasan" 
                                  class="form-control bg-light border-0 shadow-none" 
                                  rows="6" 
                                  required>{{ $ulasan->ulasan }}</textarea>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="row g-2">
                        <div class="col-md-8">
                            <button type="submit" class="btn btn-warning w-100 fw-bold py-3 text-white shadow-sm">
                                <i class="fa-solid fa-rotate me-2"></i> Simpan Perubahan
                            </button>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('user.ulasan.index') }}" class="btn btn-light w-100 fw-bold py-3 border">
                                Batal
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .form-select:focus, .form-control:focus {
        background-color: #fff !important;
        border: 1px solid #f59e0b !important;
        box-shadow: 0 0 0 0.25rem rgba(245, 158, 11, 0.1) !important;
    }
</style>

@endsection