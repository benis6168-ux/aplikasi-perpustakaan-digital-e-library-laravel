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
                <h3 class="fw-bold text-dark mb-0">Edit Pengguna</h3>
                <p class="text-muted small mb-0">Perbarui informasi profil dan hak akses user.</p>
            </div>
        </div>

        {{-- Form Card --}}
        <div class="card border-0 shadow-sm p-4">
            <form method="POST" action="{{ route('admin.user.update', $user->id) }}">
                @csrf
                @method('PUT')

                <div class="row">
                    {{-- Username --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Username</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-at text-muted small"></i></span>
                            <input type="text" name="username" value="{{ $user->username }}"
                                   class="form-control bg-light border-0 shadow-none" required>
                        </div>
                    </div>

                    {{-- Nama Lengkap --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Nama Lengkap</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-id-card text-muted small"></i></span>
                            <input type="text" name="nama_lengkap" value="{{ $user->nama_lengkap }}"
                                   class="form-control bg-light border-0 shadow-none" required>
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Alamat Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-envelope text-muted small"></i></span>
                            <input type="email" name="email" value="{{ $user->email }}"
                                   class="form-control bg-light border-0 shadow-none" required>
                        </div>
                    </div>

                    {{-- Role --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Hak Akses (Role)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-user-shield text-muted small"></i></span>
                            <select name="role" class="form-select bg-light border-0 shadow-none">
                                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User (Anggota)</option>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrator</option>
                            </select>
                        </div>
                    </div>

                    {{-- Alamat --}}
                    <div class="col-12 mb-4">
                        <label class="form-label small fw-bold text-muted text-uppercase">Alamat Domisili</label>
                        <textarea name="alamat" rows="3"
                                  class="form-control bg-light border-0 shadow-none"
                                  placeholder="Masukkan alamat lengkap...">{{ $user->alamat }}</textarea>
                    </div>
                </div>

                <hr class="text-muted opacity-25">

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('admin.user.index') }}" class="btn btn-light px-4 fw-semibold text-muted">Batal</a>
                    <button type="submit" class="btn btn-primary px-4 fw-semibold">
                        <i class="fa-solid fa-floppy-disk me-2"></i> Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>

        {{-- Note Card --}}
        <div class="alert alert-info border-0 shadow-sm mt-4 p-3 d-flex align-items-center">
            <i class="fa-solid fa-circle-info fs-4 me-3 text-info"></i>
            <p class="mb-0 small text-dark">Mengubah <strong>Role</strong> akan segera mengubah hak akses user tersebut saat mereka melakukan login berikutnya.</p>
        </div>

    </div>
</div>

@endsection
