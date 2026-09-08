<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Enterprise Admin Panel') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #f8f9fa; }
        .sidebar { min-height: 100vh; background-color: #212529; color: #fff; }
        .sidebar a { color: rgba(255,255,255,.75); text-decoration: none; padding: 10px 15px; display: block; border-radius: 6px; margin-bottom: 5px; }
        .sidebar a:hover, .sidebar a.active { background-color: rgba(255,255,255,.1); color: #fff; }
        .top-navbar { background-color: #ffffff; box-shadow: 0 2px 4px rgba(0,0,0,.04); }
        .card { border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,.02); border: 1px solid rgba(0,0,0,.05); }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-3 col-lg-2 d-md-block sidebar py-4">
            <div class="px-3 mb-4">
                <h4 class="fw-bold fs-5 mb-0 text-white"><i class="bi bi-globe me-2"></i>{{ __('Central Admin') }}</h4>
                <small class="text-muted">{{ __('Multi-Tenant Platform') }}</small>
            </div>
            
            <ul class="nav flex-column px-2">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-speedometer2 me-2"></i> {{ __('Dashboard') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.tours.*') ? 'active' : '' }}" href="{{ route('admin.tours.index') }}">
                        <i class="bi bi-map me-2"></i> {{ __('Tour Master Catalog') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}" href="{{ route('admin.bookings.index') }}">
                        <i class="bi bi-calendar-check me-2"></i> {{ __('Central Bookings') }}
                    </a>
                </li>
                <li class="nav-item mt-4 px-3">
                    <small class="text-uppercase text-muted fw-bold" style="font-size: 0.7rem;">{{ __('System') }}</small>
                </li>
                <li class="nav-item mt-1">
                    <a class="nav-link" href="{{ route('home') }}" target="_blank">
                        <i class="bi bi-box-arrow-up-right me-2"></i> {{ __('View Storefront') }}
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <!-- Topbar -->
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2 pb-3 mb-4 border-bottom">
                <h1 class="h3 fw-bold mb-0 text-dark">@yield('page_title', 'Dashboard')</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <span class="btn btn-sm btn-outline-secondary d-flex align-items-center">
                            <i class="bi bi-person-circle me-2"></i> {{ __('Super Admin') }}
                        </span>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm"><i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger border-0 shadow-sm"><i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger border-0 shadow-sm">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
            
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
