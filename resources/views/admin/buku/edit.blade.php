@extends('admin.layout.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('admin.buku.index') }}" class="btn btn-light border shadow-sm rounded-circle me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                <i class="fa-solid fa-arrow-left text-muted"></i>
            </a>
            <div>
                <h3 class="fw-bold text-dark mb-0">Edit Informasi Buku</h3>
                <p class="text-muted small mb-0">Perbarui detail katalog, stok, dan metadata buku.</p>
            </div>
        </div>

        <div class="card border-0 shadow-sm p-4">
            <form method="POST" action="{{ route('admin.buku.update', $buku->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-12 mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Judul Buku</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-book text-muted small"></i></span>
                            <input type="text" name="judul" value="{{ $buku->judul }}"
                                   class="form-control bg-light border-0 shadow-none"
                                   placeholder="Masukkan judul lengkap" required>
                        </div>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Sampul Buku</label>
                        <div class="d-flex gap-3 align-items-start">
                            <div class="mb-2">
                                @if($buku->foto_sampul)
                                    <img src="{{ asset('storage/' . $buku->foto_sampul) }}" 
                                         alt="Sampul Sekarang" 
                                         class="rounded border shadow-sm" 
                                         style="width: 80px; height: 110px; object-fit: cover;">
                                    <div class="small text-muted text-center mt-1">Lama</div>
                                @else
                                    <div class="bg-light rounded border d-flex align-items-center justify-content-center" style="width: 80px; height: 110px;">
                                        <i class="fa-solid fa-image text-muted opacity-25 fs-2"></i>
                                    </div>
                                @endif
                            </div>

                            <div class="flex-grow-1">
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="fa-solid fa-upload text-muted small"></i></span>
                                    <input type="file" name="foto_sampul" class="form-control bg-light border-0 shadow-none @error('foto_sampul') is-invalid @enderror" accept="image/*">
                                </div>
                                <div class="form-text small text-muted mt-1">Pilih file baru jika ingin mengganti sampul. (Maks 2MB)</div>
                                @error('foto_sampul')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
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
                                               {{ $buku->kategori->contains($k->id) ? 'checked' : '' }}>
                                        <label class="form-check-label small text-dark" for="kategori{{ $k->id }}">
                                            {{ $k->nama_kategori }}
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-text small text-muted mt-1">Anda dapat memilih lebih dari satu kategori.</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Penulis / Pengarang</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-user-pen text-muted small"></i></span>
                            <input type="text" name="penulis" value="{{ $buku->penulis }}"
                                   class="form-control bg-light border-0 shadow-none"
                                   placeholder="Nama penulis" required>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Penerbit</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-building-columns text-muted small"></i></span>
                            <input type="text" name="penerbit" value="{{ $buku->penerbit }}"
                                   class="form-control bg-light border-0 shadow-none"
                                   placeholder="Nama perusahaan penerbit" required>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Tahun Terbit</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-calendar-days text-muted small"></i></span>
                            <input type="number" name="tahun_terbit" value="{{ $buku->tahun_terbit }}"
                                   class="form-control bg-light border-0 shadow-none"
                                   placeholder="Contoh: 2024" required>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label small fw-bold text-muted text-uppercase">Jumlah Stok</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-boxes-stacked text-muted small"></i></span>
                            <input type="number" name="stok" value="{{ $buku->stok }}"
                                   class="form-control bg-light border-0 shadow-none"
                                   placeholder="Jumlah buku tersedia" required>
                        </div>
                    </div>
                </div>

                <hr class="text-muted opacity-25">

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('admin.buku.index') }}" class="btn btn-light px-4 fw-semibold text-muted">Batal</a>
                    <button type="submit" class="btn btn-primary px-4 fw-semibold">
                        <i class="fa-solid fa-arrows-rotate me-2"></i> Perbarui Data
                    </button>
                </div>

            </form>
        </div>

        <div class="mt-4 p-3 bg-light rounded-3 border">
             <div class="d-flex">
                <i class="fa-solid fa-lightbulb text-warning me-3 mt-1"></i>
                <div class="small text-muted">
                    Pastikan kategori yang dipilih sesuai dengan isi buku agar memudahkan pencarian oleh pembaca.
                </div>
             </div>
        </div>

    </div>
</div>

@endsection