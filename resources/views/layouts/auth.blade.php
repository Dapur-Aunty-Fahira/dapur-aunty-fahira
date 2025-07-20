<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        body {
            height: 100vh;
            background: linear-gradient(to right, #FEE3E8, #E557A1, #FEE3E8);
            font-family: 'Quicksand', sans-serif;
        }

        .auth-card {
            border-radius: 1rem;
            background-color: white;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
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
    <!-- Button Kembali -->
    <div class="position-absolute top-0 start-0 m-3">
        <a href="{{ url('/') }}" class="btn btn-outline-secondary">Kembali ke Halaman Utama</a>
    </div>

    <div class="auth-card" style="width: 100%; max-width: 420px;">
        <div class="brand-header">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Dapur Aunty Fahira">
            <h2>Dapur Aunty Fahira</h2>
            <small>Lezatnya Hidangan, Hangatnya Pelayanan</small>
        </div>

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @yield('form')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')

</body>

</html>
