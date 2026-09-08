@props(['website'])

<header class="shadow-sm sticky-top">
    <nav class="navbar navbar-expand-lg bg-theme-primary">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4" href="{{ route('home') }}">
                {{ $website->name }}
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 fw-medium align-items-center">
                    <li class="nav-item"><a class="nav-link" href="#">{{ __('Tours') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">{{ __('About Us') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">{{ __('Contact') }}</a></li>
                    <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
                        <a class="btn btn-light btn-sm fw-bold text-dark px-3 rounded-pill shadow-sm" href="{{ route('cart.index') }}">
                            🛒 {{ __('Cart') }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
