@extends('layouts.guest.app')

@section('title', 'Pemesanan Katering | Dapur Aunty Fahira')

@section('content')
    <header class="bg-light py-4 border-bottom mb-4 text-center">
        <div class="container">
            <h1 class="fw-bold">Pemesanan Katering</h1>
            <p class="lead text-muted">Pilih menu favorit Anda dan lakukan pemesanan dengan mudah dan cepat.</p>
        </div>
    </header>

    <main class="container pb-5">
        <!-- Tabs Kategori -->
        <div class="mb-4 overflow-auto">
            <ul class="nav nav-pills flex-nowrap gap-2" id="category-tabs" style="white-space: nowrap;">
                <!-- Kategori akan dimuat via AJAX -->
            </ul>
        </div>

        <!-- Search Bar -->
        <div class="mb-4">
            <input type="text" id="menu-search" class="form-control" placeholder="Cari menu...">
        </div>

        <!-- Menu Cards -->
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4" id="menu-list">
            <!-- Menu akan dimuat via AJAX -->
        </div>

        <!-- Tombol Muat Lebih Banyak -->
        <div class="text-center mt-4">
            <button id="load-more" class="btn btn-outline-secondary d-none">
                <i class="bi bi-arrow-down-circle"></i> Muat Lebih Banyak
            </button>
        </div>
    </main>

    <!-- Modal Checkout -->
    <div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel">
        <div class="modal-dialog">
            <form id="checkoutForm" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="checkoutModalLabel">Formulir Pemesanan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama" name="nama" required
                                value="{{ old('nama', Auth::check() ? Auth::user()->name : '') }}">
                        </div>

                        <div class="m -3">
                            <label for="hp" class="form-label">No HP</label>
                            <input type="tel" class="form-control" id="hp" name="hp" required
                                pattern="[0-9]{10,15}" inputmode="numeric" maxlength="15" placeholder="08xxxxxxxxxx"
                                value="{{ old('hp', Auth::check() ? Auth::user()->phone ?? '' : '') }}"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                        </div>

                        <div class="mb-3">
                            <label for="bukti" class="form-label">Upload Bukti Transfer</label>
                            <input type="file" class="form-control" id="bukti" name="bukti" accept="image/*"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="delivery_date" class="form-label">Tanggal Pengiriman</label>
                            <input type="date" class="form-control" id="delivery_date" name="delivery_date" required>
                        </div>

                        <div class="mb-3">
                            <label for="delivery_time" class="form-label">Waktu Pengiriman</label>
                            <input type="time" class="form-control" id="delivery_time" name="delivery_time" required>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat Pengiriman</label>
                            <textarea class="form-control" id="address" name="address" rows="2" required
                                placeholder="Masukkan alamat lengkap pengiriman"></textarea>
                        </div>

                        <input type="hidden" id="totalOrder" name="totalOrder" value="">

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Kirim Pesanan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>




    <style>
        /* Kartu Menu Styling */
        .card-menu {
            height: 100%;
            border: 1px solid #eee;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease, box-shadow 0.3s ease;
        }

        .card-menu:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
        }

        .card-img-top {
            object-fit: cover;
            height: 180px;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }

        /* Tabs kategori */
        .nav-pills .nav-link {
            border-radius: 30px;
            padding: 0.45rem 1.2rem;
            font-size: 0.9rem;
            font-weight: bold;
            background-color: #f8f9fa;
            transition: background-color 0.2s ease;
            color: #333;
            /* Tambahkan warna teks default */
            text-decoration: none;
            /* Hilangkan garis bawah */
        }

        .nav-pills .nav-link:hover {
            background-color: #f1f1f1;
            color: #000;
            /* Tambahkan warna teks saat hover */
        }

        .nav-pills .nav-link.active {
            background-color: #a2a0a1;
            color: white;
        }

        /* Tombol Pesan */
        .add-to-cart {
            transition: all 0.2s ease-in-out;
        }

        .add-to-cart:hover {
            transform: scale(1.02);
        }
    </style>
@endsection

