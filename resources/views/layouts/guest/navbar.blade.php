<div class="container align-items-center">
    <a class="navbar-brand d-flex align-items-center gap-2" href="#">
        <img src="/images/logo.png" alt="Logo Dapur Aunty Fahira" loading="lazy" class="shadow-sm"
            style="background: #fff; border-radius: 10px; padding: 3px;">
        <span style="letter-spacing: 1px;">Dapur Aunty Fahira</span>
    </a>
    <div class="d-flex align-items-center ms-auto">
        <button class="btn cart-btn position-relative me-3" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#cartOffcanvas" aria-controls="cartOffcanvas" aria-label="Buka keranjang"
            style="background: #fff0f6; border: none; box-shadow: 0 2px 8px rgba(229,87,161,0.08);">
            <i class="bi bi-cart3 fs-4" style="color: #e557a1;"></i>
            <span class="cart-count" id="cartCount" style="top: -10px; right: -10px;">0</span>
        </button>
        <div class="dropdown">
            <a class="btn btn-light rounded-pill px-3 fw-semibold d-flex align-items-center gap-2" href="#"
                role="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false"
                style="background: #fff; border: 1px solid #e557a1; color: #e557a1;">
                <i class="bi bi-person-circle fs-5"></i>
                <span>{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3" aria-labelledby="userMenu"
                style="min-width: 220px;">
                <li class="px-3 py-2">
                    <strong class="d-block mb-1" style="color: #e557a1;">{{ Auth::user()->name }}</strong>
                    <small class="text-muted">{{ Auth::user()->role }}</small><br>
                    <small class="text-muted">Member sejak {{ Auth::user()->created_at->format('M Y') }}</small>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <a href="#" class="dropdown-item d-flex align-items-center gap-2" id="change-password-btn"
                        style="--bs-dropdown-link-active-bg: #e557a1;">
                        <i class="bi bi-key text-warning"></i> Ganti Password
                    </a>
                </li>
                <li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf
                    </form>
                    <a href="#" class="dropdown-item d-flex align-items-center gap-2 text-danger" id="logout-btn"
                        style="--bs-dropdown-link-active-bg: #e557a1;">
                        <i class="bi bi-box-arrow-right"></i> Keluar
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
