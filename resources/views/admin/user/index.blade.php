@extends('admin.layout.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-1">Manajemen User</h3>
        <p class="text-muted small mb-0">Kelola hak akses dan data pengguna perpustakaan.</p>
    </div>
</div>

{{-- Alert Success (Opsional jika ada session success) --}}
@if(session('success'))
    <div class="alert alert-success border-0 shadow-sm mb-4">
        <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
    </div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 py-3 mt-2">
        <div class="row g-3 justify-content-between">
            {{-- Action Buttons --}}
            <div class="col-md-auto d-flex gap-2">
                <a href="{{ route('admin.user.create') }}" class="btn btn-primary px-3 shadow-none">
                    <i class="fa-solid fa-plus me-1"></i> Tambah User
                </a>
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle px-3" type="button" data-bs-toggle="dropdown">
                        <i class="fa-solid fa-file-export me-1"></i> Export
                    </button>
                    <ul class="dropdown-menu border-0 shadow-sm">
                        <li>
                            <a class="dropdown-item text-danger" href="{{ route('admin.user.pdf') }}">
                                <i class="fa-solid fa-file-pdf me-2"></i> Cetak PDF
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item text-success" href="{{ route('admin.user.excel') }}">
                                <i class="fa-solid fa-file-excel me-2"></i> Export Excel
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Search Bar --}}
            <div class="col-md-4">
                <form method="GET" action="{{ route('admin.user.index') }}">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                        <input type="text" name="search" class="form-control bg-light border-0 shadow-none"
                               placeholder="Cari username / email..." value="{{ request('search') }}">
                        <button class="btn btn-secondary px-3">Cari</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light text-muted small">
                <tr>
                    <th class="ps-4 py-3 border-0">USERNAME</th>
                    <th class="py-3 border-0">EMAIL</th>
                    <th class="py-3 border-0">ROLE</th>
                    <th class="py-3 border-0 text-end pe-4" width="180">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $u)
                    <tr>
                        <td class="ps-4 py-3 border-bottom border-light">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 38px; height: 38px;">
                                    <i class="fa-solid fa-user-tag small"></i>
                                </div>
                                <span class="fw-semibold text-dark">{{ $u->username }}</span>
                            </div>
                        </td>
                        <td class="py-3 border-bottom border-light">
                            <span class="text-muted">{{ $u->email }}</span>
                        </td>
                        <td class="py-3 border-bottom border-light">
                            @if($u->role == 'admin')
                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 rounded-pill px-3">
                                    <i class="fa-solid fa-shield-halved me-1 small"></i> {{ $u->role }}
                                </span>
                            @else
                                <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 rounded-pill px-3">
                                    <i class="fa-solid fa-user me-1 small"></i> {{ $u->role }}
                                </span>
                            @endif
                        </td>
                        <td class="py-3 border-bottom border-light text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.user.edit', $u->id) }}"
                                   class="btn btn-light btn-sm text-warning border shadow-sm px-2">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>

                                <form action="{{ route('admin.user.destroy', $u->id) }}"
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-light btn-sm text-danger border shadow-sm px-2"
                                            onclick="return confirm('Hapus user ini?')">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <img src="https://illustrations.popsy.co/gray/searching-for-the-solution.svg" alt="no-data" style="width: 150px;" class="mb-3 opacity-50">
                            <p class="text-muted italic">Tidak ada data user yang ditemukan.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination (Jika ada) --}}
    @if($users->hasPages())
    <div class="card-footer bg-white border-0 py-3">
        {{ $users->links() }}
    </div>
    @endif
</div>

@endsection
