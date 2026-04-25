@extends('user.layout.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-10">
        {{-- Header Profil --}}
        <div class="mb-4">
            <h3 class="fw-bold text-dark">Profil Saya</h3>
            <p class="text-muted">Kelola informasi pribadi Anda untuk keamanan dan kenyamanan layanan.</p>
        </div>

        <div class="row g-4">
            {{-- Kartu Identitas Singkat --}}
            <div class="col-md-4">
                <div class="card border-0 shadow-sm text-center p-4 h-100">
                    <div class="mb-3">
                        <div class="d-inline-block p-1 rounded-circle bg-primary bg-opacity-10 mb-3">
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 100px; height: 100px;">
                                <i class="fa-solid fa-user-tie text-white fs-1"></i>
                            </div>
                        </div>
                        <h5 class="fw-bold mb-0 text-dark">{{ $user->nama_lengkap }}</h5>
                        <p class="text-muted small">Member Perpustakaan</p>
                    </div>

                    <hr class="my-4 opacity-25">

                    <div class="text-start">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fa-solid fa-calendar-check text-primary me-3"></i>
                            <div>
                                <small class="text-muted d-block">Terdaftar Sejak</small>
                                <span class="fw-semibold small text-dark">{{ $user->created_at->format('d M Y') ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-auto">
                        <a href="{{ route('user.profile.edit') }}" class="btn btn-outline-primary w-100 fw-bold">
                            <i class="fa-solid fa-user-pen me-2"></i>Edit Profil
                        </a>
                    </div>
                </div>
            </div>

            {{-- Detail Informasi --}}
            <div class="col-md-8">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3 border-bottom-0">
                        <h6 class="fw-bold mb-0"><i class="fa-solid fa-id-card me-2 text-primary"></i>Informasi Akun</h6>
                    </div>
                    <div class="card-body p-4 pt-0">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label small fw-bold text-muted text-uppercase">Username</label>
                                <div class="p-3 rounded-3 bg-light border-0 text-dark fw-medium">
                                    <i class="fa-solid fa-at me-2 text-muted"></i>{{ $user->username }}
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label small fw-bold text-muted text-uppercase">Email</label>
                                <div class="p-3 rounded-3 bg-light border-0 text-dark fw-medium">
                                    <i class="fa-solid fa-envelope me-2 text-muted"></i>{{ $user->email }}
                                </div>
                            </div>

                            <div class="col-12 mb-4">
                                <label class="form-label small fw-bold text-muted text-uppercase">Nama Lengkap</label>
                                <div class="p-3 rounded-3 bg-light border-0 text-dark fw-medium">
                                    <i class="fa-solid fa-signature me-2 text-muted"></i>{{ $user->nama_lengkap }}
                                </div>
                            </div>

                            <div class="col-12 mb-0">
                                <label class="form-label small fw-bold text-muted text-uppercase">Alamat Tempat Tinggal</label>
                                <div class="p-3 rounded-3 bg-light border-0 text-dark fw-medium d-flex align-items-start">
                                    <i class="fa-solid fa-location-dot me-3 mt-1 text-muted"></i>
                                    <span>{{ $user->alamat ?? 'Alamat belum diatur.' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Styling untuk input-like divs */
    .bg-light {
        background-color: #f8fafc !important;
        border: 1px solid #f1f5f9 !important;
        transition: all 0.2s ease;
    }

    .bg-light:hover {
        background-color: #f1f5f9 !important;
        border-color: #e2e8f0 !important;
    }

    .form-label {
        letter-spacing: 0.05em;
        font-size: 0.75rem;
    }
</style>

@endsection
