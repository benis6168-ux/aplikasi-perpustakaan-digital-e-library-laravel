@extends('user.layout.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-8">

        <div class="mb-4">
            <h3 class="fw-bold text-dark"><i class="fa-solid fa-user-gear me-2 text-primary"></i>Pengaturan Profil</h3>
            <p class="text-muted">Perbarui informasi akun Anda untuk memastikan data tetap akurat.</p>
        </div>
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm d-flex align-items-center mb-4" role="alert">
                <i class="fa-solid fa-circle-check me-3 fs-4"></i>
                <div>
                    <strong>Berhasil!</strong> {{ session('success') }}
                </div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="card-body p-4 p-md-5">
                <form method="POST" action="{{ route('user.profile.update') }}">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold small text-muted text-uppercase">Username</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="fa-solid fa-lock text-muted"></i></span>
                                <input type="text" name="username" class="form-control bg-light border-0 py-2 shadow-none"
                                       value="{{ $user->username }}" readonly style="cursor: not-allowed;">
                            </div>
                            <small class="text-muted mt-1 d-block" style="font-size: 0.7rem;">Username tidak dapat diubah.</small>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold small text-muted text-uppercase">Alamat Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-envelope text-primary"></i></span>
                                <input type="email" name="email" class="form-control border-start-0 py-2 shadow-none"
                                       value="{{ $user->email }}" required>
                            </div>
                        </div>

                        <div class="col-12 mb-4">
                            <label class="form-label fw-bold small text-muted text-uppercase">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-id-card text-primary"></i></span>
                                <input type="text" name="nama_lengkap" class="form-control border-start-0 py-2 shadow-none"
                                       value="{{ $user->nama_lengkap }}" required>
                            </div>
                        </div>

                        <div class="col-12 mb-4">
                            <label class="form-label fw-bold small text-muted text-uppercase">Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control bg-white py-3 shadow-none" rows="4"
                                      placeholder="Masukkan alamat lengkap Anda...">{{ $user->alamat }}</textarea>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold small text-muted text-uppercase">Password Lama</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fa-solid fa-lock text-primary"></i>
                                </span>
                                <input type="password" name="current_password" class="form-control border-start-0 py-2 shadow-none"
                                    placeholder="Masukkan password lama">
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold small text-muted text-uppercase">Password Baru</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fa-solid fa-key text-primary"></i>
                                </span>
                                <input type="password" name="new_password" class="form-control border-start-0 py-2 shadow-none"
                                    placeholder="Masukkan password baru">
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold small text-muted text-uppercase">Konfirmasi Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fa-solid fa-check text-primary"></i>
                                </span>
                                <input type="password" name="new_password_confirmation" class="form-control border-start-0 py-2 shadow-none"
                                    placeholder="Ulangi password baru">
                            </div>
                        </div>
                    </div>

                    <hr class="my-4 opacity-25">

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4 py-2 fw-bold shadow-sm">
                            <i class="fa-solid fa-floppy-disk me-2"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('user.profile') }}" class="btn btn-light px-4 py-2 fw-bold border">
                            Batal
                        </a>
                    </div>

                </form>
            </div>
        </div>

        <div class="mt-4 p-3 rounded-3 border-0 bg-light d-flex align-items-center">
            <i class="fa-solid fa-shield-halved text-secondary me-3 fs-4"></i>
            <span class="small text-muted">Data pribadi Anda dilindungi dan hanya digunakan untuk keperluan layanan perpustakaan.</span>
        </div>
    </div>
</div>

<style>
    .form-control:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 0.25rem rgba(37, 99, 235, 0.1);
    }

    .input-group-text {
        transition: all 0.2s ease;
    }

    .form-control:focus + .input-group-text,
    .input-group:focus-within .input-group-text {
        border-color: #2563eb;
        color: #2563eb !important;
    }

    .form-label {
        letter-spacing: 0.05em;
    }
</style>

@endsection
