<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        @auth
            @if (auth()->user()->role === 'kurir')
                <li class="nav-item">
                    <a @if (route('kurir.delivery.index') === request()->url()) class="nav-link active" @else class="nav-link" @endif
                        href="{{ route('kurir.delivery.index') }}">
                        <i class="nav-icon fas fa-truck"></i>
                        <p>Pengiriman</p>
                    </a>
                </li>
            @else
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
                    <a @if (route('admin.menu') === request()->url()) class="nav-link active" @else class="nav-link" @endif
                        href="{{ route('admin.menu') }}">
                        <i class="nav-icon fas fa-utensils"></i>
                        <p>Menu</p>
                    </a>
                </li>
                {{-- pesanan --}}
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="nav-icon fas fa-columns"></i>
                        <p>Pesanan</p>
                    </a>
                </li>

                {{-- <li class="nav-item has-treeview">
            <a class="nav-link" href="#">
                <i class="nav-icon fas fa-th"></i>
                <p>
                    Pesanan

                    <span class="badge badge-secondary">5</span>
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Menunggu Konfirmasi <span class="badge badge-secondary">1</span></p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Diproses <span class="badge badge-secondary">2</span></p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Dikirim <span class="badge badge-secondary">2</span></p>
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
        </li> --}}

                {{-- laporan --}}
                <li class="nav-item">
                    <a @if (route('admin.report.index') === request()->url()) class="nav-link active" @else class="nav-link" @endif
                        href="{{ route('admin.report.index') }}">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>Laporan</p>
                    </a>
                </li>
                {{-- kelola akun --}}
                <li class="nav-item">
                    <a @if (route('admin.users.index') === request()->url()) class="nav-link active" @else class="nav-link" @endif
                        href="{{ route('admin.users.index') }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Kelola Akun</p>
                    </a>
                </li>
            @endif
        @endauth

    </ul>
</nav>
<!-- /.sidebar-menu -->