@push('scripts')
    <script>
        // Pass user ID from backend to JS
        window.LaravelUserId = @json(Auth::check() ? Auth::id() : null);

        document.addEventListener('DOMContentLoaded', function() {
            // Sync user_id to localStorage if authenticated
            if (window.LaravelUserId) {
                localStorage.setItem('user_id', window.LaravelUserId);
            } else {
                localStorage.removeItem('user_id');
            }
            fetchCartFromDB();
        });

        let page = 1;
        let category = '';
        let search = '';
        let loading = false;
        let lastPage = false;

        function loadCategories() {
            $.ajax({
                url: '/api/v1/categories',
                method: 'GET',
                success: function(res) {
                    const $tabs = $('#category-tabs').empty();
                    if (res.status === 'sukses' && Array.isArray(res.data)) {
                        $tabs.append(`<li class="nav-item">
                        <a class="nav-link active" href="#" data-category="">Semua</a>
                    </li>`);
                        res.data.forEach(cat => {
                            $tabs.append(`<li class="nav-item">
                            <a class="nav-link" href="#" data-category="${cat.name}">${cat.name}</a>
                        </li>`);
                        });
                    } else {
                        showErrorTab('Gagal memuat kategori');
                    }
                },
                error: function() {
                    showErrorTab('Terjadi kesalahan saat mengambil kategori');
                }
            });
        }

        function showErrorTab(msg) {
            $('#category-tabs').html(`
            <li class="nav-item">
                <span class="nav-link text-danger">${msg}</span>
            </li>
        `);
        }

        function loadMenus(reset = false) {
            if (loading || lastPage) return;
            loading = true;
            $('#load-more').prop('disabled', true).text('Memuat...');

            if (reset) {
                $('#menu-list').empty();
                lastPage = false;
                page = 1;
            }

            let dataParams = {
                page: page
            };
            if (category) dataParams.category = category;
            if (search) dataParams.search = search;

            $.ajax({
                url: '/api/v1/menus',
                method: 'GET',
                data: dataParams,
                success: function(res) {
                    if (res.status !== 'sukses' || !Array.isArray(res.data)) {
                        showMenuError(res.message || 'Gagal memuat menu');
                        $('#load-more').addClass('d-none');
                        lastPage = true;
                        return;
                    }

                    const menus = res.data;
                    if (menus.length > 0) {
                        menus.forEach(menu => {
                            $('#menu-list').append(`
                            <div class="col">
                                <div class="card card-menu h-100">
                                    <img src="${menu.image && menu.image.startsWith('http') ? menu.image : (menu.image ? '/storage/' + menu.image : 'https://placehold.co/300x180?text=No+Image')}"
                                        class="card-img-top"
                                        alt="${menu.name}"
                                        loading="lazy"
                                        onerror="this.onerror=null;this.src='https://placehold.co/300x180?text=No+Image';">
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title">${menu.name}</h5>
                                        <p class="card-text small text-muted mb-2">${menu.description || 'Deskripsi tidak tersedia'}</p>
                                        <div class="mt-auto">
                                            <p class="fw-bold text-black mb-2">Minimal Order: ${menu.min_order}</p>
                                            <p class="fw-bold text-danger mb-2">Rp.${menu.price.toLocaleString('id-ID')}</p>
                                            <button class="btn btn-sm btn-outline-danger w-100 add-to-cart" data-min-order="${menu.min_order}" data-id="${menu.menu_id}" data-name="${menu.name}" data-price="${menu.price}">
                                                <i class="bi bi-cart-plus"></i> Pesan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `);
                        });

                        $('#load-more').removeClass('d-none');
                        page++;
                        if (!res.next_page_url) {
                            lastPage = true;
                            $('#load-more').addClass('d-none');
                        }
                    } else {
                        showMenuError('Menu tidak ditemukan.');
                        $('#load-more').addClass('d-none');
                        lastPage = true;
                    }
                },
                error: function() {
                    showMenuError('Terjadi kesalahan saat memuat menu.');
                    $('#load-more').addClass('d-none');
                    lastPage = true;
                },
                complete: function() {
                    loading = false;
                    $('#load-more').prop('disabled', false).html(
                        `<i class="bi bi-arrow-down-circle"></i> Muat Lebih Banyak`);
                }
            });
        }

        function showMenuError(message) {
            $('#menu-list').html(`
            <div class="col">
                <div class="alert alert-warning text-center w-100">${message}</div>
            </div>
        `);
        }

        jQuery(function($) {
            loadCategories();
            loadMenus();

            $('#load-more').on('click', function() {
                loadMenus();
            });

            $('#category-tabs').on('click', '.nav-link', function(e) {
                e.preventDefault();
                if ($(this).hasClass('active')) return; // Prevent reload if already active
                $('#category-tabs .nav-link').removeClass('active');
                $(this).addClass('active');
                category = ($(this).data('category') || '').trim();
                page = 1;
                lastPage = false;
                loadMenus(true);
            });

            $(window).on('scroll', function() {
                if (!lastPage && $(window).scrollTop() + $(window).height() + 100 >= $(document).height()) {
                    loadMenus();
                }
            });
        });

        $('#menu-search').on('input', function() {
            search = $(this).val().trim();
            page = 1;
            lastPage = false;
            loadMenus(true); // reset list
        });
    </script>

    <script>
        // --- Cart Logic ---
        let cart = {};
        // Load cart from localStorage
        if (localStorage.getItem('cart')) {
            cart = JSON.parse(localStorage.getItem('cart'));
        }

        function formatRupiah(angka) {
            return 'Rp' + angka.toLocaleString('id-ID');
        }

        function fetchCartFromDB() {
            const userId = localStorage.getItem('user_id');
            if (!userId) {
                updateCartDisplay([]);
                return;
            }
            fetch(`/api/v1/cart/user/${userId}`)
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'sukses') {
                        updateCartDisplay(data.data);
                    } else {
                        updateCartDisplay([]);
                    }
                })
                .catch(() => {
                    updateCartDisplay([]);
                });
        }


        function updateCartDisplay(items) {
            items = items || [];
            const cartItems = document.getElementById('cartItems');
            const cartCount = document.getElementById('cartCount');
            const checkoutBtn = document.getElementById('checkoutBtn');
            // const items = Object.entries(cart);

            let totalQty = 0;
            let totalHarga = 0;

            if (items.length === 0) {
                cartItems.innerHTML = '<p class="text-muted">Keranjang Anda kosong.</p>';
                checkoutBtn.disabled = true;
                cartCount.textContent = '0';
                return;
            }
            let html = items.map(item => {
                totalQty += item.quantity
                totalHarga += item.quantity * item.price;

                return `
            <div class="d-flex justify-content-between align-items-center mb-2">
            <div>
                <div class="fw-semibold">${item.name}</div>
                <small class="text-muted">${formatRupiah(item.price)} x ${item.quantity}</small>
            </div>
            <div>
                <button class="btn btn-sm btn-light border change-qty" data-id="${item.cart_id}" data-name="${item.name}" data-delta="-1" aria-label="Kurangi ${item.name}">-</button>
                <span class="mx-1">${item.quantity}</span>
                <button class="btn btn-sm btn-light border change-qty" data-id="${item.cart_id}" data-name="${item.name}" data-delta="1" aria-label="Tambah ${item.name}">+</button>
                <button class="btn btn-sm btn-danger ms-2 remove-item" data-id="${item.cart_id}" data-name="${item.name}" aria-label="Hapus ${item.name}"><i class="bi bi-trash"></i></button>
            </div>
            </div>`;
            }).join('');

            html += `
            <hr>
            <div class="d-flex justify-content-between fw-bold">
            <span>Total</span>
            <span>${formatRupiah(totalHarga)}</span>
            </div>`;

            cartItems.innerHTML = html;
            checkoutBtn.disabled = false;
            cartCount.textContent = totalQty;
        }

        function compressImage(file, quality = 0.6, maxWidth = 1280) {
            return new Promise((resolve) => {
                const reader = new FileReader();
                reader.readAsDataURL(file);

                reader.onload = (event) => {
                    const img = new Image();
                    img.src = event.target.result;

                    img.onload = () => {
                        const canvas = document.createElement('canvas');
                        const scale = Math.min(maxWidth / img.width, 1);
                        canvas.width = img.width * scale;
                        canvas.height = img.height * scale;

                        const ctx = canvas.getContext('2d');
                        ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

                        canvas.toBlob((blob) => {
                            const compressedFile = new File([blob], file.name, {
                                type: 'image/jpeg',
                                lastModified: Date.now(),
                            });
                            resolve(compressedFile);
                        }, 'image/jpeg', quality);
                    };
                };
            });
        }


        // --- Checkout Modal Form Handler (Sesuai validasi backend) ---
        document.addEventListener('DOMContentLoaded', function() {
            const checkoutForm = document.getElementById('checkoutForm');
            if (checkoutForm) {
                checkoutForm.addEventListener('submit', async function(e) {
                    e.preventDefault();

                    const form = e.target;
                    const formData = new FormData(form);

                    // Ambil user_id dari localStorage (atau window.LaravelUserId)
                    let userId = window.LaravelUserId ?? localStorage.getItem('user_id');
                    if (!userId) {
                        Swal.fire('Gagal!', 'Anda harus login.', 'error');
                        return;
                    }
                    formData.set('user_id', userId);

                    // Pastikan field sesuai validasi controller
                    if (!formData.get('delivery_date') || !formData.get('delivery_time') || !formData
                        .get('address')) {
                        Swal.fire('Gagal!', 'Mohon lengkapi data pengiriman.', 'error');
                        return;
                    }

                    // Validasi file bukti transfer (payment_proof)
                    const originalBukti = formData.get('bukti');
                    if (!originalBukti || !originalBukti.type.startsWith('image/')) {
                        Swal.fire('Gagal!', 'Bukti transfer harus berupa gambar.', 'error');
                        return;
                    }
                    const compressedBukti = await compressImage(originalBukti, 0.6); // 60% quality
                    formData.set('payment_proof', compressedBukti);
                    formData.delete('bukti');

                    try {
                        const response = await fetch('/api/v1/order/checkout', {
                            method: 'POST',
                            body: formData,
                        });

                        let result;
                        const contentType = response.headers.get('content-type');
                        if (contentType && contentType.indexOf('application/json') !== -1) {
                            result = await response.json();
                        } else {
                            Swal.fire('Gagal!', 'Terjadi kesalahan pada server.', 'error');
                            return;
                        }
                        if (response.ok && result.status === 'sukses') {
                            Swal.fire('Sukses!', 'Pesanan Anda berhasil dibuat! Nomor Pesanan: ' +
                                result.data.order_number, 'success');
                            form.reset();
                            // Hide modal
                            const modalEl = bootstrap.Modal.getInstance(document.getElementById(
                                'checkoutModal'));
                            if (modalEl) modalEl.hide();
                            updateCartDisplay([]);
                            fetchCartFromDB();
                        } else {
                            let msg = result.message || 'Terjadi kesalahan.';
                            // Jika ada detail validasi
                            if (result.errors) {
                                msg += '<ul class="text-start">';
                                for (const key in result.errors) {
                                    msg += `<li>${result.errors[key]}</li>`;
                                }
                                msg += '</ul>';
                            }
                            Swal.fire({
                                title: 'Gagal!',
                                html: msg,
                                icon: 'error'
                            });
                        }
                    } catch (err) {
                        Swal.fire('Gagal!', 'Gagal mengirim pesanan.', 'error');
                    }
                });
            }
        });

        document.getElementById('checkoutBtn').addEventListener('click', function() {
            const totalText = document.querySelector('#cartItems .fw-bold span:last-child')?.textContent || 'Rp0';
            document.getElementById('totalOrder').value = totalText;

            const modalEl = document.getElementById('checkoutModal');
            const modal = new bootstrap.Modal(modalEl);
            modal.show();
        });

        // Event delegation for cart actions
        document.getElementById('cartItems').addEventListener('click', function(e) {
            if (e.target.classList.contains('change-qty')) {
                const cartId = e.target.getAttribute('data-id');
                const delta = parseInt(e.target.getAttribute('data-delta'));
                const qtySpan = e.target.parentElement.querySelector('span');
                const currentQty = parseInt(qtySpan.innerText);
                const newQty = currentQty + delta;

                if (newQty <= 0) {
                    fetch(`/api/v1/cart/delete/${cartId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        }
                    }).then(() => {
                        fetchCartFromDB();
                    });
                } else {
                    fetch(`/api/v1/cart/update/${cartId}`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            quantity: newQty
                        })
                    }).then(() => {
                        fetchCartFromDB();
                    });
                }
            }

            if (e.target.classList.contains('remove-item')) {
                const cartId = e.target.getAttribute('data-id');
                fetch(`/api/v1/cart/delete/${cartId}`, {
                        method: 'DELETE'
                    })
                    .then(() => {
                        fetchCartFromDB();
                    })
                    .catch(() => {
                        fetchCartFromDB();
                    });
            }
        });

        // Add to cart using event delegation for dynamically loaded buttons
        document.getElementById('menu-list').addEventListener('click', function(e) {
            if (e.target.classList.contains('add-to-cart') || e.target.closest('.add-to-cart')) {
                const btn = e.target.classList.contains('add-to-cart') ? e.target : e.target.closest(
                    '.add-to-cart');
                const menuId = btn.getAttribute('data-id');
                const userId = window.LaravelUserId ?? localStorage.getItem('user_id');
                const price = parseInt(btn.getAttribute('data-price'));
                const minOrder = parseInt(btn.getAttribute('data-min-order')) || 1;

                if (!userId) {

                    //pakai sweetalert
                    Swal.fire({
                        title: 'Perhatian',
                        text: 'Anda harus login untuk menambahkan menu ke keranjang.',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                fetch('/api/v1/cart/add', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            user_id: userId,
                            menu_id: menuId,
                            quantity: minOrder
                        })
                    })
                    .then(res => res.json())
                    .then(res => {
                        if (res.status === 'sukses') {
                            Swal.fire({
                                title: 'Sukses',
                                text: 'Menu berhasil ditambahkan ke keranjang.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });

                            fetchCartFromDB();
                        } else {
                            Swal.fire({
                                title: 'Gagal',
                                text: res.message,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        Swal.fire({
                            title: 'Error',
                            text: 'Terjadi kesalahan saat menambahkan menu ke keranjang.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    });
            }
        });

        // Checkout button
        // document.getElementById('checkoutBtn').addEventListener('click', submitOrder);

        function previewImage(e) {
            const input = e.target;
            const preview = document.getElementById('buktiPreview');
            const file = input.files[0];
            if (file && file.type.startsWith('image/')) {
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
            const userId = localStorage.getItem('user_id'); // sesuaikan jika pakai auth
            const deliveryDate = document.getElementById('deliveryDate').value;
            const deliveryTime = document.getElementById('deliveryTime').value;
            const address = document.getElementById('address').value; // hidden input atau select
            const paymentMethod = 'transfer'; // atau dari dropdown
            const notes = document.getElementById('notes')?.value || '';
            const bukti = document.getElementById('buktiBayar').files[0];

            if (!userId || !deliveryDate || !deliveryTime || !address || !bukti) {
                Swal.fire({
                    title: 'Lengkapi Data',
                    text: 'Mohon isi semua data dan unggah bukti pembayaran.',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
                return;
            }

            if (!bukti.type.startsWith('image/')) {
                Swal.fire({
                    title: 'Format Salah',
                    text: 'Bukti pembayaran harus berupa gambar.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }

            const formData = new FormData();
            formData.append("user_id", userId);
            formData.append("delivery_date", deliveryDate);
            formData.append("delivery_time", deliveryTime);
            formData.append("address", address);
            formData.append("notes", notes);
            formData.append("payment_proof", bukti);

            Swal.fire({
                title: 'Sedang Diproses',
                text: 'Mohon tunggu, pesanan Anda sedang dikirim...',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch('/api/v1/order/checkout', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(res => {
                    if (res.status === 'sukses') {
                        Swal.fire({
                            title: 'Berhasil',
                            text: 'Pesanan Anda berhasil dibuat! Nomor Pesanan: ' + res.order_number,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            localStorage.removeItem('cart');
                            cart = {};
                            fetchCartFromDB();

                            // Optional: redirect
                            // window.location.href = '/order/success';
                        });
                    } else {
                        Swal.fire({
                            title: 'Gagal',
                            text: res.message || 'Terjadi kesalahan saat memproses pesanan.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(err => {
                    Swal.fire({
                        title: 'Error',
                        text: 'Terjadi kesalahan saat menyimpan pesanan.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                });
        }


        fetchCartFromDB();
    </script>
@endpush
