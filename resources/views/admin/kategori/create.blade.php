@extends('admin.layout.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">

        {{-- Header Halaman --}}
        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('admin.kategori.index') }}" class="btn btn-light border shadow-sm rounded-circle me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                <i class="fa-solid fa-arrow-left text-muted"></i>
            </a>
            <div>
                <h3 class="fw-bold text-dark mb-0">Tambah Kategori</h3>
                <p class="text-muted small mb-0">Buat label kategori baru untuk klasifikasi koleksi buku.</p>
            </div>
        </div>

        {{-- Form Card --}}
        <div class="card border-0 shadow-sm p-4">
            <form method="POST" action="{{ route('admin.kategori.store') }}">
                @csrf

                <div class="mb-4">
                    <label class="form-label small fw-bold text-muted text-uppercase">Nama Kategori</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0">
                            <i class="fa-solid fa-tag text-muted small"></i>
                        </span>
                        <input type="text" name="nama_kategori"
                               class="form-control bg-light border-0 shadow-none @error('nama_kategori') is-invalid @enderror"
                               placeholder="Contoh: Fiksi, Sains, Sejarah..."
                               value="{{ old('nama_kategori') }}"
                               required autofocus>
                        @error('nama_kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary py-2 fw-semibold">
                        <i class="fa-solid fa-floppy-disk me-2"></i> Simpan Kategori
                    </button>
                    <a href="{{ route('admin.kategori.index') }}" class="btn btn-light py-2 fw-semibold text-muted">
                        Batal
                    </a>
                </div>
            </form>
        </div>

        {{-- Tips --}}
        <div class="alert alert-light border-0 shadow-sm mt-4 p-3">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-circle-info text-primary me-3 fs-5"></i>
                <p class="mb-0 small text-muted">
                    Pastikan nama kategori belum terdaftar sebelumnya untuk menghindari duplikasi data.
                </p>
            </div>
        </div>

    </div>
</div>

@endsection
