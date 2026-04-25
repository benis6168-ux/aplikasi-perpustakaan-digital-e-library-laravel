@extends('admin.layout.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">

        {{-- Header Halaman --}}
        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('admin.buku.index') }}" class="btn btn-light border shadow-sm rounded-circle me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                <i class="fa-solid fa-arrow-left text-muted"></i>
            </a>
            <div>
                <h3 class="fw-bold text-dark mb-0">Tambah Koleksi Buku</h3>
                <p class="text-muted small mb-0">Input data buku baru ke dalam katalog perpustakaan digital.</p>
            </div>
        </div>

        {{-- Error Feedback --}}
        @if ($errors->any())
            <div class="alert alert-danger border-0 shadow-sm mb-4">
                <div class="d-flex align-items-center">
                    <i class="fa-solid fa-circle-exclamation fs-5 me-3"></i>
                    <ul class="mb-0 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="card border-0 shadow-sm p-4">
           <form method="POST" action="{{ route('admin.buku.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-12 mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Judul Lengkap</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-book text-muted small"></i></span>
                            <input type="text" name="judul" value="{{ old('judul') }}"
                                   class="form-control bg-light border-0 shadow-none"
                                   placeholder="Judul Lengkap" required>
                        </div>
                    </div>

                    {{-- BAGIAN KATEGORI BUKU --}}
                    <div class="col-12 mb-4">
                        <label class="form-label small fw-bold text-muted text-uppercase">Kategori Buku</label>
                        <div class="p-3 bg-light rounded border shadow-sm" style="max-height: 150px; overflow-y: auto;">
                            <div class="row">
                                @foreach($kategori as $k)
                                <div class="col-md-4 col-6 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="kategori[]" 
                                               value="{{ $k->id }}" id="kategori{{ $k->id }}"
                                               {{ (is_array(old('kategori')) && in_array($k->id, old('kategori'))) ? 'checked' : '' }}>
                                        <label class="form-check-label small text-dark" for="kategori{{ $k->id }}">
                                            {{ $k->nama_kategori }}
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-text small text-muted mt-1">Anda dapat memilih satu atau lebih kategori.</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Penulis</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-user-pen text-muted small"></i></span>
                            <input type="text" name="penulis" value="{{ old('penulis') }}"
                                   class="form-control bg-light border-0 shadow-none"
                                   placeholder="Nama penulis" required>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Penerbit</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-building-columns text-muted small"></i></span>
                            <input type="text" name="penerbit" value="{{ old('penerbit') }}"
                                   class="form-control bg-light border-0 shadow-none"
                                   placeholder="Nama penerbit" required>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Tahun Terbit</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-calendar-check text-muted small"></i></span>
                            <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit') }}"
                                   class="form-control bg-light border-0 shadow-none"
                                   placeholder="YYYY" required>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label small fw-bold text-muted text-uppercase">Jumlah Stok Awal</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-cubes text-muted small"></i></span>
                            <input type="number" name="stok" value="{{ old('stok') }}"
                                   class="form-control bg-light border-0 shadow-none"
                                   placeholder="0" required>
                        </div>
                    </div>

                    <div class="col-12 mb-4">
                        <label class="form-label small fw-bold text-muted text-uppercase">Cover Buku</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-image text-muted small"></i></span>
                            <input type="file" name="foto_sampul"
                                   class="form-control bg-light border-0 shadow-none"
                                   accept="image/*">
                        </div>
                        <div class="form-text mt-1 text-muted small">Format: JPG, PNG, atau JPEG. Maksimal 2MB.</div>
                    </div>
                </div>

                <hr class="text-muted opacity-25">

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('admin.buku.index') }}" class="btn btn-light px-4 fw-semibold text-muted">Batal</a>
                    <button type="submit" class="btn btn-success px-4 fw-semibold shadow-sm">
                        <i class="fa-solid fa-circle-plus me-2"></i> Simpan Buku
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>

@endsection