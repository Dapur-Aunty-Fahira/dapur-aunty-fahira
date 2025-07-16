<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Pemesanan Katering | Dapur Aunty Fahira</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" />
    <style>
        body {
            font-family: 'Quicksand', sans-serif;
            background-color: #fff0f6;
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

        .cart-btn {
            color: #fff;
            position: relative;
        }

        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #ffc107;
            color: #000;
            border-radius: 50%;
            padding: 2px 7px;
            font-size: 0.8rem;
            font-weight: bold;
        }

        .content-header {
            background: linear-gradient(135deg, #e557a1, #fee3e8);
            color: white;
            padding: 4rem 1rem 2rem;
            text-align: center;
        }

        .card-menu {
            border: none;
            box-shadow: 0 4px 12px rgba(229, 87, 161, 0.1);
            transition: transform 0.2s ease;
        }

        .card-menu:hover {
            transform: translateY(-4px) scale(1.01);
            box-shadow: 0 8px 24px rgba(229, 87, 161, 0.15);
        }

        .card-img-top {
            height: 180px;
            object-fit: cover;
            border-radius: 0.5rem 0.5rem 0 0;
        }

        .btn-outline-primary {
            border-color: #e557a1;
            color: #e557a1;
            font-weight: 600;
        }

        .btn-outline-primary:hover {
            background-color: #e557a1;
            color: #fff;
        }

        .form-control:focus {
            border-color: #e557a1;
            box-shadow: 0 0 0 0.2rem rgba(229, 87, 161, 0.25);
        }

        .main-footer {
            background-color: #e557a1;
            color: white;
            padding: 1rem;
            font-weight: 600;
            text-align: center;
        }

        @media (max-width: 767px) {
            .content-header {
                padding: 2rem 0.5rem 1rem;
            }

            .card-img-top {
                height: 120px;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="/images/logo.png" alt="Logo Dapur Aunty Fahira" loading="lazy">
                Dapur Aunty Fahira
            </a>
            <button class="btn cart-btn ms-auto position-relative" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#cartOffcanvas" aria-controls="cartOffcanvas" aria-label="Buka keranjang">
                <i class="bi bi-cart3 fs-4"></i>
                <span class="cart-count" id="cartCount">0</span>
            </button>
            <button class="btn btn-light ms-3" data-bs-toggle="modal" data-bs-target="#profileModal"
                aria-label="Profil Saya">
                <i class="bi bi-person-circle me-1"></i> Profil Saya
            </button>
        </div>
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
                        <button class="btn btn-outline-primary w-100 add-to-cart" data-name="Nasi Box"
                            data-price="25000" aria-label="Pesan Nasi Box">Pesan</button>
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
                        <button class="btn btn-outline-primary w-100 add-to-cart" data-name="Tumpeng"
                            data-price="400000" aria-label="Pesan Tumpeng">Pesan</button>
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
                        <button class="btn btn-outline-primary w-100 add-to-cart" data-name="Prasmanan"
                            data-price="100000" aria-label="Pesan Prasmanan">Pesan</button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="main-footer">
        &copy; 2025 Dapur Aunty Fahira - Semua Hak Dilindungi
    </footer>

    <!-- Modal Profil -->
    <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="profileForm">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="profileModalLabel"><i class="bi bi-person-lines-fill"></i> Profil
                            Saya</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="profileNama" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="profileNama"
                                placeholder="Nama lengkap Anda" autocomplete="name">
                        </div>
                        <div class="mb-3">
                            <label for="profileTelp" class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control" id="profileTelp" placeholder="08xxxxxxxxxx"
                                autocomplete="tel">
                        </div>
                        <div class="mb-3">
                            <label for="profileAlamat" class="form-label">Alamat Pengantaran</label>
                            <textarea class="form-control" id="profileAlamat" rows="2" placeholder="Alamat lengkap Anda"
                                autocomplete="street-address"></textarea>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label for="profilePassword" class="form-label">Password Baru</label>
                            <input type="password" class="form-control" id="profilePassword" placeholder="********"
                                autocomplete="new-password">
                        </div>
                        <div class="mb-3">
                            <label for="profileConfirm" class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" id="profileConfirm" placeholder="********"
                                autocomplete="new-password">
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label class="form-label">Status Pesanan</label>
                            <ul class="list-group" id="orderStatusList">
                                <li class="list-group-item">Tidak ada pesanan.</li>
                                <!-- Data riwayat bisa kamu inject lewat backend -->
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // --- Profile Modal Logic ---
        function loadProfileToForm() {
            document.getElementById('profileNama').value = localStorage.getItem('profil_nama') || '';
            document.getElementById('profileTelp').value = localStorage.getItem('profil_telp') || '';
            document.getElementById('profileAlamat').value = localStorage.getItem('profil_alamat') || '';
        }
        document.getElementById('profileModal').addEventListener('show.bs.modal', loadProfileToForm);

        document.getElementById('profileForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const nama = document.getElementById('profileNama').value.trim();
            const telp = document.getElementById('profileTelp').value.trim();
            const alamat = document.getElementById('profileAlamat').value.trim();
            const pass = document.getElementById('profilePassword').value;
            const confirm = document.getElementById('profileConfirm').value;

            if (pass && pass !== confirm) {
                alert("Konfirmasi password tidak cocok.");
                return;
            }
            localStorage.setItem('profil_nama', nama);
            localStorage.setItem('profil_telp', telp);
            localStorage.setItem('profil_alamat', alamat);
            if (pass) {
                localStorage.setItem('profil_password', pass); // simulasi
            }
            alert("Profil berhasil diperbarui!");
            document.getElementById('profilePassword').value = '';
            document.getElementById('profileConfirm').value = '';
            var modal = bootstrap.Modal.getInstance(document.getElementById('profileModal'));
            modal.hide();
        });

        // --- Cart Logic ---
        let cart = {};
        // Load cart from localStorage
        if (localStorage.getItem('cart')) {
            cart = JSON.parse(localStorage.getItem('cart'));
        }

        function formatRupiah(angka) {
            return 'Rp' + angka.toLocaleString('id-ID');
        }

        function updateCartDisplay() {
            const cartItems = document.getElementById('cartItems');
            const cartCount = document.getElementById('cartCount');
            const checkoutBtn = document.getElementById('checkoutBtn');
            const items = Object.entries(cart);

            let totalQty = 0;
            let totalHarga = 0;

            if (items.length === 0) {
                cartItems.innerHTML = '<p class="text-muted">Keranjang Anda kosong.</p>';
                checkoutBtn.disabled = true;
            } else {
                let html = items.map(([name, data]) => {
                    totalQty += data.qty;
                    totalHarga += data.qty * data.price;
                    return `
            <div class="d-flex justify-content-between align-items-center mb-2">
              <div>
                <div class="fw-semibold">${name}</div>
                <small class="text-muted">${formatRupiah(data.price)} x ${data.qty}</small>
              </div>
              <div>
                <button class="btn btn-sm btn-light border change-qty" data-name="${name}" data-delta="-1" aria-label="Kurangi ${name}">-</button>
                <span class="mx-1">${data.qty}</span>
                <button class="btn btn-sm btn-light border change-qty" data-name="${name}" data-delta="1" aria-label="Tambah ${name}">+</button>
                <button class="btn btn-sm btn-danger ms-2 remove-item" data-name="${name}" aria-label="Hapus ${name}"><i class="bi bi-trash"></i></button>
              </div>
            </div>`;
                }).join('');

                html += `
          <hr>
          <div class="d-flex justify-content-between fw-bold">
            <span>Total</span>
            <span>${formatRupiah(totalHarga)}</span>
          </div>
          <div class="mt-3">
            <h6>Informasi Pemesan</h6>
            <input type="text" class="form-control mb-2" placeholder="Nama Lengkap" id="namaPemesan">
            <input type="text" class="form-control mb-2" placeholder="No. Telepon" id="telpPemesan">
            <textarea class="form-control mb-2" placeholder="Alamat Pengantaran" id="alamatPemesan" rows="2"></textarea>
            <label class="form-label">Upload Bukti Pembayaran</label>
            <input type="file" class="form-control mb-2" id="buktiBayar" accept="image/*" capture="environment">
            <img id="buktiPreview" src="" alt="Preview Bukti Bayar" class="img-fluid mt-2 rounded shadow-sm d-none" style="max-height: 200px;">
          </div>`;

                cartItems.innerHTML = html;
                checkoutBtn.disabled = false;

                // Autofill pemesan info from profile
                document.getElementById('namaPemesan').value = localStorage.getItem('profil_nama') || '';
                document.getElementById('telpPemesan').value = localStorage.getItem('profil_telp') || '';
                document.getElementById('alamatPemesan').value = localStorage.getItem('profil_alamat') || '';

                // Add event for image preview
                document.getElementById('buktiBayar').addEventListener('change', previewImage);
            }
            cartCount.textContent = totalQty;
            localStorage.setItem('cart', JSON.stringify(cart));
        }

        // Event delegation for cart actions
        document.getElementById('cartItems').addEventListener('click', function(e) {
            if (e.target.classList.contains('change-qty')) {
                const name = e.target.getAttribute('data-name');
                const delta = parseInt(e.target.getAttribute('data-delta'));
                if (cart[name]) {
                    cart[name].qty += delta;
                    if (cart[name].qty <= 0) delete cart[name];
                    updateCartDisplay();
                }
            }
            if (e.target.classList.contains('remove-item')) {
                const name = e.target.getAttribute('data-name');
                delete cart[name];
                updateCartDisplay();
            }
        });

        // Add to cart
        document.querySelectorAll('.add-to-cart').forEach(btn => {
            btn.addEventListener('click', function() {
                const name = this.getAttribute('data-name');
                const price = parseInt(this.getAttribute('data-price'));
                if (!cart[name]) {
                    cart[name] = {
                        qty: 1,
                        price: price
                    };
                } else {
                    cart[name].qty += 1;
                }
                updateCartDisplay();
            });
        });

        // Checkout button
        document.getElementById('checkoutBtn').addEventListener('click', submitOrder);

        function previewImage(e) {
            const input = e.target;
            const preview = document.getElementById('buktiPreview');
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(ev) {
                    preview.src = ev.target.result;
                    preview.classList.remove('d-none');
                };
                reader.readAsDataURL(file);
            } else {
                preview.src = '';
                preview.classList.add('d-none');
            }
        }

        function submitOrder() {
            const nama = document.getElementById('namaPemesan').value.trim();
            const telp = document.getElementById('telpPemesan').value.trim();
            const alamat = document.getElementById('alamatPemesan').value.trim();
            const bukti = document.getElementById('buktiBayar').files[0];

            if (!nama || !telp || !alamat) {
                alert("Harap isi semua informasi pemesan.");
                return;
            }
            if (!bukti) {
                alert("Harap unggah bukti pembayaran.");
                return;
            }
            if (bukti.size > 2 * 1024 * 1024) {
                alert("Ukuran bukti pembayaran maksimal 2MB.");
                return;
            }

            const formData = new FormData();
            formData.append("nama", nama);
            formData.append("telp", telp);
            formData.append("alamat", alamat);
            formData.append("bukti_bayar", bukti);
            formData.append("cart", JSON.stringify(cart));

            // TODO: Ganti ke endpoint backend
            // fetch('/api/pemesanan', { method: 'POST', body: formData })

            alert(`Pesanan berhasil dibuat!\nTerima kasih, ${nama}.`);
            cart = {};
            updateCartDisplay();
        }

        updateCartDisplay();
    </script>
</body>

</html>
