<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Pemesanan Katering | Dapur Aunty Fahira</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    @include('layouts.guest.stylesheet')
</head>

<body>
    <nav class="navbar navbar-expand-lg shadow-sm py-3">
        @include('layouts.guest.navbar')
    </nav>


    <div class="offcanvas offcanvas-end" tabindex="-1" id="cartOffcanvas" aria-labelledby="cartOffcanvasLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="cartOffcanvasLabel"><i class="bi bi-cart3"></i> Keranjang</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Tutup"></button>
        </div>
        <div class="offcanvas-body" id="cartItems">
            <p class="text-muted">Keranjang Anda kosong.</p>
        </div>
        <div class="offcanvas-footer p-3 border-top">
            <button class="btn btn-primary w-100" id="checkoutBtn" disabled>Checkout</button>
        </div>
    </div>

    @yield('content')

    <footer class="main-footer">
        @include('layouts.guest.footer')
    </footer>

    @include('layouts.guest.javascript')
    @stack('scripts')
</body>

</html>
