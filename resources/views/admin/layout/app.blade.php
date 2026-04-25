<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | Perpustakaan Digital</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
            color: #334155;
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Penting untuk sticky footer */
        }

        /* Navbar Style - Konsisten dengan User */
        .navbar {
            background-color: #ffffff !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            padding: 0.8rem 0;
            border-bottom: 3px solid #2563eb; /* Garis biru dipertegas untuk Admin */
        }

        .navbar-brand {
            font-weight: 700;
            color: #1e293b !important;
            letter-spacing: -0.5px;
        }

        .nav-link {
            font-weight: 500;
            color: #64748b !important;
            transition: all 0.3s ease;
            padding: 0.5rem 1rem !important;
            border-radius: 8px;
            font-size: 0.95rem;
        }

        .nav-link:hover {
            color: #0f172a !important;
            background-color: #f1f5f9;
        }

        .nav-link.active {
            color: #2563eb !important;
            background-color: #eff6ff;
        }

        /* Admin Badge */
        .admin-badge {
            font-size: 0.65rem;
            background-color: #2563eb;
            color: white;
            padding: 3px 10px;
            border-radius: 50px;
            vertical-align: middle;
            margin-left: 5px;
            text-transform: uppercase;
            font-weight: 800;
        }

        /* Tombol Logout */
        .btn-logout {
            background-color: #ef4444;
            color: white !important;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 600;
            padding: 0.5rem 1.2rem !important;
            transition: all 0.3s;
        }

        .btn-logout:hover {
            background-color: #dc2626;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
        }

        .main-content {
            padding-top: 2.5rem;
            padding-bottom: 4rem;
            flex: 1; /* Menekan footer ke bawah */
        }

        /* FOOTER ADMIN - Modern & Clean */
        .admin-footer {
            background-color: #ffffff;
            border-top: 1px solid #e2e8f0;
            padding: 25px 0;
            color: #64748b;
        }

        .footer-status {
            display: inline-flex;
            align-items: center;
            background-color: #f0fdf4;
            color: #16a34a;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .status-dot {
            height: 8px;
            width: 8px;
            background-color: #22c55e;
            border-radius: 50%;
            display: inline-block;
            margin-right: 6px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 5px rgba(34, 197, 94, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
        }

        @media (max-width: 991.98px) {
            .navbar-nav { padding-top: 1rem; gap: 0.5rem; }
        }
    </style>
</head>

<body>

{{-- NAVBAR ADMIN --}}
<nav class="navbar navbar-expand-lg navbar-light sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
            <i class="fa-solid fa-shield-halved text-primary me-1"></i> Libris <span class="admin-badge">Admin</span>
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center gap-1">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="fa-solid fa-chart-pie me-1 small"></i> Dashboard
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->is('admin/user*', 'admin/buku*', 'admin/kategori*') ? 'active' : '' }}" href="#" id="masterData" role="button" data-bs-toggle="dropdown">
                        <i class="fa-solid fa-database me-1 small"></i> Master Data
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-2">
                        <li><a class="dropdown-item py-2" href="{{ route('admin.user.index') }}"><i class="fa-solid fa-users me-2 small text-muted"></i> Manajemen User</a></li>
                        <li><a class="dropdown-item py-2" href="{{ route('admin.buku.index') }}"><i class="fa-solid fa-book me-2 small text-muted"></i> Koleksi Buku</a></li>
                        <li><a class="dropdown-item py-2" href="{{ route('admin.kategori.index') }}"><i class="fa-solid fa-tags me-2 small text-muted"></i> Kategori Buku</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.peminjaman') ? 'active' : '' }}" href="{{ route('admin.peminjaman') }}">
                        <i class="fa-solid fa-exchange-alt me-1 small"></i> Peminjaman
                    </a>
                </li>

                <li class="nav-item me-lg-3">
                    <a class="nav-link {{ request()->routeIs('admin.ulasan') ? 'active' : '' }}" href="{{ route('admin.ulasan') }}">
                        <i class="fa-solid fa-star me-1 small"></i> Ulasan
                    </a>
                </li>

                <li class="nav-item border-start ps-lg-3">
                    <div class="d-flex align-items-center">
                        <div class="text-end me-3 d-none d-xl-block">
                            <small class="text-muted d-block" style="font-size: 0.7rem;">Signed in as</small>
                            <span class="fw-bold small text-dark">{{ auth()->user()->username }}</span>
                        </div>
                        <a href="{{ url('/logout') }}" class="btn-logout px-4 text-decoration-none shadow-sm">
                            <i class="fa-solid fa-power-off"></i> <span class="d-lg-none d-xl-inline ms-1">Keluar</span>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>

{{-- CONTENT --}}
<main class="container main-content">
    @yield('content')
</main>

{{-- FOOTER ADMIN --}}
<footer class="admin-footer mt-auto">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                <div class="footer-status">
                    <span class="status-dot"></span> Server Online: System Operational
                </div>
                <p class="mb-0 mt-2 small">Copyright &copy; 2026 <strong>Libris Digital</strong>. All rights reserved.</p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <div class="d-flex justify-content-center justify-content-md-end gap-3 small">
                    <span class="text-muted border-end pe-3">Version 2.1.0</span>
                    <span class="text-muted">Admin Panel Mode</span>
                </div>
                <p class="mb-0 mt-1 small text-muted">Rekayasa Perangkat Lunak &bull; UKK 2026</p>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>