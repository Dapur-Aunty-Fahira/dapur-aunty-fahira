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
                                    <span class="text-muted small">Grafik ini menunjukkan jumlah pesanan berdasarkan
                                        statusnya.</span>
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
                                ],
                                [
                                    'count' => 75,
                                    'label' => 'Total Menu',
                                    'icon' => 'fas fa-utensils',
                                    'color' => 'gradient-warning',
                                ],
                            ];
                        @endphp

                        @foreach ($stats as $stat)
                            <div class="col-12 mb-3">
                                <div class="card border-0 shadow h-100 position-relative overflow-hidden">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="me-3">
                                            <span
                                                class="d-inline-flex align-items-center justify-content-center rounded-circle bg-{{ $stat['color'] }} shadow"
                                                style="width:56px;height:56px;">
                                                <i class="{{ $stat['icon'] }} text-white fs-3"></i>
                                            </span>
                                        </div>
                                        <div>
                                            <h3 class="mb-0 fw-bold text-dark">{{ $stat['count'] }}</h3>
                                            <div class="text-muted small">{{ $stat['label'] }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <style>
                    .bg-gradient-primary {
                        background: linear-gradient(135deg, #e83e8c 0%, #fd7e14 100%) !important;
                    }

                    .bg-gradient-warning {
                        background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%) !important;
                    }
                </style>
            </div>

            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-pink text-white border-0">
                            <h5 class="card-title mb-0">Aktivitas Terbaru</h5>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 20%;">Tanggal</th>
                                        <th>Aktivitas</th>
                                        <th style="width: 20%;">Pengguna</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>2023-10-01</td>
                                        <td>Pesanan baru dibuat</td>
                                        <td>Admin</td>
                                    </tr>
                                    <tr>
                                        <td>2023-10-02</td>
                                        <td>Pendaftaran pengguna baru</td>
                                        <td>John Doe</td>
                                    </tr>
                                    <!-- Tambahkan baris aktivitas lainnya di sini -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
    @push('scripts')
        @verbatim
            <script>
                // Data untuk grafik pesanan
                const orderData = {
                    labels: ['Menunggu Konfirmasi', 'Diproses', 'Dikirim', 'Selesai', 'Dibatalkan'],
                    datasets: [{
                        label: 'Jumlah Pesanan',
                        data: [150, 44, 27, 53, 65],
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

                // Konfigurasi grafik
                const configOrder = {
                    type: 'bar',
                    data: orderData,
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: 'Statistik Pesanan'
                            }
                        }
                    }
                };
                // Inisialisasi grafik
                const orderChart = new Chart(
                    document.getElementById('orderChart'),
                    configOrder
                );
                // Event listener untuk filter tanggal
                document.getElementById('daterange').addEventListener('change', function() {
                    const selectedDateRange = this.value;
                    // Lakukan sesuatu dengan rentang tanggal yang dipilih
                });
                // Inisialisasi date range picker
                $('#daterange').daterangepicker({
                    opens: 'left',
                    locale: {
                        format: 'YYYY-MM-DD'
                    }
                });
            </script>
        @endverbatim
    @endpush
@endsection
