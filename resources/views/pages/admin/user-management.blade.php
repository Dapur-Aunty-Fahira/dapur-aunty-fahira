@extends('layouts.app')
@section('title', 'Kelola Akun')

@section('content')
    <!-- Content Header (Page header) -->
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
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card shadow-sm border-0">
                <div class="card-header d-flex justify-content-between align-items-center bg-gradient-pink text-white"
                    style="background: linear-gradient(90deg, #ec4899 0%, #f472b6 100%);">
                    <h3 class="card-title mb-0 font-weight-bold"><i class="fas fa-users mr-2"></i>Daftar Pengguna</h3>
                    <div class="ml-auto">
                        <a href="#" class="btn btn-light btn-sm font-weight-bold shadow-sm">
                            <i class="fas fa-plus mr-1"></i>Tambah Pengguna
                        </a>
                    </div>
                </div>
                <div class="card-body bg-light rounded-bottom">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered mb-0" id="users-table" style="width:100%">
                            <thead class="thead-pink" style="background-color: #f9a8d4; color: #fff;">
                                <tr>
                                    <th style="width:40px;">No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Role</th>
                                    <th style="width:120px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be loaded by DataTables AJAX -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <style>
        .bg-gradient-pink {
            background: linear-gradient(90deg, #ec4899 0%, #f472b6 100%) !important;
        }

        .thead-pink th {
            background-color: #f9a8d4 !important;
            color: #fff !important;
        }

        .card-title i {
            color: #fff;
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
    @push('scripts')
        <script>
            $(function() {
                let table = $('#users-table').DataTable({
                    processing: true,
                    serverSide: true,
                    searchable: true,
                    responsive: true,
                    ajax: "{{ route('admin.users.show') }}",
                    columns: [{
                            data: null,
                            name: 'No',
                            orderable: false,
                            searchable: false,
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'phone',
                            name: 'phone'
                        },
                        {
                            data: 'role',
                            name: 'role'
                        },
                        {
                            data: null,
                            name: 'action',
                            orderable: false,
                            searchable: false,
                            render: function(data, type, row) {
                                let editUrl = `/admin/users/${row.id}/edit`;
                                let deleteUrl = `/admin/users/${row.id}`;
                                return `
                                    <div class="dropdown d-flex justify-content-center">
                                        <button class="btn btn-sm btn-light dropdown-toggle" type="button" id="dropdownMenuButton${row.id}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton${row.id}">
                                            <a class="dropdown-item" href="${editUrl}"><i class="fas fa-edit mr-2"></i>Edit</a>
                                            <a class="dropdown-item btn-delete" href="${deleteUrl}"><i class="fas fa-trash-alt mr-2"></i>Delete</a>
                                        </div>
                                    </div>
                                `;
                            }
                        }
                    ]
                });

                // Optional: handle delete with confirmation
                $('#users-table').on('click', '.btn-delete', function(e) {
                    e.preventDefault();
                    let url = $(this).attr('href');
                    if (confirm('Yakin ingin menghapus?')) {
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(res) {
                                table.ajax.reload();
                            },
                            error: function() {
                                alert('Gagal menghapus data.');
                            }
                        });
                    }
                });
            });
        </script>
    @endpush
@endsection
