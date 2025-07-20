@extends('layouts.guest.app')

@section('title', 'History Pesanan | Dapur Aunty Fahira')

@section('content')
    <header class="bg-light py-4 border-bottom mb-4 text-center">
        <div class="container">
            <h1 class="fw-bold">History Pesanan</h1>
            <p class="lead text-muted">Lihat riwayat pesanan Anda dalam bentuk timeline.</p>
        </div>
    </header>

    <main class="container pb-5">
        <div class="row">
            <div class="col">
                <div id="orderTimeline"></div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetchOrderTimeline();
        });

        function fetchOrderTimeline() {
            fetch("api/v1/order/timeline/{{ auth()->user()->user_id }}", {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Adjusted for API response structure
                    const orders = Array.isArray(data?.data) ? data.data : [];
                    renderTimeline(orders);
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('orderTimeline').innerHTML =
                        '<div class="alert alert-danger">Gagal memuat data.</div>';
                });
        }

        function renderTimeline(orders) {
            const timeline = document.getElementById('orderTimeline');
            if (orders.length === 0) {
                timeline.innerHTML = '<p class="text-muted">Belum ada pesanan.</p>';
                return;
            }

            let html = '<ul class="list-group list-group-flush">';
            orders.forEach(order => {
                html += `
            <li class="list-group-item">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="mb-1">#${order.order_number} - Rp${Number(order.total_price).toLocaleString()}</h6>
                        <p class="mb-1">Status: <strong>${order.order_status.replace(/\b\w/g, c => c.toUpperCase())}</strong></p>
                        <p class="mb-1">Pengantaran pada: ${order.delivery_date} pukul ${order.delivery_time}</p>
                        <p class="mb-1">Alamat: ${order.address}</p>
                        <small>Waktu pesanan dibuat: ${order.created_at}</small>
                    </div>
                    <div class="text-end">
                        <button class="btn btn-sm btn-outline-primary" onclick="toggleDetails('${order.order_number}')">Detail</button>
                        <a href="api/v1/order/invoice/${order.order_number}" target="_blank" class="btn btn-sm btn-outline-success ms-2">Invoice</a>
                    </div>
                </div>
                <div id="details-${order.order_number}" class="mt-2 d-none">
                    ${(order.items || []).map(item => `
                                                                        <div class="border p-2 mb-1 rounded bg-light">
                                                                            <strong>${item.menu_name}</strong> x ${item.quantity} @ Rp${Number(item.price).toLocaleString()}
                                                                        </div>
                                                                    `).join('')}
                </div>
            </li>`;
            });
            html += '</ul>';
            timeline.innerHTML = html;
        }

        function toggleDetails(orderNumber) {
            const el = document.getElementById(`details-${orderNumber}`);
            el.classList.toggle('d-none');
        }
    </script>
@endpush
