<!-- spell-checker: disable -->
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dapur Aunty Fahira - Catering Lezat & Profesional</title>

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;700&display=swap" rel="stylesheet" />

    <style>
        body {
            font-family: 'Quicksand', sans-serif;
            background: #fff0f6;
            color: #4a4a4a;
        }

        .navbar {
            background-color: #e557a1;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.6rem;
            color: #fff !important;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .navbar-brand img {
            height: 40px;
            width: 40px;
            object-fit: contain;
            border-radius: 8px;
            background: white;
            padding: 2px;
        }

        .header-section {
            background: linear-gradient(135deg, #e557a1, #fee3e8);
            color: white;
            padding: 6rem 1rem 4rem;
            text-align: center;
        }

        .header-section h1 {
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 1rem;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 1rem;
        }

        .header-section h1 img {
            height: 60px;
            width: 60px;
            object-fit: contain;
            border-radius: 10px;
            background: white;
            padding: 3px;
        }

        .btn-maroon {
            background-color: #e557a1;
            color: white;
            border: none;
            padding: 0.75rem 2rem;
            font-weight: 600;
            font-size: 1.2rem;
            border-radius: 0.5rem;
            text-decoration: none;
        }

        .btn-maroon:hover {
            background-color: #ec7bb6;
            color: white;
        }

        .floating-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #e557a1;
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            z-index: 999;
            transition: transform 0.3s ease, background-color 0.3s ease;
            text-decoration: none;
        }

        .floating-button:hover {
            background-color: #ec7bb6;
            transform: scale(1.05);
        }

        .card-fixed {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .card-fixed img {
            height: 200px;
            object-fit: cover;
        }

        .card-body {
            flex-grow: 1;
        }

        footer {
            background-color: #e557a1;
            color: white;
            padding: 1.5rem;
            text-align: center;
            font-weight: 600;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Dapur Aunty Fahira" />
                Dapur Aunty Fahira
            </a>
            <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#menu">Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#testimoni">Testimoni</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="header-section">
        <h1>
            Lezatnya Hidangan, Hangatnya Pelayanan
        </h1>
        <p class="lead mx-auto" style="max-width: 600px;">
            Catering profesional yang siap menyajikan berbagai menu spesial untuk acara Anda. Dari pesta pernikahan,
            ulang tahun, hingga acara kantor — kami hadirkan rasa terbaik.
        </p>
    </header>

    <!-- Features -->
    <section class="container py-5">
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <div class="card card-fixed border-0 shadow-sm p-4 bg-white rounded-4">
                    <div class="card-body">
                        <h4 class="text-danger">Menu Variatif</h4>
                        <p>Kami menyediakan berbagai pilihan menu tradisional dan modern yang sesuai selera Anda.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card card-fixed border-0 shadow-sm p-4 bg-white rounded-4">
                    <div class="card-body">
                        <h4 class="text-danger">Bahan Berkualitas</h4>
                        <p>Hanya menggunakan bahan segar dan terbaik untuk menjaga cita rasa setiap hidangan.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card card-fixed border-0 shadow-sm p-4 bg-white rounded-4">
                    <div class="card-body">
                        <h4 class="text-danger">Pengiriman Tepat Waktu</h4>
                        <p>Layanan pengiriman cepat dan tepat waktu, memastikan makanan sampai dalam kondisi terbaik.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Menu -->
    <section id="menu" class="bg-white py-5 text-center">
        <div class="container">
            <h2 class="text-danger fw-bold mb-4">Menu Spesial Kami</h2>
            <div class="row justify-content-center">
                <div class="col-md-4 mb-4">
                    <div class="card card-fixed border-0 shadow-sm">
                        <img src="{{ asset('images/nasi_box.png') }}?auto=format&fit=crop&w=400&q=80"
                            class="card-img-top rounded-top" alt="Nasi Box">
                        <div class="card-body">
                            <h5 class="card-title text-danger fw-bold">Nasi Box</h5>
                            <p class="card-text">Nasi box praktis dengan berbagai pilihan lauk, ideal untuk acara
                                santai.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card card-fixed border-0 shadow-sm">
                        <img src="{{ asset('images/nasi_besek.png') }}?auto=format&fit=crop&w=400&q=80"
                            class="card-img-top rounded-top" alt="Nasi Besek">
                        <div class="card-body">
                            <h5 class="card-title text-danger fw-bold">Nasi Besek</h5>
                            <p class="card-text">Nasi besek tradisional dengan bumbu khas, cocok untuk acara adat dan
                                spesial.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card card-fixed border-0 shadow-sm">
                        <img src="{{ asset('images/nasi_bento.png') }}?auto=format&fit=crop&w=400&q=80"
                            class="card-img-top rounded-top" alt="Nasi Bento">
                        <div class="card-body">
                            <h5 class="card-title text-danger fw-bold">Nasi Bento</h5>
                            <p class="card-text">Nasi bento dengan porsi pas dan variasi lauk, sempurna untuk makan
                                siang praktis.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card card-fixed border-0 shadow-sm">
                        <img src="{{ asset('images/tumpeng.png') }}?auto=format&fit=crop&w=400&q=80"
                            class="card-img-top rounded-top" alt="Nasi Tumpeng">
                        <div class="card-body">
                            <h5 class="card-title text-danger fw-bold">Nasi Tumpeng</h5>
                            <p class="card-text">Nasi kuning berbentuk kerucut dengan lauk-pauk lengkap, cocok untuk
                                acara spesial.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card card-fixed border-0 shadow-sm">
                        <img src="{{ asset('images/liwet_tampah.png') }}?auto=format&fit=crop&w=400&q=80"
                            class="card-img-top rounded-top" alt="Liwet Tampah">
                        <div class="card-body">
                            <h5 class="card-title text-danger fw-bold">Liwet Tampah</h5>
                            <p class="card-text">Hidangan nasi liwet dengan tampah tradisional, disajikan dengan aneka
                                lauk lezat.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card card-fixed border-0 shadow-sm">
                        <img src="{{ asset('images/prasmanan.png') }}?auto=format&fit=crop&w=400&q=80"
                            class="card-img-top rounded-top" alt="Prasmanan">
                        <div class="card-body">
                            <h5 class="card-title text-danger fw-bold">Prasmanan</h5>
                            <p class="card-text">Berbagai pilihan hidangan disajikan secara prasmanan, cocok untuk acara
                                besar.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- alur process pemesanan -->
    <section class="bg-light py-5 text-center">
        <div class="container">
            <h2 class="text-danger fw-bold mb-5">Alur Pemesanan</h2>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <ul class="timeline list-unstyled position-relative">
                        <li class="mb-5 position-relative">
                            <div class="timeline-dot bg-danger position-absolute top-0 start-0 translate-middle"></div>
                            <div class="card border-0 shadow-sm p-4 bg-white rounded-4 ms-5 text-start">
                                <h5 class="text-danger mb-2">1. Pilih Menu</h5>
                                <p class="mb-0">Pilih menu catering sesuai kebutuhan acara Anda.</p>
                            </div>
                        </li>
                        <li class="mb-5 position-relative">
                            <div class="timeline-dot bg-danger position-absolute top-0 start-0 translate-middle"></div>
                            <div class="card border-0 shadow-sm p-4 bg-white rounded-4 ms-5 text-start">
                                <h5 class="text-danger mb-2">2. Isi Form Pemesanan</h5>
                                <p class="mb-1">Isi form pemesanan anda dengan lengkap, termasuk alamat pengiriman,
                                    tanggal dan waktu kirim, dan catatan khusus jika ada.</p>
                                <p class="mb-0">Pastikan semua informasi sudah benar sebelum mengirimkan
                                    pesanan.
                                </p>
                            </div>
                        </li>
                        <li class="mb-5 position-relative">
                            <div class="timeline-dot bg-danger position-absolute top-0 start-0 translate-middle"></div>
                            <div class="card border-0 shadow-sm p-4 bg-white rounded-4 ms-5 text-start">
                                <h5 class="text-danger mb-2">3. Pembayaran</h5>
                                <p class="mb-1">Lakukan pembayaran melalui transfer dan kirim bukti pembayaran.</p>
                                <p class="mb-0">Setelah pembayaran dikonfirmasi, pesanan Anda akan diproses.</p>
                            </div>
                        </li>
                        <li class="position-relative">
                            <div class="timeline-dot bg-danger position-absolute top-0 start-0 translate-middle"></div>
                            <div class="card border-0 shadow-sm p-4 bg-white rounded-4 ms-5 text-start">
                                <h5 class="text-danger mb-2">4. Pengiriman</h5>
                                <p class="mb-1">Hidangan akan dikirim sesuai waktu yang telah disepakati.</p>
                                <p class="mb-0">Pastikan ada orang yang menerima pesanan di lokasi pengiriman.</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <style>
            .timeline {
                border-left: 4px solid #e557a1;
                margin-left: 30px;
                padding-left: 0;
            }

            .timeline-dot {
                width: 20px;
                height: 20px;
                border-radius: 50%;
                border: 4px solid #fff;
                box-shadow: 0 0 0 2px #e557a1;
                left: -42px;
                z-index: 1;
            }

            @media (max-width: 767.98px) {
                .timeline {
                    margin-left: 15px;
                }

                .timeline-dot {
                    left: -32px;
                }

                .ms-5 {
                    margin-left: 2rem !important;
                }
            }
        </style>
    </section>

    <!-- Testimonials -->
    <section id="testimoni" class="py-5"
        style="background: linear-gradient(135deg, #e557a1, #fee3e8); color: white;">
        <div class="container text-center">
            <h2 class="mb-4 fw-bold">Testimoni Pelanggan</h2>
            <div class="row justify-content-center">
                <div class="col-md-6 mb-4">
                    <div class="card bg-white bg-opacity-25 border-0 shadow-sm">
                        <div class="card-body">
                            <blockquote class="blockquote mb-0">
                                <p>"Pelayanan cepat dan makanannya enak sekali! Saya pasti pesan lagi untuk acara
                                    keluarga berikutnya."</p>
                                <footer class="blockquote-footer text-white mt-3">Ibu Sari, <cite
                                        title="Jakarta">Jakarta</cite></footer>
                            </blockquote>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card bg-white bg-opacity-25 border-0 shadow-sm">
                        <div class="card-body">
                            <blockquote class="blockquote mb-0">
                                <p>"Dapur Aunty Fahira membuat pesta ulang tahun saya jadi istimewa dengan hidangan yang
                                    luar biasa."</p>
                                <footer class="blockquote-footer text-white mt-3">Bapak Andi, <cite
                                        title="Bandung">Bandung</cite></footer>
                            </blockquote>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action & Contact Section -->
    <section class="bg-light py-5 text-center">
        <div class="container">
            <h2 class="text-danger fw-bold mb-4">Hubungi Kami</h2>
            <p class="mb-4">Punya pertanyaan atau ingin konsultasi menu? Tim kami siap membantu Anda!</p>
            <div class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-4 mb-4">
                <a href="https://wa.me/6287797924356"
                    class="d-flex align-items-center text-decoration-none text-dark fs-5" target="_blank"
                    rel="noopener">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp"
                        style="width: 28px; height: 28px;" class="me-2"> +62 877 9792 4356
                </a>
                <a href="https://instagram.com/dapurauntyfahira"
                    class="d-flex align-items-center text-decoration-none text-dark fs-5" target="_blank"
                    rel="noopener">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/a/a5/Instagram_icon.png" alt="Instagram"
                        style="width: 28px; height: 28px;" class="me-2"> @dapurauntyfahira
                </a>
            </div>
        </div>
    </section>

    <!-- Google Maps -->
    <section class="py-5" style="background: linear-gradient(135deg, #fee3e8 60%, #fff0f6 100%);">
        <div class="container">
            <h2 class="text-danger fw-bold mb-4 text-center">Lokasi Kami</h2>
            <div class="row justify-content-center">
                <div class="col-md-10 col-lg-8">
                    <div class="rounded-4 shadow-lg overflow-hidden border border-2 border-danger">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126.12345678901234!2d106.4470052!3d-6.20355!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e4201c1e8d19651%3A0x5809e38b48dc458d!2sDapur%20Aunty%20Fahira!5e0!3m2!1sid!2sid!4v1616161616161"
                            width="100%" height="400" style="border:0; display:block;" allowfullscreen=""
                            loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    <div class="mt-3 text-center">
                        <span class="badge bg-danger bg-gradient fs-6 px-4 py-2 shadow-sm">
                            Jl. Raya Serang km.25, Kp. Jaha Rt 02/01, Sentul Jaya, Kec. Balaraja, Kabupaten Tangerang,
                            Banten 15610
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Floating Button -->
    <a href="{{ route('login') }}" class="floating-button">Pesan Sekarang</a>

    <!-- Footer -->
    <footer>
        &copy; 2025 Dapur Aunty Fahira - Semua Hak Dilindungi
