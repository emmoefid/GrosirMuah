<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GrosirMuah</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom Style -->
    <style>
        body {
            font-family: 'Montserrat', Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .navbar-brand {
            font-weight: 700;
            letter-spacing: 1px;
        }
        .nav-link {
            transition: color 0.2s;
        }
        .nav-link:hover, .nav-link.active {
            color: #ffc107 !important;
        }
        .navbar {
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        main {
            min-height: 70vh;
        }
        footer {
            background: #212529;
            color: #fff;
            text-align: center;
            padding: 16px 0;
            margin-top: 40px;
            letter-spacing: 1px;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">GrosirMuah</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                @auth
                    @if (Auth::user()->role === 'admin')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('products.index') ? 'active' : '' }}" href="{{ route('products.index') }}">Produk</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('categories.index') ? 'active' : '' }}" href="{{ route('categories.index') }}">Kategori</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}" href="{{ route('users.index') }}">Pengguna</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('report.index') ? 'active' : '' }}" href="{{ route('report.index') }}">Laporan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('report.chart') ? 'active' : '' }}" href="{{ route('report.chart') }}">Grafik</a>
                        </li>
                    @endif

                    @if (Auth::user()->role === 'admin' || Auth::user()->role === 'kasir')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('sales.history') ? 'active' : '' }}" href="{{ route('sales.history') }}">Riwayat</a>
                        </li>
                    @endif

                    <li class="nav-item">
                        <span class="nav-link disabled">
                            <i class="bi bi-person-circle"></i>
                            {{ Auth::user()->name }} ({{ ucfirst(Auth::user()->role) }})
                        </span>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link" style="display:inline; padding: 0;">Logout</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">Login</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<!-- Main Content -->
<main class="py-4">
    @yield('content')
</main>

<!-- Footer -->
<footer>
    &copy; {{ date('Y') }} GrosirMuah. Hak cipta dilindungi undang-undang.
</footer>

<!-- Bootstrap JS & Icons -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<!-- Tambahan Script Dinamis -->
@stack('scripts')

</body>
</html>