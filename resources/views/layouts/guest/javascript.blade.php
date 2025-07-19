 <!-- jQuery -->
 <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
 <!-- SweetAlert2 -->
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
 <script>
     // --- Cart Logic ---
     let cart = {};
     // Load cart from localStorage
     if (localStorage.getItem('cart')) {
         cart = JSON.parse(localStorage.getItem('cart'));
     }

     function formatRupiah(angka) {
         return 'Rp' + angka.toLocaleString('id-ID');
     }

     function updateCartDisplay() {
         const cartItems = document.getElementById('cartItems');
         const cartCount = document.getElementById('cartCount');
         const checkoutBtn = document.getElementById('checkoutBtn');
         const items = Object.entries(cart);

         let totalQty = 0;
         let totalHarga = 0;

         if (items.length === 0) {
             cartItems.innerHTML = '<p class="text-muted">Keranjang Anda kosong.</p>';
             checkoutBtn.disabled = true;
         } else {
             let html = items.map(([name, data]) => {
                 totalQty += data.qty;
                 totalHarga += data.qty * data.price;
                 return `
            <div class="d-flex justify-content-between align-items-center mb-2">
              <div>
                <div class="fw-semibold">${name}</div>
                <small class="text-muted">${formatRupiah(data.price)} x ${data.qty}</small>
              </div>
              <div>
                <button class="btn btn-sm btn-light border change-qty" data-name="${name}" data-delta="-1" aria-label="Kurangi ${name}">-</button>
                <span class="mx-1">${data.qty}</span>
                <button class="btn btn-sm btn-light border change-qty" data-name="${name}" data-delta="1" aria-label="Tambah ${name}">+</button>
                <button class="btn btn-sm btn-danger ms-2 remove-item" data-name="${name}" aria-label="Hapus ${name}"><i class="bi bi-trash"></i></button>
              </div>
            </div>`;
             }).join('');

             html += `
          <hr>
          <div class="d-flex justify-content-between fw-bold">
            <span>Total</span>
            <span>${formatRupiah(totalHarga)}</span>
          </div>
          <div class="mt-3">
            <h6>Informasi Pemesan</h6>
            <input type="text" class="form-control mb-2" placeholder="Nama Lengkap" id="namaPemesan">
            <input type="text" class="form-control mb-2" placeholder="No. Telepon" id="telpPemesan">
            <textarea class="form-control mb-2" placeholder="Alamat Pengantaran" id="alamatPemesan" rows="2"></textarea>
            <label class="form-label">Upload Bukti Pembayaran</label>
            <input type="file" class="form-control mb-2" id="buktiBayar" accept="image/*" capture="environment">
            <img id="buktiPreview" src="" alt="Preview Bukti Bayar" class="img-fluid mt-2 rounded shadow-sm d-none" style="max-height: 200px;">
          </div>`;

             cartItems.innerHTML = html;
             checkoutBtn.disabled = false;

             // Autofill pemesan info from profile
             document.getElementById('namaPemesan').value = localStorage.getItem('profil_nama') || '';
             document.getElementById('telpPemesan').value = localStorage.getItem('profil_telp') || '';
             document.getElementById('alamatPemesan').value = localStorage.getItem('profil_alamat') || '';

             // Add event for image preview
             document.getElementById('buktiBayar').addEventListener('change', previewImage);
         }
         cartCount.textContent = totalQty;
         localStorage.setItem('cart', JSON.stringify(cart));
     }

     // Event delegation for cart actions
     document.getElementById('cartItems').addEventListener('click', function(e) {
         if (e.target.classList.contains('change-qty')) {
             const name = e.target.getAttribute('data-name');
             const delta = parseInt(e.target.getAttribute('data-delta'));
             if (cart[name]) {
                 cart[name].qty += delta;
                 if (cart[name].qty <= 0) delete cart[name];
                 updateCartDisplay();
             }
         }
         if (e.target.classList.contains('remove-item')) {
             const name = e.target.getAttribute('data-name');
             delete cart[name];
             updateCartDisplay();
         }
     });

     // Add to cart
     document.querySelectorAll('.add-to-cart').forEach(btn => {
         btn.addEventListener('click', function() {
             const name = this.getAttribute('data-name');
             const price = parseInt(this.getAttribute('data-price'));
             if (!cart[name]) {
                 cart[name] = {
                     qty: 1,
                     price: price
                 };
             } else {
                 cart[name].qty += 1;
             }
             updateCartDisplay();
         });
     });

     // Checkout button
     document.getElementById('checkoutBtn').addEventListener('click', submitOrder);

     function previewImage(e) {
         const input = e.target;
         const preview = document.getElementById('buktiPreview');
         const file = input.files[0];
         if (file) {
             const reader = new FileReader();
             reader.onload = function(ev) {
                 preview.src = ev.target.result;
                 preview.classList.remove('d-none');
             };
             reader.readAsDataURL(file);
         } else {
             preview.src = '';
             preview.classList.add('d-none');
         }
     }

     function submitOrder() {
         const nama = document.getElementById('namaPemesan').value.trim();
         const telp = document.getElementById('telpPemesan').value.trim();
         const alamat = document.getElementById('alamatPemesan').value.trim();
         const bukti = document.getElementById('buktiBayar').files[0];

         if (!nama || !telp || !alamat) {
             alert("Harap isi semua informasi pemesan.");
             return;
         }
         if (!bukti) {
             alert("Harap unggah bukti pembayaran.");
             return;
         }
         if (bukti.size > 2 * 1024 * 1024) {
             alert("Ukuran bukti pembayaran maksimal 2MB.");
             return;
         }

         const formData = new FormData();
         formData.append("nama", nama);
         formData.append("telp", telp);
         formData.append("alamat", alamat);
         formData.append("bukti_bayar", bukti);
         formData.append("cart", JSON.stringify(cart));

         // TODO: Ganti ke endpoint backend
         // fetch('/api/pemesanan', { method: 'POST', body: formData })

         alert(`Pesanan berhasil dibuat!\nTerima kasih, ${nama}.`);
         cart = {};
         updateCartDisplay();
     }

     updateCartDisplay();

     // Logout confirmation
     document.getElementById('logout-btn').addEventListener('click', function(e) {
         e.preventDefault();
         Swal.fire({
             title: 'Konfirmasi Logout',
             text: "Apakah Anda yakin ingin keluar?",
             icon: 'warning',
             showCancelButton: true,
             confirmButtonColor: '#d33',
             cancelButtonColor: '#3085d6',
             confirmButtonText: 'Ya, Logout',
             cancelButtonText: 'Batal'
         }).then((result) => {
             if (result.isConfirmed) {
                 document.getElementById('logout-form').submit();
             }
         });
     });

     // Ganti password SweetAlert
     document.getElementById('change-password-btn').addEventListener('click', function(e) {
         e.preventDefault();
         Swal.fire({
             title: 'Ganti Password',
             html: `<input type="password" id="old_password" class="swal2-input" placeholder="Password Lama">` +
                 `<input type="password" id="new_password" class="swal2-input" placeholder="Password Baru">` +
                 `<input type="password" id="confirm_password" class="swal2-input" placeholder="Konfirmasi Password">`,
             focusConfirm: false,
             showCancelButton: true,
             confirmButtonText: 'Simpan',
             cancelButtonText: 'Batal',
             preConfirm: () => {
                 const old_password = document.getElementById('old_password').value;
                 const new_password = document.getElementById('new_password').value;
                 const confirm_password = document.getElementById('confirm_password').value;

                 if (!old_password || !new_password || !confirm_password) {
                     Swal.showValidationMessage('Semua kolom harus diisi');
                 } else if (new_password.length < 6) {
                     Swal.showValidationMessage('Password baru minimal 6 karakter');
                 } else if (new_password !== confirm_password) {
                     Swal.showValidationMessage('Konfirmasi password tidak cocok');
                 }

                 return {
                     old_password,
                     new_password,
                     new_password_confirmation: confirm_password
                 };
             }
         }).then((result) => {
             if (result.isConfirmed) {
                 fetch(`{{ route('password.change') }}`, {
                         method: 'POST',
                         headers: {
                             'Content-Type': 'application/json',
                             'X-CSRF-TOKEN': '{{ csrf_token() }}'
                         },
                         body: JSON.stringify(result.value)
                     })
                     .then(response => response.json().then(data => ({
                         status: response.status,
                         body: data
                     })))
                     .then(({
                         status,
                         body
                     }) => {
                         if (status === 200 && body.status === 'success') {
                             Swal.fire('Berhasil', body.message, 'success');
                         } else {
                             Swal.fire('Gagal', body.message || 'Terjadi kesalahan', 'error');
                         }
                     })
                     .catch(() => {
                         Swal.fire('Error', 'Terjadi kesalahan saat mengganti password', 'error');
                     });
             }
         });
     });
 </script>
