@extends('admin.layout')

@section('page_title', __('Executive Dashboard'))

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100 bg-primary text-white">
            <div class="card-body p-4">
                <h6 class="card-subtitle mb-2 text-white-50 fw-semibold text-uppercase">{{ __('Total Revenue') }}</h6>
                <h2 class="card-title fw-bold mb-0">${{ number_format($totalRevenue, 2) }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <h6 class="card-subtitle mb-2 text-muted fw-semibold text-uppercase">{{ __('Active Websites') }}</h6>
                <h2 class="card-title fw-bold mb-0 text-dark">{{ $websitesCount }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <h6 class="card-subtitle mb-2 text-muted fw-semibold text-uppercase">{{ __('Total Bookings') }}</h6>
                <h2 class="card-title fw-bold mb-0 text-dark">{{ $reservationsCount }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <h6 class="card-subtitle mb-2 text-muted fw-semibold text-uppercase">{{ __('Tours in Catalog') }}</h6>
                <h2 class="card-title fw-bold mb-0 text-dark">{{ $toursCount }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom py-3">
        <h5 class="mb-0 fw-bold"><i class="bi bi-activity me-2 text-primary"></i>{{ __('System Activity Overview') }}</h5>
    </div>
    <div class="card-body p-5 text-center text-muted">
        <i class="bi bi-graph-up text-light mb-3" style="font-size: 4rem;"></i>
        <p class="lead mb-0">{{ __('The centralized platform is running smoothly across all tenant domains.') }}</p>
    </div>
</div>
@endsection
