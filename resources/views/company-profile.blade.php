<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dapur Aunty Fahira - Catering Lezat & Profesional</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
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
      <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
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
      <img src="{{ asset('images/logo.png') }}" alt="Logo" />
      Lezatnya Hidangan, Hangatnya Pelayanan
    </h1>
    <p class="lead mx-auto" style="max-width: 600px;">
      Catering profesional yang siap menyajikan berbagai menu spesial untuk acara Anda. Dari pesta pernikahan, ulang tahun, hingga acara kantor — kami hadirkan rasa terbaik.
    </p>
    <a href="{{ route('login') }}" class="btn-maroon mt-3">Pesan Sekarang</a>
  </header>

  <!-- Features -->
  <section class="container py-5">
    <div class="row text-center">
      <div class="col-md-4 mb-4">
        <div class="p-4 bg-white rounded-4 shadow">
          <h4 class="text-danger">Menu Variatif</h4>
          <p>Kami menyediakan berbagai pilihan menu tradisional dan modern yang sesuai selera Anda.</p>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="p-4 bg-white rounded-4 shadow">
          <h4 class="text-danger">Bahan Berkualitas</h4>
          <p>Hanya menggunakan bahan segar dan terbaik untuk menjaga cita rasa setiap hidangan.</p>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="p-4 bg-white rounded-4 shadow">
          <h4 class="text-danger">Pengiriman Tepat Waktu</h4>
          <p>Layanan pengiriman cepat dan tepat waktu, memastikan makanan sampai dalam kondisi terbaik.</p>
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
          <div class="card border-0 shadow-sm">
            <img src="https://images.unsplash.com/photo-1600891964599-f61ba0e24092?auto=format&fit=crop&w=400&q=80" class="card-img-top rounded-top" alt="Nasi Tumpeng">
            <div class="card-body">
              <h5 class="card-title text-danger fw-bold">Nasi Tumpeng</h5>
              <p class="card-text">Nasi kuning berbentuk kerucut dengan lauk-pauk lengkap, cocok untuk acara spesial.</p>
            </div>
          </div>
        </div>
        <div class="col-md-4 mb-4">
          <div class="card border-0 shadow-sm">
            <img src="https://images.unsplash.com/photo-1617191516342-5e849c72b23c?auto=format&fit=crop&w=400&q=80" class="card-img-top rounded-top" alt="Ayam Bakar Madu">
            <div class="card-body">
              <h5 class="card-title text-danger fw-bold">Ayam Bakar Madu</h5>
              <p class="card-text">Ayam bakar dengan balutan madu manis yang gurih, favorit di setiap acara.</p>
            </div>
          </div>
        </div>
        <div class="col-md-4 mb-4">
          <div class="card border-0 shadow-sm">
            <img src="https://images.unsplash.com/photo-1586190848861-99aa4a171e90?auto=format&fit=crop&w=400&q=80" class="card-img-top rounded-top" alt="Sate Ayam">
            <div class="card-body">
              <h5 class="card-title text-danger fw-bold">Sate Ayam</h5>
              <p class="card-text">Potongan ayam empuk disajikan dengan bumbu kacang khas, lezat dan menggugah selera.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Testimonials -->
  <section id="testimoni" class="py-5" style="background: linear-gradient(135deg, #e557a1, #fee3e8); color: white;">
    <div class="container text-center">
      <h2 class="mb-4 fw-bold">Testimoni Pelanggan</h2>
      <div class="row justify-content-center">
        <div class="col-md-6 mb-4">
          <div class="card bg-white bg-opacity-25 border-0 shadow-sm">
            <div class="card-body">
              <blockquote class="blockquote mb-0">
                <p>"Pelayanan cepat dan makanannya enak sekali! Saya pasti pesan lagi untuk acara keluarga berikutnya."</p>
                <footer class="blockquote-footer text-white mt-3">Ibu Sari, <cite title="Jakarta">Jakarta</cite></footer>
              </blockquote>
            </div>
          </div>
        </div>
        <div class="col-md-6 mb-4">
          <div class="card bg-white bg-opacity-25 border-0 shadow-sm">
            <div class="card-body">
              <blockquote class="blockquote mb-0">
                <p>"Dapur Aunty Fahira membuat pesta ulang tahun saya jadi istimewa dengan hidangan yang luar biasa."</p>
                <footer class="blockquote-footer text-white mt-3">Bapak Andi, <cite title="Bandung">Bandung</cite></footer>
              </blockquote>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    &copy; 2025 Dapur Aunty Fahira - Semua Hak Dilindungi
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
