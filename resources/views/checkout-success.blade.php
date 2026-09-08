@extends('layouts.app')

@section('content')
<div class="container py-5 text-center">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm border-0 pt-4 pb-5 px-3">
                <div class="card-body">
                    <div class="mb-4">
                        <i class="bi bi-check-circle-fill" style="font-size: 5rem; color: #198754;"></i>
                    </div>
                    <h1 class="display-6 fw-bold mb-3">{{ __('Payment Successful!') }}</h1>
                    <p class="lead text-muted mb-4">{{ __('Thank you for your booking. Your reservation has been confirmed.') }}</p>
                    
                    <div class="bg-light rounded p-4 mb-4 text-start">
                        <h4 class="h5 fw-bold mb-3 border-bottom pb-2">{{ __('Booking Details') }}</h4>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2"><strong>{{ __('Reference Number:') }}</strong> {{ $reservation->reference_number }}</li>
                            <li class="mb-2"><strong>{{ __('Name:') }}</strong> {{ $reservation->customer_name }}</li>
                            <li class="mb-2"><strong>{{ __('Email:') }}</strong> {{ $reservation->customer_email }}</li>
                            <li><strong>{{ __('Amount Paid:') }}</strong> ${{ number_format($reservation->total_amount, 2) }}</li>
                        </ul>
                    </div>
                    
                    <a href="{{ route('home') }}" class="btn btn-theme-primary btn-lg px-5 fw-bold">{{ __('Return Home') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
