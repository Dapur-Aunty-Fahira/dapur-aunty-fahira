<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dapur Aunty Fahira - Login & Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;700&display=swap" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            background: linear-gradient(to right, #FEE3E8, #E557A1, #FEE3E8);
            font-family: 'Quicksand', sans-serif;
        }
        .auth-card {
            border-radius: 1rem;
            background-color: white;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            padding: 2rem;
        }
        .brand-header {
            text-align: center;
            margin-bottom: 1rem;
        }
        .brand-header img {
            max-width: 80px;
            margin-bottom: 10px;
        }
        .brand-header h2 {
            color: #E557A1;
            font-weight: 700;
        }
        .brand-header small {
            color: #555;
            font-weight: 500;
        }
        .form-toggle {
            color: #E557A1;
            cursor: pointer;
            text-decoration: underline;
        }
        .btn-maroon {
            background-color: #E557A1;
            color: white;
        }
        .btn-maroon:hover {
            background-color: #ec7bb6;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center">

    <div class="auth-card" style="width: 100%; max-width: 420px;">
        <div class="brand-header">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Dapur Aunty Fahira">
            <h2>Dapur Aunty Fahira</h2>
            <small>Lezatnya Hidangan, Hangatnya Pelayanan</small>
        </div>

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- Login Form -->
        <form id="login-form" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="form-control @error('email') is-invalid @enderror" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password"
                    class="form-control @error('password') is-invalid @enderror" required>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                <label class="form-check-label" for="remember">Ingat saya</label>
            </div>

            <button type="submit" class="btn btn-maroon w-100 mb-2">Login</button>
            <div class="text-center">
                <small>Belum punya akun? <span class="form-toggle" onclick="toggleForms()">Daftar sekarang</span></small>
            </div>
        </form>

        <!-- Register Form -->
        <form id="register-form" method="POST" action="{{ route('register') }}" style="display: none;">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email"
                    class="form-control @error('email') is-invalid @enderror" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password"
                    class="form-control @error('password') is-invalid @enderror" required>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-maroon w-100 mb-2">Daftar</button>
            <div class="text-center">
                <small>Sudah punya akun? <span class="form-toggle" onclick="toggleForms()">Login di sini</span></small>
            </div>
        </form>
    </div>

    <script>
        function toggleForms() {
            const login = document.getElementById('login-form');
            const register = document.getElementById('register-form');

            if (login.style.display === 'none') {
                login.style.display = 'block';
                register.style.display = 'none';
            } else {
                login.style.display = 'none';
                register.style.display = 'block';
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
