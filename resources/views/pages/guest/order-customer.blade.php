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
        let page = 1;
        let category = '';
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
                                            <button class="btn btn-sm btn-outline-danger w-100 add-to-cart" data-id="${menu.menu_id}" data-name="${menu.name}" data-price="${menu.price}">
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

        $(function() {
            loadCategories();
            loadMenus();

            $('#load-more').on('click', function() {
                loadMenus();
            });

            $('#category-tabs').on('click', '.nav-link', function(e) {
                e.preventDefault();
                $('#category-tabs .nav-link').removeClass('active');
                $(this).addClass('active');
                category = $(this).data('category');
                loadMenus(true);
            });

            $(window).on('scroll', function() {
                if (!lastPage && $(window).scrollTop() + $(window).height() + 100 >= $(document).height()) {
                    loadMenus();
                }
            });
        });
    </script>
@endpush
