@extends('admin.layout.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">

        {{-- Header Halaman --}}
        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('admin.peminjaman') }}" class="btn btn-light border shadow-sm rounded-circle me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                <i class="fa-solid fa-arrow-left text-muted"></i>
            </a>
            <div>
                <h3 class="fw-bold text-dark mb-0">Tambah Peminjaman</h3>
                <p class="text-muted small mb-0">Catat transaksi peminjaman buku baru oleh anggota.</p>
            </div>
        </div>

        {{-- Form Card --}}
        <div class="card border-0 shadow-sm p-4">
            <form method="POST" action="{{ route('admin.peminjaman.store') }}">
                @csrf

                <div class="row">
                    {{-- Pilih User --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Pilih Anggota</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-user-tag text-muted small"></i></span>
                            <select name="user_id" class="form-select bg-light border-0 shadow-none" required>
                                <option value="" hidden>-- Pilih User --</option>
                                @foreach($users as $u)
                                    <option value="{{ $u->id }}">{{ $u->username }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Pilih Buku --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Pilih Koleksi Buku</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-book-bookmark text-muted small"></i></span>
                            <select name="buku_id" class="form-select bg-light border-0 shadow-none" required>
                                <option value="" hidden>-- Pilih Buku --</option>
                                @foreach($buku as $b)
                                    <option value="{{ $b->id }}" {{ $b->stok <= 0 ? 'disabled' : '' }}>
                                        {{ $b->judul }} (Stok: {{ $b->stok }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Tanggal Pinjam --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Tanggal Peminjaman</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-calendar-day text-muted small"></i></span>
                            <input type="date" name="tanggal_peminjaman"
                                   value="{{ date('Y-m-d') }}"
                                   class="form-control bg-light border-0 shadow-none" required>
                        </div>
                    </div>

                    {{-- Jatuh Tempo --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Tanggal Jatuh Tempo</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-clock-rotate-left text-muted small"></i></span>
                            <input type="date" name="tanggal_kembali_seharusnya"
                                   value="{{ date('Y-m-d', strtotime('+7 days')) }}"
                                   class="form-control bg-light border-0 shadow-none" required>
                        </div>
                        <div class="form-text mt-1" style="font-size: 11px;">Default: Durasi pinjam 7 hari.</div>
                    </div>

                    {{-- Status --}}
                    <div class="col-12 mb-4">
                        <label class="form-label small fw-bold text-muted text-uppercase">Status Awal</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-circle-info text-muted small"></i></span>
                            <select name="status_peminjaman" class="form-select bg-light border-0 shadow-none">
                                <option value="dipinjam" selected>Dipinjam</option>
                                <option value="dikembalikan">Dikembalikan</option>
                            </select>
                        </div>
                    </div>
                </div>

                <hr class="text-muted opacity-25">

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('admin.peminjaman') }}" class="btn btn-light px-4 fw-semibold text-muted">Batal</a>
                    <button type="submit" class="btn btn-success px-4 fw-semibold shadow-sm">
                        <i class="fa-solid fa-save me-2"></i> Simpan Transaksi
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

@endsection
