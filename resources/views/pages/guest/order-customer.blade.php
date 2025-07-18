@extends('layouts.guest.app')
@section('title', 'Pemesanan Katering | Dapur Aunty Fahira')
@section('content')
    <header class="content-header">
        <h1>Pemesanan Katering</h1>
        <p class="lead">Pilih menu favorit Anda dan lakukan pemesanan dengan mudah dan cepat.</p>
    </header>

    <main class="container py-5">
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <div class="col">
                <div class="card card-menu">
                    <img src="/images/nasi_box.jpg" class="card-img-top" alt="Nasi Box" loading="lazy">
                    <div class="card-body">
                        <h5 class="card-title">Nasi Box</h5>
                        <p>Nasi dengan lauk lengkap.</p>
                        <p class="fw-bold text-danger">Rp25.000</p>
                        <button class="btn btn-outline-primary w-100 add-to-cart" data-name="Nasi Box" data-price="25000"
                            aria-label="Pesan Nasi Box">Pesan</button>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card card-menu">
                    <img src="/images/tumpeng.jpg" class="card-img-top" alt="Tumpeng" loading="lazy">
                    <div class="card-body">
                        <h5 class="card-title">Tumpeng</h5>
                        <p>Tumpeng kuning dan lauk istimewa.</p>
                        <p class="fw-bold text-danger">Rp400.000</p>
                        <button class="btn btn-outline-primary w-100 add-to-cart" data-name="Tumpeng" data-price="400000"
                            aria-label="Pesan Tumpeng">Pesan</button>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card card-menu">
                    <img src="/images/prasmanan.jpg" class="card-img-top" alt="Prasmanan" loading="lazy">
                    <div class="card-body">
                        <h5 class="card-title">Prasmanan</h5>
                        <p>Pilihan menu lengkap dan fleksibel.</p>
                        <p class="fw-bold text-danger">Rp100.000</p>
                        <button class="btn btn-outline-primary w-100 add-to-cart" data-name="Prasmanan" data-price="100000"
                            aria-label="Pesan Prasmanan">Pesan</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
