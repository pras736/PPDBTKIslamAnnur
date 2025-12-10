<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'TK Islam Annur')</title>

    <!-- AdminLTE & dependencies -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta3/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        :root {
            --brand: #16a34a;
            --brand-700: #15803d;
            --sidebar: #1f5f50;
            --sidebar-hover: rgba(255, 255, 255, 0.12);
        }

        .bg-brand {
            background-color: var(--brand) !important;
        }

        .text-brand {
            color: var(--brand) !important;
        }

        .app-sidebar .nav-link.active {
            background-color: var(--sidebar-hover);
            color: #fff;
            border-left: 3px solid #a5f3c7;
        }

        .app-sidebar .nav-icon {
            width: 1.5rem;
        }

        .app-header .nav-link {
            color: #4b5563;
        }

        .brand-text {
            font-weight: 700;
            letter-spacing: 0.3px;
        }

        .app-sidebar {
            background-color: var(--sidebar);
            color: #e7f5ef;
        }

        .app-sidebar .nav-link {
            color: #e7f5ef;
        }

        .app-sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.08);
            color: #fff;
        }

        .small-box .icon {
            top: 14px;
            right: 14px;
            opacity: 0.18;
        }

        .small-box .icon > i {
            font-size: 32px;
        }

        .small-box .inner h3 {
            font-weight: 700;
        }
    </style>

    @stack('styles')
</head>
<body class="layout-fixed sidebar-expand-md bg-body-tertiary">
@php
    $user = Auth::user();
    $isAdmin = $user && $user->role === 'admin';
    $isGuru = $user && $user->role === 'guru';
    $dashboardRoute = $isAdmin
        ? route('admin.dashboard')
        : ($isGuru ? route('guru.dashboard') : route('home'));
    $active = function ($patterns) {
        foreach ((array) $patterns as $pattern) {
            if (request()->routeIs($pattern)) {
                return 'active';
            }
        }
        return '';
    };
    $pageTitle = trim($__env->yieldContent('page-title'));
    if ($pageTitle === '') {
        $pageTitle = trim($__env->yieldContent('title', 'TK Islam Annur'));
    }
@endphp
<div class="app-wrapper">
    <nav class="app-header navbar navbar-expand bg-white shadow-sm">
        <div class="container-fluid">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ $dashboardRoute }}" class="nav-link">Dashboard</a>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item me-3">
                    <span class="nav-link">
                        <i class="fas fa-user-circle me-1"></i>
                        {{ $user->username ?? 'User' }}
                    </span>
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-sign-out-alt me-1"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    <aside class="app-sidebar bg-dark text-white shadow">
        <div class="sidebar-brand d-flex align-items-center px-3 py-3 bg-brand">
            <a href="{{ $dashboardRoute }}" class="brand-link text-white text-decoration-none d-flex align-items-center">
                <img src="{{ asset('images/logo-tk-annur.jpg') }}" alt="Logo" class="brand-image img-circle elevation-2" style="opacity:.9; width:32px; height:32px; object-fit:cover;">
                <span class="brand-text ms-2">TK Islam Annur</span>
            </a>
        </div>
        <div class="sidebar-wrapper mt-3">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
                    @if($isAdmin)
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ $active('admin.dashboard') }}">
                                <i class="nav-icon fas fa-home"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.pembayaran.index') }}" class="nav-link {{ $active('admin.pembayaran.*') }}">
                                <i class="nav-icon fas fa-receipt"></i>
                                <p>Pembayaran</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.murid.index') }}" class="nav-link {{ $active(['admin.murid.*', 'admin.export.murid']) }}">
                                <i class="nav-icon fas fa-children"></i>
                                <p>Murid</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.guru.index') }}" class="nav-link {{ $active('admin.guru.*') }}">
                                <i class="nav-icon fas fa-user-graduate"></i>
                                <p>Guru</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.kelas.index') }}" class="nav-link {{ $active('admin.kelas.*') }}">
                                <i class="nav-icon fas fa-school"></i>
                                <p>Kelas</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.export.murid') }}" class="nav-link {{ $active('admin.export.murid') }}">
                                <i class="nav-icon fas fa-file-export"></i>
                                <p>Export Data Murid</p>
                            </a>
                        </li>
                    @endif

                    @if($isGuru)
                        <li class="nav-item">
                            <a href="{{ route('guru.dashboard') }}" class="nav-link {{ $active('guru.dashboard') }}">
                                <i class="nav-icon fas fa-home"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('guru.dashboard') }}" class="nav-link {{ $active('guru.kelas.*') }}">
                                <i class="nav-icon fas fa-list-alt"></i>
                                <p>Data Kelas</p>
                            </a>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </aside>

    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row align-items-center mb-2">
                    <div class="col">
                        <h1 class="m-0 h4">{{ $pageTitle }}</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </main>

    <footer class="app-footer text-center small">
        <div class="float-end d-none d-sm-inline">
            AdminLTE-inspired UI
        </div>
        <strong>TK Islam Annur</strong>
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta3/dist/js/adminlte.min.js"></script>
@stack('scripts')
</body>
</html>

