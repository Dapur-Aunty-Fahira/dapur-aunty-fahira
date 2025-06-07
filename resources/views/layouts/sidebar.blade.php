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
                <i class="nav-icon fas fa-th"></i>
                <p>Menu</p>
            </a>
        </li>
        {{-- kanban pesanan --}}
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="nav-icon fas fa-columns"></i>
                <p>Kanban Pesanan</p>
            </a>
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
