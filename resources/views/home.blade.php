@extends('layouts.app')

@section('content')
<!-- Dynamic Hero Section injected by layouts/app.blade.php styles -->
<div class="hero-section">
    <div class="container">
        <h1 class="display-4 fw-bold mb-3">{{ $website->name }}</h1>
        <p class="lead mb-4 mx-auto" style="max-width: 800px; opacity: 0.9;">
            {{ $website->description }}
        </p>
    </div>
</div>

<!-- E-commerce Tours Grid -->
<div class="container py-5">
    <h2 class="h3 fw-bold mb-4 text-center">{{ __('Featured Experiences') }}</h2>
    <div class="row g-4 justify-content-center">
        @forelse($website->tours as $tour)
            <article class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm overflow-hidden tour-card">
                    <img src="{{ asset('images/tour-' . $tour->id . '.jpg') }}" class="card-img-top" alt="{{ $tour->name }}" loading="lazy" style="height: 220px; object-fit: cover;">
                    <div class="card-body d-flex flex-column p-4">
                        <h3 class="card-title h5 fw-bold" style="color: var(--theme-primary);">{{ $tour->name }}</h3>
                        <p class="card-text text-muted mb-4 small">{{ $tour->description }}</p>
                        
                        <div class="mt-auto d-flex justify-content-between align-items-center">
                            <span class="fs-5 fw-bold text-dark">${{ number_format($tour->base_price, 2) }}</span>
                            <a href="{{ route('page.show', 'tour-' . $tour->id) }}" class="btn btn-theme-primary px-4 fw-semibold">{{ __('Book Now') }}</a>
                        </div>
                    </div>
                </div>
            </article>
        @empty
            <div class="col-12 text-center text-muted py-5">
                <h3 class="fw-normal">{{ __('No tours currently available for this destination.') }}</h3>
            </div>
        @endforelse
    </div>
</div>

<style>
    .tour-card {
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        border: 1px solid #f1f3f5;
    }
    .tour-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1) !important;
    }
</style>
@endsection
