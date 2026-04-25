<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Perpustakaan Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .login-card {
            border: none;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            transition: transform 0.3s ease;
        }
        .login-card:hover {
            transform: translateY(-5px);
        }
        .btn-primary {
            background-color: #2563eb;
            border: none;
            padding: 12px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-primary:hover {
            background-color: #1e40af;
            box-shadow: 0 8px 15px rgba(37, 99, 235, 0.2);
        }
        .form-control {
            padding: 12px 15px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            background-color: #f8fafc;
        }
        .form-control:focus {
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
            border-color: #2563eb;
            background-color: #fff;
        }
        .input-group-text {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            color: #94a3b8;
        }
        .brand-icon {
            width: 60px;
            height: 60px;
            background: #2563eb;
            color: white;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 24px;
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.2);
        }
    </style>
</head>

<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-11 col-sm-8 col-md-6 col-lg-4">

            <div class="card login-card shadow-lg p-4">

                <div class="brand-icon">
                    <i class="fa-solid fa-book-open"></i>
                </div>

                <h3 class="text-center fw-bold text-dark mb-1">Selamat Datang</h3>
                <p class="text-center text-muted small mb-4">Masuk untuk mengakses koleksi buku</p>

                {{-- FEEDBACK ERROR --}}
                @if($errors->any())
                    <div class="alert alert-danger border-0 small animate__animated animate__shakeX">
                        <i class="fa-solid fa-circle-exclamation me-2"></i> {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="/login">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">EMAIL</label>
                        <div class="input-group">
                            <span class="input-group-text border-end-0"><i class="fa-solid fa-envelope"></i></span>
                            <input type="email" name="email" class="form-control border-start-0 ps-0 shadow-none"
                                   placeholder="nama@email.com" required autofocus>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between">
                            <label class="form-label small fw-bold text-muted">PASSWORD</label>
                        </div>
                        <div class="input-group">
                            <span class="input-group-text border-end-0"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" name="password" class="form-control border-start-0 ps-0 shadow-none"
                                   placeholder="••••••••" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mb-3">
                        Masuk Sekarang <i class="fa-solid fa-arrow-right-to-bracket ms-2"></i>
                    </button>
                </form>

                <div class="position-relative my-4">
                    <hr class="text-muted opacity-25">
                    <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-muted small">atau</span>
                </div>

                <p class="text-center text-muted small mb-0">
                    Belum bergabung?
                    <a href="/register" class="text-primary fw-bold text-decoration-none">Daftar Akun</a>
                </p>

            </div>

            <p class="text-center text-muted mt-4 small">
                &copy; 2026 Perpustakaan Digital. All rights reserved.
            </p>

        </div>
    </div>
</div>

</body>
</html>
