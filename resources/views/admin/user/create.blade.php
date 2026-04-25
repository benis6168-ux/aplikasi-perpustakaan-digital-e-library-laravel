@extends('admin.layout.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">

        {{-- Header Halaman --}}
        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('admin.user.index') }}" class="btn btn-light border shadow-sm rounded-circle me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                <i class="fa-solid fa-arrow-left text-muted"></i>
            </a>
            <div>
                <h3 class="fw-bold text-dark mb-0">Tambah User Baru</h3>
                <p class="text-muted small mb-0">Dafrarkan anggota atau administrator baru ke dalam sistem.</p>
            </div>
        </div>

        {{-- Error Feedback --}}
        @if ($errors->any())
            <div class="alert alert-danger border-0 shadow-sm mb-4">
                <div class="d-flex">
                    <i class="fa-solid fa-circle-exclamation fs-5 me-3"></i>
                    <ul class="mb-0 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        {{-- Form Card --}}
        <div class="card border-0 shadow-sm p-4">
            <form method="POST" action="{{ route('admin.user.store') }}">
                @csrf

                <div class="row">
                    {{-- Username --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Username</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-at text-muted small"></i></span>
                            <input type="text" name="username" value="{{ old('username') }}"
                                   class="form-control bg-light border-0 shadow-none"
                                   placeholder="Contoh: budi_perpus" required>
                        </div>
                    </div>

                    {{-- Nama Lengkap --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Nama Lengkap</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-id-card text-muted small"></i></span>
                            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}"
                                   class="form-control bg-light border-0 shadow-none"
                                   placeholder="Nama sesuai identitas" required>
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Alamat Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-envelope text-muted small"></i></span>
                            <input type="email" name="email" value="{{ old('email') }}"
                                   class="form-control bg-light border-0 shadow-none"
                                   placeholder="nama@email.com" required>
                        </div>
                    </div>

                    {{-- Password --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-key text-muted small"></i></span>
                            <input type="password" name="password"
                                   class="form-control bg-light border-0 shadow-none"
                                   placeholder="Minimal 8 karakter" required>
                        </div>
                    </div>

                    {{-- Role --}}
                    <div class="col-md-12 mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Hak Akses (Role)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-user-shield text-muted small"></i></span>
                            <select name="role" class="form-select bg-light border-0 shadow-none" required>
                                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User (Anggota Biasa)</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator (Akses Penuh)</option>
                            </select>
                        </div>
                    </div>

                    {{-- Alamat --}}
                    <div class="col-12 mb-4">
                        <label class="form-label small fw-bold text-muted text-uppercase">Alamat Lengkap</label>
                        <textarea name="alamat" rows="3"
                                  class="form-control bg-light border-0 shadow-none"
                                  placeholder="Jl. Nama Jalan No. XX, Kota...">{{ old('alamat') }}</textarea>
                    </div>
                </div>

                <hr class="text-muted opacity-25">

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('admin.user.index') }}" class="btn btn-light px-4 fw-semibold text-muted">Batal</a>
                    <button type="submit" class="btn btn-success px-4 fw-semibold">
                        <i class="fa-solid fa-user-plus me-2"></i> Daftarkan User
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>

@endsection
