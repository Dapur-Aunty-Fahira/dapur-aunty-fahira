@extends('layouts.app')
@section('title', 'Pesanan')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-3 align-items-center">
                <div class="col-md-6">
                    <h1 class="m-0 font-weight-bold text-dark">Pesanan</h1>
                </div>
                <div class="col-md-6 text-md-right mt-2 mt-md-0">
                    <ol class="breadcrumb justify-content-md-end mb-0 bg-transparent">
                        <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                        <li class="breadcrumb-item active">Pesanan</li>
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
                                <i class="fas fa-shopping-cart mr-2"></i>Daftar Pesanan
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
                        <table class="table table-hover table-bordered table-striped w-100" id="orders-table">
                            <thead class="thead-pink text-center">
                                <tr>
                                    <th>No</th>
                                    <th>No Pesanan</th>
                                    <th>Nama</th>
                                    <th>Menu</th>
                                    <th>Total Item</th>
                                    <th>Total Harga</th>
                                    <th>Tanggal Kirim</th>
                                    <th>Jam Kirim</th>
                                    <th>Alamat</th>
                                    <th>Status</th>
                                    <th>Bukti Pembayaran</th>
                                    <th>Status Pembayaran</th>
                                    <th>Alasan Pembatalan</th>
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

        <div class="modal fade" id="orderDetailModal" tabindex="-1" role="dialog" aria-labelledby="orderDetailModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form id="order-status-form">
                        @csrf
                        <div class="modal-header bg-gradient-pink text-white">
                            <h5 class="modal-title">Detail Pesanan</h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="order_id" name="order_id">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>No Pesanan:</label>
                                    <p id="detail_order_number" class="font-weight-bold mb-0"></p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Nama Pemesan:</label>
                                    <p id="detail_user_name" class="mb-0"></p>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label>Menu Dipesan:</label>
                                    <p id="detail_menu_list" class="mb-0"></p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Total Item:</label>
                                    <p id="detail_total_quantity" class="mb-0"></p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Total Harga:</label>
                                    <p id="detail_total_paid" class="mb-0"></p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Tanggal Kirim:</label>
                                    <p id="detail_delivery_date" class="mb-0"></p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Jam Kirim:</label>
                                    <p id="detail_delivery_time" class="mb-0"></p>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label>Alamat Pengiriman:</label>
                                    <p id="detail_full_address" class="mb-0"></p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Status Pesanan:</label>
                                    <select class="form-control" name="order_status" id="order_status">
                                        <option value="menunggu konfirmasi">Menunggu Konfirmasi</option>
                                        <option value="diproses">Diproses</option>
                                        <option value="dikirim">Dikirim</option>
                                        <option value="selesai">Selesai</option>
                                        <option value="dibatalkan">Dibatalkan</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3" id="reason-wrapper">
                                    <label>Alasan Pembatalan (jika ada):</label>
                                    <input type="text" class="form-control" name="cancellation_reason"
                                        id="cancellation_reason" placeholder="Masukkan alasan pembatalan jika ada">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Bukti Pembayaran:</label>
                                    <p id="payment_proof" class="mb-0"></p>
                                    <a href="#" id="payment_proof_link" target="_blank">Lihat Bukti Pembayaran</a>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Status Pembayaran:</label>
                                    <select class="form-control" name="payment_status" id="payment_status">
                                        <option value="Validasi pembayaran">Validasi Pembayaran</option>
                                        <option value="Diterima">Diterima</option>
                                        <option value="Ditolak">Ditolak</option>
                                    </select>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-pink">Simpan Perubahan</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>


        <style>
            .bg-gradient-pink {
                background: linear-gradient(90deg, #ec4899, #f472b6) !important;
            }

            .thead-pink th {
                background-color: #f472b6 !important;
                color: #fff !important;
                font-weight: 600;
                font-size: 0.95rem;
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
                font-size: 0.9rem;
                vertical-align: middle;
            }

            table.dataTable tbody tr:hover {
                background-color: #fff0f6 !important;
            }

            .dataTables_wrapper .dataTables_paginate .paginate_button {
                color: #ec4899 !important;
            }

            .dataTables_wrapper .dataTables_paginate .paginate_button.current {
                background: #f472b6 !important;
                color: #fff !important;
            }

            .btn-pink {
                background-color: #ec4899;
                color: #fff;
            }

            .btn-pink:hover {
                background-color: #db2777;
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
    @endsection

    @push('scripts')
        <script>
            $(function() {
                let table = $('#orders-table').DataTable({
                    processing: true,
                    serverSide: true,
                    searching: true,
                    lengthChange: true,
                    pageLength: 10,
                    order: [],
                    ajax: {
                        url: "{{ route('admin.orders.show') }}",
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
                            data: 'menu_items',
                            className: 'text-center',
                            render: function(data) {
                                return data ? data : '-';
                            }
                        },
                        {
                            data: 'total_quantity',
                            className: 'text-center'
                        },
                        {
                            data: 'total_price',
                            className: 'text-right',
                            render: function(data) {
                                return 'Rp. ' + parseInt(data).toLocaleString('id-ID');
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
                            data: 'payment_proof',
                            className: 'text-center',
                            render: function(data, type, row) {
                                if (data && data !== '-') {
                                    return `<a href="${data}" target="_blank">Lihat Bukti Pembayaran</a>`;
                                }
                                return '-';
                            }
                        },
                        {
                            data: 'payment_status',
                            className: 'text-center',
                            render: function(data) {
                                let badgeClass = {
                                    'Validasi pembayaran': 'badge-warning',
                                    'Diterima': 'badge-success',
                                    'Ditolak': 'badge-danger'
                                } [data] || 'badge-secondary';
                                return `<span class="badge ${badgeClass} text-capitalize">${data}</span>`;
                            }
                        },
                        {
                            data: 'cancellation_reason',
                            className: 'text-center',
                            render: function(data) {
                                return data ? data : '-';
                            }
                        },
                        {
                            data: 'created_at',
                            className: 'text-center',
                        },
                        {
                            data: 'updated_at',
                            className: 'text-center',
                        }
                    ]
                });

                $('#filter-status').on('change', function() {
                    table.ajax.reload();
                });

                $('#orders-table tbody').on('click', 'tr', function() {
                    const data = table.row(this).data();
                    if (!data) return;


                    $('#order_id').val(data.id);
                    $('#detail_order_number').text(data.order_number);
                    $('#detail_user_name').text(data.user_name);
                    $('#detail_menu_list').text(data.menu_items);
                    $('#detail_total_quantity').text(data.total_quantity);
                    $('#detail_total_paid').text('Rp. ' + parseInt(data.total_price).toLocaleString('id-ID'));
                    $('#detail_delivery_date').text(data.delivery_date);
                    $('#detail_delivery_time').text(data.delivery_time);
                    $('#detail_full_address').text(data.full_address);
                    $('#order_status').val(data.order_status);
                    $('#cancellation_reason').val(data.cancellation_reason || '');
                    $('#payment_status').val(data.payment_status);
                    // image link payment proof
                    $('#payment_proof').text(data.payment_proof || '-');
                    $('#payment_proof_link').attr('href', data.payment_proof || '#');

                    $('#orderDetailModal').modal('show');
                });

                $('#order-status-form').on('submit', function(e) {
                    e.preventDefault();
                    const order_number = $('#detail_order_number').text();

                    const payload = {
                        _token: '{{ csrf_token() }}',
                        order_status: $('#order_status').val(),
                        cancellation_reason: $('#cancellation_reason').val(),
                        payment_status: $('#payment_status').val()
                    };

                    $.ajax({
                        url: `/admin/orders/${order_number}/status`,
                        method: 'PATCH',
                        data: payload,
                        success: function() {
                            $('#orderDetailModal').modal('hide');
                            table.ajax.reload();
                            //sweet align-items-center
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Status pesanan berhasil diperbarui.',
                                confirmButtonText: 'OK',
                                customClass: {
                                    confirmButton: 'btn btn-pink'
                                }
                            });
                        },
                        error: function(xhr) {
                            console.error(xhr);
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Terjadi kesalahan saat memperbarui status pesanan.',
                                confirmButtonText: 'OK',
                                customClass: {
                                    confirmButton: 'btn btn-pink'
                                }
                            });
                        }
                    });
                });

                function toggleCancellationReason() {
                    const selectedStatus = $('#order_status').val();
                    if (selectedStatus === 'dibatalkan') {
                        $('#reason-wrapper').show();
                    } else {
                        $('#reason-wrapper').hide();
                        $('#cancellation_reason').val('');
                    }
                }

                // Inisialisasi saat modal muncul
                $('#orderDetailModal').on('shown.bs.modal', function() {
                    toggleCancellationReason();
                });

                // Saat status pesanan berubah
                $('#order_status').on('change', function() {
                    toggleCancellationReason();
                });

            });
        </script>
    @endpush
