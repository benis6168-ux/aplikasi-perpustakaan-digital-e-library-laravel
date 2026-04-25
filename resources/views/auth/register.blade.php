<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun | Perpustakaan Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .register-card {
            border: none;
            border-radius: 24px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.05);
        }
        .brand-logo {
            width: 50px;
            height: 50px;
            background: #198754;
            color: white;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 20px;
        }
        .form-label {
            font-size: 0.7rem;
            letter-spacing: 0.05em;
            margin-bottom: 0.4rem;
        }
        .form-control {
            padding: 10px 15px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            background-color: #f8fafc;
            font-size: 0.9rem;
        }
        .form-control:focus {
            box-shadow: 0 0 0 4px rgba(25, 135, 84, 0.1);
            border-color: #198754;
            background-color: #fff;
        }
        .input-group-text {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            color: #94a3b8;
        }
        .btn-register {
            background-color: #198754;
            border: none;
            padding: 12px;
            border-radius: 12px;
            font-weight: 700;
            transition: all 0.3s;
        }
        .btn-register:hover {
            background-color: #157347;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(25, 135, 84, 0.3);
        }
    </style>
</head>

<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-11 col-sm-10 col-md-8 col-lg-6 col-xl-5"> {{-- Lebar sedikit ditambah karena form lebih panjang --}}

            <div class="card register-card p-4 p-md-5">

                <div class="brand-logo">
                    <i class="fa-solid fa-user-plus"></i>
                </div>

                <h3 class="text-center fw-bold text-dark mb-1">Daftar Akun</h3>
                <p class="text-center text-muted small mb-4">Lengkapi data diri untuk bergabung dengan MyPerpus.</p>

                {{-- ERROR FEEDBACK --}}
                @if($errors->any())
                    <div class="alert alert-danger border-0 small py-2">
                        <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="/register">
                    @csrf
                    
                    {{-- Hidden Role: Default User --}}
                    <input type="hidden" name="role" value="user">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-muted text-uppercase">Username</label>
                            <div class="input-group">
                                <span class="input-group-text border-end-0"><i class="fa-solid fa-user"></i></span>
                                <input type="text" name="username" class="form-control border-start-0 ps-0 shadow-none"
                                       placeholder="Username" required autofocus>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-muted text-uppercase">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text border-end-0"><i class="fa-solid fa-id-card"></i></span>
                                <input type="text" name="nama_lengkap" class="form-control border-start-0 ps-0 shadow-none"
                                       placeholder="Nama Sesuai KTP" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted text-uppercase">Email</label>
                        <div class="input-group">
                            <span class="input-group-text border-end-0"><i class="fa-solid fa-envelope"></i></span>
                            <input type="email" name="email" class="form-control border-start-0 ps-0 shadow-none"
                                   placeholder="nama@email.com" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted text-uppercase">Password</label>
                        <div class="input-group">
                            <span class="input-group-text border-end-0"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" name="password" class="form-control border-start-0 ps-0 shadow-none"
                                   placeholder="Minimal 8 karakter" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-muted text-uppercase">Alamat</label>
                        <div class="input-group">
                            <span class="input-group-text border-end-0"><i class="fa-solid fa-location-dot"></i></span>
                            <textarea name="alamat" class="form-control border-start-0 ps-0 shadow-none" 
                                      placeholder="Alamat lengkap saat ini" rows="2" required></textarea>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-register btn-success w-100 mb-3 fw-bold">
                        Daftar Sekarang <i class="fa-solid fa-arrow-right ms-2"></i>
                    </button>
                </form>

                <div class="text-center mt-3">
                    <p class="text-muted small mb-0">
                        Sudah memiliki akun?
                        <a href="/login" class="text-success fw-bold text-decoration-none">Login di sini</a>
                    </p>
                </div>

            </div>

            <p class="text-center text-muted mt-4 small">
                © 2026 <strong>MyPerpus</strong>. Seluruh data dilindungi.
            </p>

        </div>
    </div>
</div>

</body>
</html>