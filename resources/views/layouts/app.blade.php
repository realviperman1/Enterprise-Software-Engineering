<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <title>{{ $website->seo_title ?? $website->name }}</title>
    <meta name="description" content="{{ $website->description }}">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root {
            /* Fallback to default Bootstrap colors if branding is missing */
            --theme-primary: {{ $website->branding_details['primary_color'] ?? '#0d6efd' }};
            --theme-secondary: {{ $website->branding_details['secondary_color'] ?? '#6c757d' }};
        }
        
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }

        /* 1. Navbar / Top Header overrides */
        .navbar.bg-theme-primary {
            background-color: var(--theme-primary) !important;
        }
        /* Ensure accessibility and contrast with pure white text */
        .navbar.bg-theme-primary .navbar-brand,
        .navbar.bg-theme-primary .nav-link {
            color: #ffffff !important;
        }

        /* 2. Main Hero Section background */
        .hero-section {
            background-color: var(--theme-primary);
            color: #ffffff;
            padding: 5rem 1.5rem;
            text-align: center;
            border-bottom: 5px solid var(--theme-secondary);
        }

        /* 3. Primary Buttons */
        .btn-theme-primary {
            background-color: var(--theme-primary) !important;
            border-color: var(--theme-primary) !important;
            color: #ffffff !important;
            transition: filter 0.2s ease-in-out;
        }
        
        /* 4. Button hover states (Brightness filter prevents need for distinct hover hex) */
        .btn-theme-primary:hover, .btn-theme-primary:focus {
            filter: brightness(0.85);
            color: #ffffff !important;
        }

        /* 5. Footer styling */
        .footer-theme {
            background-color: var(--theme-primary);
            color: #ffffff;
        }
        .footer-theme a {
            color: #ffffff;
            text-decoration: underline;
        }
        .footer-theme a:hover {
            filter: brightness(0.85);
        }
    </style>
</head>
<body>
    <x-header :website="$website" />

    <main class="flex-grow-1">
        @yield('content')
    </main>

    <x-footer :website="$website" />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
</body>
</html>
