@extends('layouts.guest.app')

@section('title', 'Pemesanan Katering | Dapur Aunty Fahira')

@section('content')
    <div class="container my-5">
        <h1 class="fw-bold text-center mb-4">Pemesanan Katering</h1>

        <!-- Step Wrapper -->
        <div id="checkout-steps" class="card shadow p-4">
            <div class="step step-1">
                <h4>📦 Detail Pemesan</h4>
                <div class="mb-3">
                    <label for="namaPemesan" class="form-label">Nama Pemesan</label>
                    <input type="text" id="namaPemesan" class="form-control" placeholder="Nama lengkap" required>
                </div>
                <div class="mb-3">
                    <label for="noHpPemesan" class="form-label">Nomor HP</label>
                    <input type="text" id="noHpPemesan" class="form-control" placeholder="08xxxx" required>
                </div>
                <div class="mb-3">
                    <label for="alamatPemesanId" class="form-label">Pilih Alamat</label>
                    <select id="alamatPemesanId" class="form-select" required>
                        <option value="">-- Pilih Alamat --</option>
                    </select>
                </div>
                <button class="btn btn-primary mt-2" id="toStep2">Lanjut</button>
            </div>

            <div class="step step-2 d-none">
                <h4>💳 Upload Bukti Transfer</h4>
                <div class="mb-3">
                    <label for="buktiTransfer" class="form-label">Foto Bukti Transfer</label>
                    <input type="file" id="buktiTransfer" class="form-control" accept="image/*" required>
                </div>
                <div class="d-flex justify-content-between">
                    <button class="btn btn-secondary" id="backToStep1">Kembali</button>
                    <button class="btn btn-success" id="checkoutSubmit">Kirim Pesanan</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userId = localStorage.getItem('user_id');
            const alamatSelect = document.getElementById('alamatPemesanId');

            if (userId) {
                fetch(`/api/v1/addresses/user/${userId}`)
                    .then(res => res.json())
                    .then(res => {
                        alamatSelect.innerHTML = '<option value="">-- Pilih Alamat --</option>';
                        if (res.status === 'sukses') {
                            res.data.forEach(addr => {
                                alamatSelect.innerHTML +=
                                    `<option value="${addr.id}">${addr.detail || addr.id}</option>`;
                            });
                        }
                    });
            }

            // Step Navigation
            const step1 = document.querySelector('.step-1');
            const step2 = document.querySelector('.step-2');

            document.getElementById('toStep2').addEventListener('click', () => {
                if (!validateStep1()) return;
                step1.classList.add('d-none');
                step2.classList.remove('d-none');
            });

            document.getElementById('backToStep1').addEventListener('click', () => {
                step2.classList.add('d-none');
                step1.classList.remove('d-none');
            });

            // Submit
            document.getElementById('checkoutSubmit').addEventListener('click', function() {
                const formData = new FormData();
                formData.append('nama_pemesan', document.getElementById('namaPemesan').value);
                formData.append('no_hp', document.getElementById('noHpPemesan').value);
                formData.append('alamat_id', document.getElementById('alamatPemesanId').value);
                formData.append('bukti_transfer', document.getElementById('buktiTransfer').files[0]);
                formData.append('user_id', userId);

                fetch('/api/v1/orders', {
                        method: 'POST',
                        body: formData
                    })
                    .then(res => res.json())
                    .then(res => {
                        if (res.status === 'sukses') {
                            Swal.fire('Sukses', 'Pesanan berhasil dikirim!', 'success');
                        } else {
                            Swal.fire('Gagal', res.message || 'Terjadi kesalahan', 'error');
                        }
                    })
                    .catch(() => {
                        Swal.fire('Error', 'Terjadi kesalahan saat mengirim', 'error');
                    });
            });

            function validateStep1() {
                const nama = document.getElementById('namaPemesan').value.trim();
                const hp = document.getElementById('noHpPemesan').value.trim();
                const alamat = document.getElementById('alamatPemesanId').value;

                if (!nama || !hp || !alamat) {
                    Swal.fire('Oops!', 'Semua data wajib diisi.', 'warning');
                    return false;
                }
                return true;
            }
        });
    </script>
@endpush
