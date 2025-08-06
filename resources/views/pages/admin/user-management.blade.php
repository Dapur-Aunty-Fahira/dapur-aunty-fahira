@extends('layouts.app')
@section('title', 'Kelola Akun')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0">Kelola Akun</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                        <li class="breadcrumb-item active">Kelola Akun</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-gradient-pink text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0 font-weight-bold">
                            <i class="fas fa-users mr-2"></i>Daftar Pengguna
                        </h3>
                        <button class="btn btn-light btn-sm font-weight-bold shadow-sm" id="btn-add">
                            <i class="fas fa-plus mr-1"></i>Tambah Pengguna
                        </button>
                    </div>
                </div>
                <div class="card-body bg-light rounded-bottom">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered mb-0" id="users-table" style="width:100%">
                            <thead class="thead-pink">
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Role</th>
                                    <th style="width:120px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="userModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form id="userForm">
                @csrf
                <input type="hidden" name="user_id" id="user_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="userModalTitle">Tambah Pengguna</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" name="phone" id="phone" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Role</label>
                            <select name="role" id="role" class="form-control" required>
                                <option value="">-- Pilih Role --</option>
                                <option value="admin">Admin</option>
                                <option value="pengguna">Pengguna</option>
                                <option value="kurir">Kurir</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" id="password" class="form-control" maxlength="60">
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah password.</small>
                        </div>
                        <div class="form-group">
                            <label>Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control" maxlength="60">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-light">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <style>
        .bg-gradient-pink {
            background: linear-gradient(90deg, #ec4899 0%, #f472b6 100%) !important;
        }

        .thead-pink th {
            background-color: #f9a8d4 !important;
            color: #fff !important;
        }

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
@endsection

@push('scripts')
    <script>
        $(function() {
            let table = $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.users.show') }}",
                columns: [{
                        data: null,
                        render: (data, type, row, meta) => meta.row + meta.settings._iDisplayStart + 1
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'phone'
                    },
                    {
                        data: 'role'
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: (data, type, row) => `
                    <div class="dropdown text-center">
                        <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item btn-edit" href="#" data-user_id="${row.user_id}"><i class="fas fa-edit mr-2"></i>Edit</a>
                            <a class="dropdown-item btn-delete" href="#" data-user_id="${row.user_id}"><i class="fas fa-trash-alt mr-2"></i>Hapus</a>
                        </div>
                    </div>`
                    }
                ]
            });

            $('#btn-add').on('click', function() {
                $('#userModalTitle').text('Tambah Pengguna');
                $('#userForm')[0].reset();
                $('#user_id').val('');
                $('.form-control').removeClass('is-invalid');
                $('.invalid-feedback').remove();
                $('#userModal').modal('show');
            });

            $('#users-table').on('click', '.btn-edit', function(e) {
                e.preventDefault();
                let id = $(this).data('user_id');
                $.get(`/admin/users/${id}`, function(res) {
                    $('#user_id').val(res.data.user_id);
                    $('#name').val(res.data.name);
                    $('#email').val(res.data.email);
                    $('#phone').val(res.data.phone);
                    $('#role').val(res.data.role);
                    $('#password').val('');
                    $('#password_confirmation').val('');
                    $('#userModalTitle').text('Edit Pengguna');
                    $('.form-control').removeClass('is-invalid');
                    $('.invalid-feedback').remove();
                    $('#userModal').modal('show');
                });
            });

            $('#userForm').submit(function(e) {
                e.preventDefault();
                let id = $('#user_id').val();

                let isUpdate = !!id;
                let url = isUpdate ?
                    `/admin/users/${id}` // Dynamic URL for update
                    :
                    `{{ route('admin.users.store') }}`; // Static URL for create

                let formData = $(this).serializeArray();

                // Spoof HTTP method if updating
                if (isUpdate) {
                    formData.push({
                        name: '_method',
                        value: 'PUT'
                    });
                }

                $('.form-control').removeClass('is-invalid');
                $('.invalid-feedback').remove();

                $.ajax({
                    url: url,
                    method: 'POST', // always POST, spoof with _method
                    data: formData,
                    success: function(res) {
                        $('#userModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: res.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                        table.ajax.reload();
                    },
                    error: function(xhr) {
                        if (xhr.status === 422 && xhr.responseJSON.errors) {
                            $('.form-control').removeClass('is-invalid');
                            $('.invalid-feedback').remove();

                            $.each(xhr.responseJSON.errors, function(field, msg) {
                                let input = $(`[name="${field}"]`);
                                input.addClass('is-invalid');
                                input.closest('.form-group').append(`
                        <div class="invalid-feedback d-block">${msg[0]}</div>
                    `);
                            });

                            Swal.fire({
                                icon: 'error',
                                title: 'Validasi Gagal',
                                text: 'Silakan periksa input Anda'
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Terjadi kesalahan sistem'
                            });
                        }
                    }
                });
            });


            $('#users-table').on('click', '.btn-delete', function(e) {
                e.preventDefault();
                let id = $(this).data('user_id');

                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: 'Data tidak bisa dikembalikan!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ec4899',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/users/${id}`,
                            type: 'DELETE',
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function() {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Terhapus!',
                                    text: 'Data berhasil dihapus.',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                                table.ajax.reload();
                            },
                            error: function() {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: 'Gagal menghapus data.'
                                });
                            }
                        });
                    }
                });
            });

            $('#userModal').on('hidden.bs.modal', function() {
                $('#userForm')[0].reset();
                $('#user_id').val('');
                $('.form-control').removeClass('is-invalid');
                $('.invalid-feedback').remove();
            });
        });
    </script>
@endpush
