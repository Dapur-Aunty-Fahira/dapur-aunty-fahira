<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Navbar -->
<ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button">
            <i class="fas fa-bars"></i>
        </a>
    </li>
</ul>

<ul class="navbar-nav ml-auto">
    <!-- Notifications Dropdown -->
    <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-item dropdown-header">15 Notifications</span>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
                <i class="fas fa-envelope mr-2"></i> 4 new messages
                <span class="float-right text-muted text-sm">3 mins</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
                <i class="fas fa-users mr-2"></i> 8 friend requests
                <span class="float-right text-muted text-sm">12 hours</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
                <i class="fas fa-file mr-2"></i> 3 new reports
                <span class="float-right text-muted text-sm">2 days</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
    </li>

    <!-- User Account Menu -->
    <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
            <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <li class="user-header bg-pink">
                <img src="{{ asset('images/logo.png') }}" class="img-circle elevation-2" alt="User Image">
                <p>
                    {{ Auth::user()->name }} - {{ Auth::user()->role }}
                    <small>Member since {{ Auth::user()->created_at->format('M Y') }}</small>
                </p>
            </li>
            <li class="user-footer">
                <div class="float-left">
                    <a href="#" class="btn btn-default btn-flat" id="change-password-btn">Ganti Password</a>
                </div>
                <div class="float-right">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    <a href="#" class="btn btn-default btn-flat" id="logout-btn">Keluar</a>
                </div>
            </li>
        </ul>
    </li>
</ul>

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
