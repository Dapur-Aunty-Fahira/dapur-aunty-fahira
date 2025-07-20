<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;700&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" />
<style>
    body {
        font-family: 'Quicksand', sans-serif;
        background-color: #fff0f6;
        color: #4a4a4a;
    }

    .navbar {
        background-color: #e557a1;
    }

    .navbar-brand {
        font-weight: 700;
        font-size: 1.6rem;
        color: #fff !important;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .navbar-brand img {
        height: 40px;
        width: 40px;
        object-fit: contain;
        border-radius: 8px;
        background: white;
        padding: 2px;
    }

    .cart-btn {
        color: #fff;
        position: relative;
    }

    .cart-count {
        position: absolute;
        top: -8px;
        right: -8px;
        background: #ffc107;
        color: #000;
        border-radius: 50%;
        padding: 2px 7px;
        font-size: 0.8rem;
        font-weight: bold;
    }

    .content-header {
        background: linear-gradient(135deg, #e557a1, #fee3e8);
        color: white;
        padding: 4rem 1rem 2rem;
        text-align: center;
    }

    .card-menu {
        border: none;
        box-shadow: 0 4px 12px rgba(229, 87, 161, 0.1);
        transition: transform 0.2s ease;
    }

    .card-menu:hover {
        transform: translateY(-4px) scale(1.01);
        box-shadow: 0 8px 24px rgba(229, 87, 161, 0.15);
    }

    .card-img-top {
        height: 180px;
        object-fit: cover;
        border-radius: 0.5rem 0.5rem 0 0;
    }

    .btn-outline-primary {
        border-color: #e557a1;
        color: #e557a1;
        font-weight: 600;
    }

    .btn-outline-primary:hover {
        background-color: #e557a1;
        color: #fff;
    }

    .form-control:focus {
        border-color: #e557a1;
        box-shadow: 0 0 0 0.2rem rgba(229, 87, 161, 0.25);
    }

    .main-footer {
        background-color: #e557a1;
        color: white;
        padding: 1rem;
        font-weight: 600;
        text-align: center;
    }

    @media (max-width: 767px) {
        .content-header {
            padding: 2rem 0.5rem 1rem;
        }

        .card-img-top {
            height: 120px;
        }
    }
</style>

<style>
    /* Change active/focus/hover color for all <a> elements to pink */

    .dropdown-menu .dropdown-item.active,
    .dropdown-menu .dropdown-item:active,
    .dropdown-menu .dropdown-item:focus,
    .dropdown-menu .dropdown-item:hover {
        background-color: #e557a1 !important;
        color: #fff !important;
    }
</style>

<style>
    html,
    body {
        height: 100%;
        margin: 0;
    }

    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    main {
        flex: 1;
    }
</style>
