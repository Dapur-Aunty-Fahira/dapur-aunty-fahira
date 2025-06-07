<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        {{-- dashboard --}}
        <li class="nav-item">
            <a @if (route('admin.dashboard') === request()->url()) class="nav-link active" @else class="nav-link" @endif
                href="{{ route('admin.dashboard') }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
            </a>
        </li>
        {{-- menu --}}
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="nav-icon fas fa-utensils"></i>
                <p>Menu</p>
            </a>
        </li>
        {{-- kanban pesanan --}}
        <li class="nav-item has-treeview">
            <a class="nav-link" href="#">
                <i class="nav-icon fas fa-th"></i>
                <p>
                    Pesanan
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Menunggu Konfirmasi</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Diproses</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Dikirim</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Selesai</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Dibatalkan</p>
                    </a>
                </li>
            </ul>
        </li>
        {{-- laporan --}}
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="nav-icon fas fa-file-alt"></i>
                <p>Laporan</p>
            </a>
        </li>
        {{-- kelola akun --}}
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="nav-icon fas fa-users"></i>
                <p>Kelola Akun</p>
            </a>
        </li>
    </ul>
</nav>
<!-- /.sidebar-menu -->
