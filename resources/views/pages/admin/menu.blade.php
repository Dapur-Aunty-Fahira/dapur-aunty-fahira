@extends('layouts.app')

@section('title', 'Menu')

@section('content')
    <style>
        /* Custom styles for better UI */
        #categoryTable th,
        #categoryTable td {
            vertical-align: middle;
        }

        #categoryTable .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.9em;
        }

        #menuCards {
            max-height: 60vh;
            overflow-y: auto;
        }

        .card-title {
            font-size: 1.1em;
            font-weight: 600;
        }

        .object-fit-cover {
            object-fit: cover;
        }

        .swal2-popup ul {
            margin: 0 0 0 1.2em;
            padding: 0;
            text-align: left;
        }

        .input-group input:focus,
        .form-control:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.1rem rgba(0, 123, 255, .25);
        }

        .btn-close {
            background: none;
            border: none;
            font-size: 1.3rem;
        }

        .modal-header {
            border-bottom: 1px solid #e9ecef;
        }

        .modal-footer {
            border-top: 1px solid #e9ecef;
        }

        .card {
            transition: box-shadow 0.2s;
        }

        .card:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08);
        }

        .fw-bold {
            font-weight: 600 !important;
        }

        .me-1 {
            margin-right: 0.25rem !important;
        }

        .text-truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0">Menu</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                        <li class="breadcrumb-item active">Menu</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Left: Category DataTable -->
                <div class="col-md-4">
                    <div class="mb-3">
                        <div class="input-group">
                            <input type="text" id="newCategoryName" class="form-control"
                                placeholder="Input kategori baru...">
                            <button id="addCategoryBtn" class="btn btn-light btn-sm font-weight-bold shadow-sm"><i
                                    class="fas fa-plus"></i> Add</button>
                        </div>
                    </div>
                    <div class="card shadow-sm">
                        <div class="card-header bg-light">
                            <strong>Daftar Kategori</strong>
                        </div>
                        <div class="card-body">
                            <table id="categoryTable" class="table table-bordered table-striped mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nama</th>
                                        <th style="width:90px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Right: Menu Cards -->
                <div class="col-md-8">
                    <div class="d-flex flex-wrap align-items-center mb-4 justify-content-between">
                        <div class="d-flex align-items-center gap-2">
                            <h4 class="m-2 me-3 fw-bold text-pink">Daftar Menu</h4>
                            <button class="btn btn-light btn-sm fw-bold shadow-sm border-pink" id="addMenuBtn"
                                title="Tambah Menu">
                                <i class="fas fa-plus"></i> <span class="d-none d-md-inline">Add</span>
                            </button>
                        </div>
                        <div class="input-group" style="max-width: 340px;">
                            <input type="text" class="form-control border-pink" id="searchMenuInput"
                                placeholder="Cari nama menu...">
                            <span class="input-group-text bg-white border-pink"><i
                                    class="fas fa-search text-pink"></i></span>
                        </div>
                    </div>
                    <div class="row g-3" id="menuCards"></div>
                    <div id="menuLoading" class="text-center py-4 d-none">
                        <div class="spinner-border text-pink" role="status"></div>
                        <div class="small mt-2 text-muted">Memuat menu...</div>
                    </div>
                    <div id="menuEmpty" class="text-center py-5 text-muted d-none">
                        <i class="fas fa-utensils fa-2x mb-3 text-pink"></i>
                        <div class="fw-semibold">Belum ada menu ditemukan.</div>
                    </div>
                </div>
                <style>
                    .text-pink {
                        color: #ec4899 !important;
                    }

                    .border-pink {
                        border-color: #f9a8d4 !important;
                    }

                    .fw-semibold {
                        font-weight: 500 !important;
                    }

                    #menuCards .card {
                        border-radius: 1rem;
                        box-shadow: 0 2px 12px rgba(236, 72, 153, 0.07);
                        border: 1px solid #f9a8d4;
                    }

                    #menuCards .card:hover {
                        box-shadow: 0 4px 24px rgba(236, 72, 153, 0.13);
                        border-color: #ec4899;
                    }

                    #menuCards .card-title {
                        color: #ec4899;
                    }

                    #menuCards .btn-light {
                        border-color: #f9a8d4 !important;
                        color: #ec4899 !important;
                        background: #fff !important;
                    }

                    #menuCards .btn-light:hover {
                        background: #f9a8d4 !important;
                        color: #fff !important;
                        border-color: #ec4899 !important;
                    }

                    #searchMenuInput:focus {
                        border-color: #ec4899 !important;
                        box-shadow: 0 0 0 0.1rem rgba(236, 72, 153, .15);
                    }
                </style>
                <script>
                    // Improve search: filter by name or category
                    function filterMenuCards(keyword) {
                        const cards = document.querySelectorAll('#menuCards .card');
                        keyword = keyword.toLowerCase();
                        let found = false;
                        cards.forEach(card => {
                            const title = card.querySelector('.card-title').innerText.toLowerCase();
                            const category = card.querySelector('.fa-tag')?.parentNode?.innerText?.toLowerCase() || '';
                            if (title.includes(keyword) || category.includes(keyword)) {
                                card.closest('.col-md-6, .col-lg-4').style.display = '';
                                found = true;
                            } else {
                                card.closest('.col-md-6, .col-lg-4').style.display = 'none';
                            }
                        });
                        document.getElementById('menuEmpty').classList.toggle('d-none', found || keyword === '');
                    }
                    // Show empty state if no menu cards
                    function checkMenuEmpty() {
                        const cards = document.querySelectorAll('#menuCards .card:visible');
                        document.getElementById('menuEmpty').classList.toggle('d-none', cards.length > 0);
                    }
                    document.addEventListener('DOMContentLoaded', function() {
                        document.getElementById('searchMenuInput').addEventListener('input', function() {
                            filterMenuCards(this.value.trim());
                            checkMenuEmpty();
                        });
                    });
                </script>
            </div>
        </div>
    </section>

    <style>
        .btn-light {
            color: #ec4899 !important;
            border-color: #f9a8d4 !important;
            background: #fff !important;
        }

        .btn-light:hover {
            background: #f9a8d4 !important;
            color: #fff !important;
            border-color: #ec4899 !important;
        }
    </style>

    <!-- Modal Menu -->
    <div class="modal fade" id="menuModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form id="menuForm" class="modal-content" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="menuModalTitle">Tambah Menu</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="menuId">
                    <div class="form-group mb-3">
                        <label>Nama Menu</label>
                        <input type="text" id="menuName" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Kategori</label>
                        <select id="menuCategory" class="form-control" required></select>
                    </div>
                    <div class="form-group mb-3">
                        <label>Harga</label>
                        <input type="number" step="0.01" id="menuPrice" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Minimal Order</label>
                        <input type="number" min="1" id="menuMinOrder" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Deskripsi</label>
                        <textarea id="menuDescription" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label>Gambar</label>
                        <input type="file" id="menuImage" class="form-control" accept="image/*">
                        <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar.</small>
                        <div id="menuImagePreview" class="mt-2"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
    @push('scripts')
        <script>
            let categoryTable;
            let currentPage = 1,
                isLoading = false,
                hasMore = true;

            document.addEventListener('DOMContentLoaded', function() {
                fetchCategories();
                fetchMenus();
                document.getElementById('searchMenuInput').addEventListener('input', function() {
                    const keyword = this.value.trim().toLowerCase();
                    filterMenuCards(keyword);
                });
                document.getElementById('addCategoryBtn').addEventListener('click', addCategory);
                document.getElementById('addMenuBtn').addEventListener('click', openMenuModal);
                $('#menuForm').on('submit', saveMenu);

                // Infinite scroll for menu cards
                const menuCards = document.getElementById('menuCards');
                menuCards.addEventListener('scroll', function() {
                    if (menuCards.scrollTop + menuCards.clientHeight >= menuCards.scrollHeight - 10) {
                        if (hasMore && !isLoading) fetchMenus(currentPage + 1, true);
                    }
                });
            });

            function handleFetchError(error, fallbackMsg = 'Terjadi kesalahan. Silakan coba lagi.') {
                console.error(error);
                if (error.validation) {
                    let html = '<ul class="text-left">';
                    Object.values(error.validation).forEach(msgArr => {
                        msgArr.forEach(msg => html += `<li>${msg}</li>`);
                    });
                    html += '</ul>';
                    Swal.fire({
                        title: 'Validasi Gagal',
                        html,
                        icon: 'error'
                    });
                } else {
                    Swal.fire('Error', fallbackMsg, 'error');
                }
            }

            function parseValidationError(res) {
                return res.json().then(data => {
                    if (data.errors) {
                        throw {
                            validation: data.errors
                        };
                    }
                    throw new Error(data.error || 'Terjadi kesalahan');
                });
            }

            function fetchCategories(showSuccess = false) {
                if (categoryTable) {
                    categoryTable.clear().destroy();
                    categoryTable = null;
                }
                fetch("{{ route('admin.category.all') }}")
                    .then(res => {
                        if (!res.ok) throw new Error('Gagal memuat kategori');
                        return res.json();
                    })
                    .then(data => {
                        const tbody = document.querySelector('#categoryTable tbody');
                        const select = document.getElementById('menuCategory');
                        tbody.innerHTML = '';
                        select.innerHTML = '<option value="">Pilih Kategori</option>';
                        data.forEach(cat => {
                            tbody.innerHTML += `
                                <tr>
                                    <td>${cat.name}</td>
                                    <td>
                                        <button class="btn btn-sm btn-light" onclick="editCategory(${cat.category_id}, '${cat.name.replace(/'/g, "\\'")}')"><i class="fas fa-pen"></i></button>
                                        <button class="btn btn-sm btn-light" onclick="deleteCategory(${cat.category_id})"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>`;
                            select.innerHTML += `<option value="${cat.category_id}">${cat.name}</option>`;

                        });
                        categoryTable = $('#categoryTable').DataTable({
                            paging: true,
                            searching: true,
                            pageLength: 5,
                            lengthChange: false,
                            order: [],
                            info: false

                        });
                        if (showSuccess) {
                            Swal.fire('Berhasil', 'Kategori berhasil ditambahkan', 'success');
                        }
                    })
                    .catch(err => handleFetchError(err, 'Gagal memuat kategori'));
            }

            function addCategory() {
                const name = document.getElementById('newCategoryName').value.trim();
                if (!name) return Swal.fire('Peringatan', 'Nama category tidak boleh kosong', 'warning');
                fetch("{{ route('admin.category.store') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            name
                        })
                    })
                    .then(res => {
                        if (!res.ok) return parseValidationError(res);
                        return res.json();
                    })
                    .then(() => {
                        document.getElementById('newCategoryName').value = '';
                        fetchCategories(true);
                    })
                    .catch(err => handleFetchError(err, 'Gagal menambah kategori'));
            }

            function editCategory(id, name) {
                console.log('id:', id, 'name:', name);

                Swal.fire({
                    title: 'Edit Nama Kategori',
                    input: 'text',
                    inputValue: name,
                    showCancelButton: true,
                    confirmButtonText: 'Simpan',
                    cancelButtonText: 'Batal',
                    inputValidator: (value) => {
                        if (!value) return 'Nama category tidak boleh kosong';
                        if (value === name) return 'Nama tidak berubah';
                    }
                }).then((result) => {
                    if (result.isConfirmed && result.value && result.value.trim() !== '' && result.value !== name) {
                        fetch(`/admin/category/update/${id}`, {
                                method: 'PUT',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    name: result.value
                                })
                            })
                            .then(res => {
                                if (!res.ok) return parseValidationError(res);
                                return res.json();
                            })
                            .then(() => {
                                fetchCategories();
                                Swal.fire('Berhasil', 'Kategori berhasil diubah', 'success');
                            })
                            .catch(err => handleFetchError(err, 'Gagal mengubah kategori'));
                    }
                });
            }

            function deleteCategory(id) {
                Swal.fire({
                    title: 'Hapus kategori ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/admin/category/destroy/${id}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            })
                            .then(res => {
                                if (!res.ok) return parseValidationError(res);
                            })
                            .then(() => {
                                fetchCategories();
                                Swal.fire('Berhasil', 'Kategori berhasil dihapus', 'success');
                            })
                            .catch(err => handleFetchError(err, 'Gagal menghapus kategori'));
                    }
                });
            }

            function fetchMenus(page = 1, append = false) {
                if (isLoading || (!hasMore && append)) return;
                isLoading = true;
                fetch(`{{ route('admin.menu.list') }}?page=${page}`)
                    .then(res => {
                        if (!res.ok) throw new Error('Gagal memuat menu');
                        return res.json();
                    })
                    .then(data => {
                        const container = document.getElementById('menuCards');
                        if (!append) container.innerHTML = '';
                        data.data.forEach(menu => {
                            container.innerHTML += renderMenuCard(menu);
                        });
                        hasMore = data.current_page < data.last_page;
                        currentPage = data.current_page;
                        isLoading = false;
                    })
                    .catch(err => {
                        isLoading = false;
                        handleFetchError(err, 'Gagal memuat menu');
                    });
            }

            function getMenuImageUrl(menu) {
                // Prioritaskan image_url jika valid URL (http/https)
                if (
                    menu.image_url &&
                    typeof menu.image_url === 'string' &&
                    (menu.image_url.startsWith('http://') || menu.image_url.startsWith('https://'))
                ) {
                    return menu.image_url;
                }

                // Jika image berupa URL penuh (http/https), gunakan langsung
                if (
                    menu.image &&
                    typeof menu.image === 'string' &&
                    (menu.image.startsWith('http://') || menu.image.startsWith('https://'))
                ) {
                    return menu.image;
                }
                // Jika image berupa path relatif (misal: menus/xxx.jpg), buat URL ke storage
                if (
                    menu.image &&
                    typeof menu.image === 'string' &&
                    !menu.image.startsWith('C:\\')
                ) {
                    return `/storage/${menu.image.replace(/\\/g, '/')}`;
                }

                // Jika image_url ada tapi bukan URL valid, atau image berupa path lokal sementara (C:\...), tampilkan gambar default lokal
                return 'https://placehold.co/300x180?text=No+Image';
            }

            function renderMenuCard(menu) {
                return `
                    <div class="col-md-6 col-lg-4 mb-3" id="menuCard-${menu.menu_id}">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="position-relative" style="height:180px;overflow:hidden;background:#f8f9fa;">
                                <img src="${getMenuImageUrl(menu)}" alt="${menu.name}" class="w-100 h-100 object-fit-cover" style="object-fit:cover;">
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title mb-1 text-truncate" title="${menu.name}">${menu.name}</h5>
                                <p class="mb-1 text-muted" style="font-size:0.95em;">
                                    <i class="fas fa-tag"></i> ${menu.category?.name || '-'}
                                </p>
                                <p class="mb-2" style="min-height:40px;font-size:0.95em;color:#555;">
                                    ${menu.description ? menu.description : '<span class="text-muted">Tidak ada deskripsi</span>'}
                                </p>
                                <p class="mb-2" style="min-height:40px;font-size:0.95em;color:#555;">
                                    Minimal Order: ${menu.min_order ? menu.min_order : '<span class="text-muted">Tidak ada batasan minimal</span>'} pcs
                                </p>
                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                    <span class="fw-bold text-success" style="font-size:1.1em;">
                                        Rp. ${Number(menu.price).toLocaleString('id-ID')}
                                    </span>
                                    <div>
                                        <button class="btn btn-sm btn-light me-1" onclick="editMenu(${menu.menu_id})" title="Edit"><i class='fas fa-pen'></i></button>
                                        <button class="btn btn-sm btn-light" onclick="deleteMenu(${menu.menu_id})" title="Hapus"><i class='fas fa-trash'></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;
            }

            function openMenuModal() {
                document.getElementById('menuId').value = '';
                document.getElementById('menuName').value = '';
                document.getElementById('menuCategory').value = '';
                document.getElementById('menuPrice').value = '';
                document.getElementById('menuMinOrder').value = '';
                document.getElementById('menuDescription').value = '';
                document.getElementById('menuImage').value = '';
                document.getElementById('menuImagePreview').innerHTML = '';
                document.getElementById('menuModalTitle').innerText = 'Tambah Menu';
                clearMenuFormErrors();
                $('#menuModal').modal('show');
            }

            function editMenu(id) {
                fetch(`{{ url('/admin/menu') }}/${id}`)
                    .then(res => {
                        if (!res.ok) throw new Error('Gagal memuat data menu');
                        return res.json();
                    })
                    .then(menu => {
                        document.getElementById('menuId').value = menu.menu_id;
                        document.getElementById('menuName').value = menu.name;
                        document.getElementById('menuCategory').value = menu.category_id;
                        document.getElementById('menuPrice').value = menu.price;
                        document.getElementById('menuMinOrder').value = menu.min_order ?? '';
                        document.getElementById('menuDescription').value = menu.description ?? '';
                        document.getElementById('menuImage').value = '';
                        document.getElementById('menuImagePreview').innerHTML =
                            `<img src="${menu.image_url || 'https://placehold.co/300x180?text=No+Image'}" alt="Gambar Menu" class="img-fluid rounded" style="max-height:120px;">`;
                        document.getElementById('menuModalTitle').innerText = 'Edit Menu';
                        clearMenuFormErrors();
                        $('#menuModal').modal('show');
                    })
                    .catch(err => handleFetchError(err, 'Gagal memuat data menu'));
            }

            function clearMenuFormErrors() {
                // Remove all error messages and error classes
                document.querySelectorAll('.invalid-feedback.menu-error').forEach(e => e.remove());
                document.querySelectorAll('#menuForm .form-control').forEach(input => {
                    input.classList.remove('is-invalid');
                });
            }

            function showMenuFormErrors(errors) {
                clearMenuFormErrors();
                for (const key in errors) {
                    const input = document.getElementById('menu' + key.charAt(0).toUpperCase() + key.slice(1));
                    if (input) {
                        input.classList.add('is-invalid');
                        let errorDiv = document.createElement('div');
                        errorDiv.className = 'invalid-feedback menu-error';
                        errorDiv.innerText = errors[key][0];
                        // Insert after input
                        if (input.nextElementSibling && input.nextElementSibling.classList.contains('invalid-feedback')) {
                            input.parentNode.replaceChild(errorDiv, input.nextElementSibling);
                        } else {
                            input.parentNode.appendChild(errorDiv);
                        }
                    }
                }
            }

            function saveMenu(e) {
                e.preventDefault();
                clearMenuFormErrors();
                const id = document.getElementById('menuId').value;
                const name = document.getElementById('menuName').value.trim();
                const category_id = document.getElementById('menuCategory').value;
                const price = document.getElementById('menuPrice').value;
                const min_order = document.getElementById('menuMinOrder').value;
                const description = document.getElementById('menuDescription').value;
                const imageInput = document.getElementById('menuImage');
                if (!name || !category_id || !price || !min_order) {
                    if (!name) showMenuFormErrors({
                        name: ['Nama wajib diisi']
                    });
                    if (!category_id) showMenuFormErrors({
                        category: ['Kategori wajib diisi']
                    });
                    if (!price) showMenuFormErrors({
                        price: ['Harga wajib diisi']
                    });
                    if (!min_order) showMenuFormErrors({
                        minOrder: ['Minimal order wajib diisi']
                    });
                    Swal.fire('Peringatan', 'Nama, kategori, harga, dan minimal order wajib diisi', 'warning');
                    return;
                }
                const url = id ? `/admin/menu/update/${id}` : `{{ route('admin.menu.store') }}`;
                const method = id ? 'POST' : 'POST';
                const formData = new FormData();
                formData.append('name', name);
                formData.append('category_id', category_id);
                formData.append('price', price);
                formData.append('min_order', min_order);
                formData.append('description', description);
                if (imageInput.files.length > 0) {
                    formData.append('image', imageInput.files[0]);
                }
                if (id) {
                    formData.append('_method', 'PUT');
                }
                formData.append('_token', '{{ csrf_token() }}');

                Swal.fire({
                    title: id ? 'Menyimpan perubahan menu...' : 'Menyimpan menu baru...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                fetch(url, {
                        method: method,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: formData
                    })
                    .then(res => {
                        if (!res.ok) {
                            // Handle both Laravel and custom error format
                            return res.json().then(data => {
                                let messages = null;
                                if (data.errors) {
                                    messages = data.errors;
                                } else if (data.messages) {
                                    messages = data.messages;
                                }
                                if (messages) {
                                    showMenuFormErrors(messages);
                                    let html = '<ul class="text-left">';
                                    Object.values(messages).forEach(msgArr => {
                                        msgArr.forEach(msg => html += `<li>${msg}</li>`);
                                    });
                                    html += '</ul>';
                                    Swal.fire({
                                        title: 'Validasi Gagal',
                                        html,
                                        icon: 'error'
                                    });
                                    throw new Error('Validation error');
                                }
                                throw new Error(data.message || data.error || 'Terjadi kesalahan');
                            });
                        }
                        return res.json();
                    })
                    .then(() => {
                        Swal.fire({
                            icon: 'success',
                            title: id ? 'Menu berhasil diubah!' : 'Menu berhasil ditambahkan!',
                            showConfirmButton: false,
                            timer: 1400
                        });
                        $('#menuModal').modal('hide');
                        fetchMenus();
                    })
                    .catch(err => {
                        if (err.message !== 'Validation error') {
                            handleFetchError(err, 'Gagal menyimpan menu');
                        }
                    });
            }

            // Preview image on file input change
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('menuImage').addEventListener('change', function(e) {
                    const preview = document.getElementById('menuImagePreview');
                    preview.innerHTML = '';
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function(ev) {
                            preview.innerHTML =
                                `<img src="${ev.target.result}" alt="Preview" class="img-fluid rounded" style="max-height:120px;">`;
                        };
                        reader.readAsDataURL(this.files[0]);
                    }
                });
            });

            function deleteMenu(id) {
                Swal.fire({
                    title: 'Hapus menu ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/admin/menu/destroy/${id}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            })
                            .then(res => {
                                if (!res.ok) return parseValidationError(res);
                            })
                            .then(() => {
                                document.getElementById(`menuCard-${id}`)?.remove();
                            })
                            .catch(err => handleFetchError(err, 'Gagal menghapus menu'));
                    }
                });
            }

            function filterMenuCards(keyword) {
                const cards = document.querySelectorAll('#menuCards .card');
                cards.forEach(card => {
                    const title = card.querySelector('.card-title').innerText.toLowerCase();
                    if (title.includes(keyword)) {
                        card.closest('.col-md-6').style.display = '';
                    } else {
                        card.closest('.col-md-6').style.display = 'none';
                    }
                });
            }
        </script>
    @endpush
@endsection
