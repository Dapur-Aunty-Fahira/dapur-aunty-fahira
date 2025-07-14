@extends('layouts.app')
@section('title', 'Laporan')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-3 align-items-center">
                <div class="col-md-6">
                    <h1 class="m-0 font-weight-bold text-dark">Laporan</h1>
                </div>
                <div class="col-md-6 text-md-right mt-2 mt-md-0">
                    <ol class="breadcrumb justify-content-md-end mb-0 bg-transparent">
                        <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                        <li class="breadcrumb-item active">Laporan</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card border-0 shadow-sm rounded-lg">
                <div class="card-header bg-gradient-pink text-white py-3">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-md-6">
                            <h3 class="mb-0 font-weight-bold">
                                <i class="fas fa-file-alt mr-2"></i>Laporan Pesanan
                            </h3>
                        </div>
                        <div class="col-md-4">
                            <label for="filter-status" class="mb-1 small text-white">Filter Status Order:</label>
                            <select id="filter-status" class="form-control form-control-sm shadow-sm">
                                <option value="">Semua Status</option>
                                <option value="menunggu konfirmasi">Menunggu Konfirmasi</option>
                                <option value="diproses">Diproses</option>
                                <option value="dikirim">Dikirim</option>
                                <option value="selesai">Selesai</option>
                                <option value="dibatalkan">Dibatalkan</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body bg-white rounded-bottom p-4">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-striped w-100" id="reports-table">
                            <thead class="thead-pink text-center">
                                <tr>
                                    <th>No</th>
                                    <th>No Pesanan</th>
                                    <th>Nama</th>
                                    <th>Menu</th>
                                    <th>Jumlah</th>
                                    <th>Total Harga</th>
                                    <th>Tanggal Kirim</th>
                                    <th>Jam Kirim</th>
                                    <th>Alamat</th>
                                    <th>Status</th>
                                    <th>Waktu Buat</th>
                                    <th>Waktu Update</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .bg-gradient-pink {
            background: linear-gradient(90deg, #ec4899, #f472b6) !important;
        }

        .thead-pink th {
            background-color: #f472b6 !important;
            color: #fff !important;
            font-weight: 600;
            font-size: 0.9rem;
            white-space: nowrap;
        }

        #filter-status {
            border-radius: 0.4rem;
            border: none;
        }

        #filter-status:focus {
            box-shadow: 0 0 0 0.2rem rgba(236, 72, 153, 0.25);
        }

        table.dataTable td {
            font-size: 0.85rem;
            vertical-align: middle;
        }

        table.dataTable tbody tr:hover {
            background-color: #fff0f6 !important;
        }
    </style>
@endsection

@push('scripts')
    <script>
        $(function() {
            let table = $('#reports-table').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                lengthChange: true,
                pageLength: 10,
                order: [],
                ajax: {
                    url: "{{ route('admin.report.show') }}",
                    data: function(d) {
                        d.order_status = $('#filter-status').val();
                    }
                },
                columns: [{
                        data: null,
                        render: (data, type, row, meta) => meta.row + meta.settings._iDisplayStart + 1,
                        className: 'text-center'
                    },
                    {
                        data: 'order_number'
                    },
                    {
                        data: 'user_name'
                    },
                    {
                        data: 'menu_list'
                    },
                    {
                        data: 'total_quantity',
                        className: 'text-center'
                    },
                    {
                        data: 'total_price',
                        className: 'text-right',
                        render: function(data) {
                            return 'Rp ' + parseInt(data).toLocaleString('id-ID');
                        }
                    },
                    {
                        data: 'delivery_date',
                        className: 'text-center'
                    },
                    {
                        data: 'delivery_time',
                        className: 'text-center'
                    },
                    {
                        data: 'full_address'
                    },
                    {
                        data: 'order_status',
                        className: 'text-center',
                        render: function(data) {

                            let badgeClass = {
                                'menunggu konfirmasi': 'badge-warning',
                                'diproses': 'badge-info',
                                'dikirim': 'badge-primary',
                                'selesai': 'badge-success',
                                'dibatalkan': 'badge-danger'
                            } [data] || 'badge-secondary';
                            return `<span class="badge ${badgeClass} text-capitalize">${data}</span>`;
                        }
                    },
                    {
                        data: 'created_at',
                        className: 'text-center'
                    },
                    {
                        data: 'updated_at',
                        className: 'text-center'
                    }
                ]
            });

            $('#filter-status').on('change', function() {
                table.ajax.reload();
            });
        });
    </script>
@endpush
