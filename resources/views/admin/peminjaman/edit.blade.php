@extends('admin.layout.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('admin.peminjaman') }}" class="btn btn-light border shadow-sm rounded-circle me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                <i class="fa-solid fa-arrow-left text-muted"></i>
            </a>
            <div>
                <h3 class="fw-bold text-dark mb-0">Edit Transaksi Peminjaman</h3>
                <p class="text-muted small mb-0">Sesuaikan data peminjam, koleksi, atau perpanjang masa pinjam.</p>
            </div>
        </div>

        <div class="card border-0 shadow-sm p-4">
            <form method="POST" action="{{ route('admin.peminjaman.update', $peminjaman->id) }}">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Nama Peminjam</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-user text-muted small"></i></span>
                            <select name="user_id" class="form-select bg-light border-0 shadow-none">
                                @foreach($users as $u)
                                    <option value="{{ $u->id }}" {{ $peminjaman->user_id == $u->id ? 'selected' : '' }}>
                                        {{ $u->username }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Buku yang Dipinjam</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-book text-muted small"></i></span>
                            <select name="buku_id" class="form-select bg-light border-0 shadow-none">
                                @foreach($buku as $b)
                                    <option value="{{ $b->id }}" {{ $peminjaman->buku_id == $b->id ? 'selected' : '' }}>
                                        {{ $b->judul }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Tanggal Peminjaman</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-calendar-plus text-muted small"></i></span>
                            <input type="date" name="tanggal_peminjaman" value="{{ $peminjaman->tanggal_peminjaman }}"
                                   class="form-control bg-light border-0 shadow-none">
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label small fw-bold text-muted text-uppercase">Tanggal Jatuh Tempo</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-calendar-check text-muted small"></i></span>
                            <input type="date" name="tanggal_kembali_seharusnya" value="{{ $peminjaman->tanggal_kembali_seharusnya }}"
                                   class="form-control bg-light border-0 shadow-none">
                        </div>
                    </div>
                </div>

                <hr class="text-muted opacity-25">

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('admin.peminjaman') }}" class="btn btn-light px-4 fw-semibold text-muted">Batal</a>
                    <button type="submit" class="btn btn-primary px-4 fw-semibold">
                        <i class="fa-solid fa-arrows-rotate me-2"></i> Perbarui Transaksi
                    </button>
                </div>
            </form>
        </div>

        <div class="alert alert-warning border-0 shadow-sm mt-4 d-flex align-items-center">
            <i class="fa-solid fa-triangle-exclamation fs-4 me-3 text-warning"></i>
            <p class="mb-0 small text-dark">
                Perubahan <strong>Tanggal Jatuh Tempo</strong> akan mempengaruhi kalkulasi denda jika transaksi belum diselesaikan.
            </p>
        </div>

    </div>
</div>

@endsection
