<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Perpustakaan</title>

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
            min-height: 100vh; /* Memastikan footer tetap di bawah */
        }

        /* Navbar Style */
        .navbar {
            background-color: #ffffff !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            padding: 1rem 0;
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
        }

        .nav-link:hover {
            color: #0f172a !important;
            background-color: #f1f5f9;
        }

        .nav-link.active {
            color: #2563eb !important;
            background-color: #eff6ff;
        }

        .btn-logout {
            background-color: #ef4444;
            color: white !important;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 600;
            padding: 0.5rem 1.2rem !important;
        }

        /* Kontainer Utama */
        .main-content {
            padding-top: 2rem;
            padding-bottom: 4rem;
            flex: 1; /* Mengisi ruang agar footer terdorong ke bawah */
        }

        /* FOOTER STYLE */
        .main-footer {
            background-color: #ffffff;
            border-top: 1px solid #e2e8f0;
            padding: 3rem 0 1.5rem;
            margin-top: auto;
        }

        .footer-title {
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 1.2rem;
        }

        .footer-link {
            color: #64748b;
            text-decoration: none;
            transition: color 0.2s ease;
            display: block;
            margin-bottom: 0.5rem;
        }

        .footer-link:hover {
            color: #2563eb;
        }

        .social-icon {
            width: 36px;
            height: 36px;
            background-color: #f1f5f9;
            color: #64748b;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin-right: 0.5rem;
            transition: all 0.3s ease;
        }

        .social-icon:hover {
            background-color: #2563eb;
            color: white;
            transform: translateY(-3px);
        }

        @media (max-width: 991.98px) {
            .navbar-nav {
                padding-top: 1rem;
                gap: 0.5rem;
            }
        }
    </style>
</head>

<body>

{{-- NAVBAR --}}
<nav class="navbar navbar-expand-lg navbar-light sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('user.dashboard') }}">
            <i class="fa-solid fa-book-open text-primary me-2"></i>E-Perpus
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center gap-1">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('user/dashboard*') ? 'active' : '' }}" href="{{ route('user.dashboard') }}">
                        <i class="fa-solid fa-house-chimney me-1 small"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('user/buku*') ? 'active' : '' }}" href="{{ route('user.buku') }}">
                        <i class="fa-solid fa-book me-1 small"></i> Koleksi Buku
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('user/peminjaman*') ? 'active' : '' }}" href="{{ route('user.peminjaman') }}">
                        <i class="fa-solid fa-clock-rotate-left me-1 small"></i> Pinjaman
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('user/ulasan*') ? 'active' : '' }}" href="{{ route('user.ulasan.index') }}">
                        <i class="fa-solid fa-star me-1 small"></i> Ulasan
                    </a>
                </li>
                <li class="nav-item me-lg-3">
                    <a class="nav-link {{ request()->is('user/profile*') ? 'active' : '' }}" href="{{ route('user.profile') }}">
                        <i class="fa-solid fa-user me-1 small"></i> Profil
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/logout') }}" class="btn-logout px-4 py-2 text-white text-decoration-none shadow-sm">
                        <i class="fa-solid fa-right-from-bracket me-1"></i> Keluar
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

{{-- CONTENT --}}
<main class="container main-content">
    @yield('content')
</main>

{{-- FOOTER --}}
<footer class="main-footer">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <h5 class="footer-title">
                    <i class="fa-solid fa-book-open text-primary me-2"></i>E-Perpus
                </h5>
                <p class="text-muted small pe-lg-5">
                    Platform perpustakaan digital masa kini yang memudahkan Anda untuk mengeksplorasi ribuan ilmu dalam genggaman. Pinjam, baca, dan beri ulasan di mana saja.
                </p>
                <div class="mt-4">
                    <a href="#" class="social-icon text-decoration-none"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="social-icon text-decoration-none"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" class="social-icon text-decoration-none"><i class="fa-brands fa-twitter"></i></a>
                </div>
            </div>
            <div class="col-6 col-lg-2">
                <h6 class="footer-title small text-uppercase">Navigasi</h6>
                <a href="{{ route('user.dashboard') }}" class="footer-link small">Dashboard</a>
                <a href="{{ route('user.buku') }}" class="footer-link small">Koleksi Buku</a>
                <a href="{{ route('user.peminjaman') }}" class="footer-link small">Riwayat Pinjam</a>
            </div>
            <div class="col-6 col-lg-2">
                <h6 class="footer-title small text-uppercase">Bantuan</h6>
                <a href="#" class="footer-link small">FAQ</a>
                <a href="#" class="footer-link small">Panduan Pinjam</a>
                <a href="#" class="footer-link small">Kontak Kami</a>
            </div>
            <div class="col-lg-4">
                <h6 class="footer-title small text-uppercase">Kontak Perpustakaan</h6>
                <p class="text-muted small mb-1"><i class="fa-solid fa-location-dot me-2 text-primary"></i> Jl. Fctory No. 45, Bermuda</p>
                <p class="text-muted small mb-1"><i class="fa-solid fa-phone me-2 text-primary"></i> (021) 1234-5678</p>
                <p class="text-muted small mb-1"><i class="fa-solid fa-envelope me-2 text-primary"></i> support@e-perpus.id</p>
            </div>
        </div>
        <hr class="my-4 text-muted opacity-25">
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <p class="text-muted small mb-0">&copy; 2026 E-Perpus Digital. All rights reserved.</p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <p class="text-muted small mb-0">Crafted with <i class="fa-solid fa-heart text-danger"></i> for Literacy</p>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>