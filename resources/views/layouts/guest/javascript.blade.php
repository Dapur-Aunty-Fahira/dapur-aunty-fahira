 <!-- jQuery -->
 <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
 <!-- SweetAlert2 -->
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
 <script>
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
