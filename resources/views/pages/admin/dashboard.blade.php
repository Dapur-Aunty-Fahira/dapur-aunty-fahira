@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Beranda</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row mb-4">
                <!-- Statistik Pesanan (Chart) di sebelah kiri -->
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-pink text-white border-0">
                            <h5 class="card-title mb-0">Statistik Pesanan</h5>
                        </div>
                        <div class="card-body">
                            <div class="row align-items-center mb-3">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="daterange" name="daterange"
                                            value="{{ now()->startOfMonth()->format('Y-m-d') }} - {{ now()->endOfMonth()->format('Y-m-d') }}">
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-6 text-end">
                                    <span class="text-muted small">
                                        Pilih rentang tanggal untuk melihat statistik pesanan.
                                    </span>
                                </div>
                            </div>
                            <div class="chart">
                                <canvas id="orderChart" style="height: 350px; width: 100%;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Statistik Pengguna & Menu di sebelah kanan -->
                <div class="col-lg-4">
                    <div class="row g-3">
                        @php
                            $stats = [
                                [
                                    'count' => 120,
                                    'label' => 'Total Pengguna',
                                    'icon' => 'fas fa-users',
                                    'color' => 'gradient-primary',
                                    'class' => 'stat-total-pengguna',
                                ],
                                [
                                    'count' => 75,
                                    'label' => 'Total Menu',
                                    'icon' => 'fas fa-utensils',
                                    'color' => 'gradient-warning',
                                    'class' => 'stat-total-menu',
                                ],
                            ];
                        @endphp

                        @foreach ($stats as $stat)
                            <div class="col-12 mb-3">
                                <div class="card border-0 shadow h-100 position-relative overflow-hidden">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="me-3">
                                            <span
                                                class="d-inline-flex align-items-center justify-content-center rounded-circle bg-gradient-{{ $stat['color'] }} shadow"
                                                style="width:56px;height:56px;">
                                                <i class="{{ $stat['icon'] }} text-white fs-3"></i>
                                            </span>
                                        </div>
                                        <div>
                                            <h3 class="mb-0 fw-bold text-dark {{ $stat['class'] }}">{{ $stat['count'] }}
                                            </h3>
                                            <div class="text-muted small">{{ $stat['label'] }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <style>
                    .bg-gradient-gradient-primary {
                        background: linear-gradient(135deg, #e83e8c 0%, #fd7e14 100%) !important;
                    }

                    .bg-gradient-gradient-warning {
                        background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%) !important;
                    }
                </style>
            </div>
        </div>
    </section>
    <!-- /.content -->
    @push('scripts')
        <!-- SweetAlert2 CDN (atau gunakan asset lokal jika ada) -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            let orderChart;
            let orderData = {
                labels: ['Menunggu Konfirmasi', 'Diproses', 'Dikirim', 'Selesai', 'Dibatalkan'],
                datasets: [{
                    label: 'Jumlah Pesanan',
                    data: [0, 0, 0, 0, 0],
                    backgroundColor: [
                        'rgba(23, 162, 184, 0.6)',
                        'rgba(255, 193, 7, 0.6)',
                        'rgba(0, 123, 255, 0.6)',
                        'rgba(40, 167, 69, 0.6)',
                        'rgba(220, 53, 69, 0.6)'
                    ],
                    borderColor: [
                        'rgba(23, 162, 184, 1)',
                        'rgba(255, 193, 7, 1)',
                        'rgba(0, 123, 255, 1)',
                        'rgba(40, 167, 69, 1)',
                        'rgba(220, 53, 69, 1)'
                    ],
                    borderWidth: 1
                }]
            };

            function showDashboardError(message) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: message,
                    showConfirmButton: false,
                    timer: 3500,
                    timerProgressBar: true,
                    customClass: {
                        popup: 'colored-toast'
                    }
                });
            }

            function fetchDashboardStats(startDate, endDate) {
                $.ajax({
                    url: "{{ route('admin.dashboard.orders') }}",
                    data: {
                        start: startDate,
                        end: endDate
                    },
                    success: function(response) {
                        if (response && response.orders) {
                            orderData.datasets[0].data = [
                                response.orders['menunggu_konfirmasi'] ?? 0,
                                response.orders['diproses'] ?? 0,
                                response.orders['dikirim'] ?? 0,
                                response.orders['selesai'] ?? 0,
                                response.orders['dibatalkan'] ?? 0
                            ];
                            if (orderChart) orderChart.update();

                            $('.stat-total-pengguna').text(response.userCount ?? 0);
                            $('.stat-total-menu').text(response.menuCount ?? 0);
                        } else {
                            showDashboardError('Data tidak valid diterima dari server.');
                            resetStats();
                        }
                    },
                    error: function(xhr) {
                        let msg = 'Terjadi kesalahan saat mengambil data statistik.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg += ' ' + xhr.responseJSON.message;
                        }
                        showDashboardError(msg);
                        resetStats();
                    }
                });
            }

            function resetStats() {
                orderData.datasets[0].data = [0, 0, 0, 0, 0];
                if (orderChart) orderChart.update();
                $('.stat-total-pengguna').text(0);
                $('.stat-total-menu').text(0);
            }

            $(function() {
                // Inisialisasi date range picker
                $('#daterange').daterangepicker({
                    opens: 'left',
                    locale: {
                        format: 'YYYY-MM-DD'
                    }
                });

                // Inisialisasi grafik
                orderChart = new Chart(
                    document.getElementById('orderChart'), {
                        type: 'bar',
                        data: orderData,
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top'
                                },
                                title: {
                                    display: true,
                                    text: 'Statistik Pesanan'
                                }
                            }
                        }
                    }
                );

                // Ambil data awal
                let initialRange = $('#daterange').val().split(' - ');
                fetchDashboardStats(initialRange[0], initialRange[1]);

                // Event listener untuk filter tanggal
                $('#daterange').on('apply.daterangepicker', function(ev, picker) {
                    fetchDashboardStats(picker.startDate.format('YYYY-MM-DD'), picker.endDate.format(
                        'YYYY-MM-DD'));
                });
            });
        </script>
    @endpush
@endsection
