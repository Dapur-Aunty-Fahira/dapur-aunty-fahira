@extends('layouts.app')
@section('title', 'Pengiriman')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0">Pengiriman</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                        <li class="breadcrumb-item active">Pengiriman</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <h5>📦 Pesanan Tersedia</h5>
            <div class="row" id="available-orders">
                <!-- List pesanan tersedia akan muncul di sini -->
            </div>

            <hr>

            <h5>🚚 Tugas Kurir</h5>
            <div class="row" id="my-deliveries">
                <!-- Tugas kurir akan muncul di sini -->
            </div>

        </div>
    </section>

    <!-- Modal Upload Bukti -->
    <div class="modal fade" id="uploadProofModal" tabindex="-1" aria-labelledby="uploadProofLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="proofForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="order_number" id="proof_order_number">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Upload Bukti Pengantaran</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <input type="file" name="arrival_proof" class="form-control" accept="image/*" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Kirim</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const userId = @json(auth()->user()->user_id);

        document.addEventListener('DOMContentLoaded', function() {
            fetchAvailableOrders();
            fetchMyDeliveries();

            function fetchAvailableOrders() {
                fetch('/api/v1/order/available')
                    .then(res => res.json())
                    .then(data => {
                        const container = document.getElementById('available-orders');
                        container.innerHTML = '';
                        const orders = Array.isArray(data) ? data : data.data;

                        if (Array.isArray(orders) && orders.length > 0) {
                            orders.forEach(order => {
                                container.innerHTML += `
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5>Pesanan #${order.order_number}</h5>
                                    <p><strong>Tujuan:</strong> ${order.address}</p>
                                    <button class="btn btn-sm btn-success" onclick="takeOrder('${order.order_number}')">Ambil Tugas</button>
                                </div>
                            </div>
                        </div>
                    `;
                            });
                        } else {
                            container.innerHTML =
                                `<div class="col-12"><div class="alert alert-warning">Tidak ada pesanan tersedia.</div></div>`;
                        }
                    }).catch(err => {
                        document.getElementById('available-orders').innerHTML =
                            `<div class="col-12"><div class="alert alert-danger">Gagal memuat pesanan: ${err.message}</div></div>`;
                    });
            }

            function fetchMyDeliveries() {
                fetch(`/api/v1/order/my-deliveries/${userId}`)
                    .then(res => res.json())
                    .then(data => {
                        const container = document.getElementById('my-deliveries');
                        container.innerHTML = '';
                        const orders = Array.isArray(data) ? data : data.data;

                        if (Array.isArray(orders) && orders.length > 0) {
                            orders.forEach(order => {
                                container.innerHTML += `
                        <div class="col-md-4">
                            <div class="card mb-3 border-info">
                                <div class="card-body">
                                    <h5>Pesanan #${order.order_number}</h5>
                                    <p><strong>Tujuan:</strong> ${order.address}</p>
                                    <button class="btn btn-sm btn-primary" onclick="openProofModal('${order.order_number}')">Selesaikan</button>
                                </div>
                            </div>
                        </div>
                    `;
                            });
                        } else {
                            container.innerHTML =
                                `<div class="col-12"><div class="alert alert-warning">Tidak ada tugas kurir.</div></div>`;
                        }
                    }).catch(err => {
                        document.getElementById('my-deliveries').innerHTML =
                            `<div class="col-12"><div class="alert alert-danger">Gagal memuat tugas kurir: ${err.message}</div></div>`;
                    });
            }

            window.takeOrder = function(orderNumber) {
                fetch(`/api/v1/order/assign/${encodeURIComponent(orderNumber)}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            user_id: userId
                        })
                    })
                    .then(res => res.json())
                    .then(() => {
                        fetchAvailableOrders();
                        fetchMyDeliveries();
                    });
            }

            window.openProofModal = function(orderNumber) {
                document.getElementById('proof_order_number').value = orderNumber;
                $('#uploadProofModal').modal('show');
            }

            document.getElementById('proofForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);

                fetch('/api/v1/order/complete', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: formData
                    })
                    .then(async res => {
                        const contentType = res.headers.get('content-type');
                        if (!res.ok || !contentType || !contentType.includes('application/json')) {
                            const text = await res.text();
                            console.error("❌ Unexpected response:", text);
                            throw new Error("Gagal menyimpan bukti.");
                        }
                        return res.json();
                    })
                    .then(data => {
                        console.log("✅ Bukti berhasil diupload:", data);
                        $('#uploadProofModal').modal('hide');
                        fetchMyDeliveries();
                    })
                    .catch(error => {
                        alert("❌ Terjadi kesalahan saat upload. Silakan cek console.");
                        console.error("Upload error:", error);
                    });
            });
        });
    </script>
@endpush
