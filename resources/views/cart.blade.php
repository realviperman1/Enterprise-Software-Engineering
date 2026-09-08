@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="display-5 fw-bold mb-4" style="color: var(--theme-primary);">{{ __('Your Shopping Cart') }}</h1>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(empty($enrichedCart))
        <div class="text-center py-5">
            <h3 class="text-muted fw-normal">{{ __('Your cart is currently empty.') }}</h3>
            <a href="{{ route('home') }}" class="btn btn-theme-primary btn-lg mt-4 px-5 fw-bold">{{ __('Browse Tours') }}</a>
        </div>
    @else
        <div class="row g-4">
            <!-- Cart Items -->
            <div class="col-lg-8">
                @foreach($enrichedCart as $cartId => $item)
                    <div class="card shadow-sm border-0 mb-3">
                        <div class="card-body d-flex flex-column flex-md-row align-items-center justify-content-between p-4">
                            
                            <div class="mb-3 mb-md-0 text-center text-md-start">
                                <h4 class="h5 fw-bold mb-1">{{ $item['tour']->name }}</h4>
                                <p class="text-muted small mb-0">
                                    <i class="bi bi-calendar-event"></i> {{ __('Date:') }} <strong>{{ \Carbon\Carbon::parse($item['date'])->translatedFormat('F j, Y') }}</strong>
                                </p>
                            </div>
                            
                            <div class="d-flex align-items-center w-100 justify-content-between" style="max-width: 350px;">
                                <div class="text-center px-2">
                                    <span class="d-block text-muted small text-uppercase">{{ __('Price') }}</span>
                                    <span class="fw-semibold">${{ number_format($item['tour']->base_price, 2) }}</span>
                                </div>
                                
                                <div class="text-center px-2">
                                    <span class="d-block text-muted small text-uppercase">{{ __('Qty') }}</span>
                                    <span class="fw-semibold">{{ $item['quantity'] }}</span>
                                </div>
                                
                                <div class="text-center px-2">
                                    <span class="d-block text-muted small text-uppercase">{{ __('Subtotal') }}</span>
                                    <span class="fw-bold text-dark fs-5">${{ number_format($item['subtotal'], 2) }}</span>
                                </div>
                            </div>

                            <form action="{{ route('cart.remove') }}" method="POST" class="mt-3 mt-md-0 ms-md-3">
                                @csrf
                                <input type="hidden" name="cart_id" value="{{ $cartId }}">
                                <button type="submit" class="btn btn-sm btn-outline-danger fw-bold px-3 py-2">
                                    {{ __('Remove') }}
                                </button>
                            </form>
                            
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Order Summary Sidebar -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 sticky-top" style="top: 100px;">
                    <div class="card-body p-4">
                        <h3 class="h5 fw-bold border-bottom pb-3 mb-3">{{ __('Order Summary') }}</h3>
                        
                        <div class="d-flex justify-content-between mb-2 text-muted">
                            <span>{{ __('Subtotal') }}</span>
                            <span>${{ number_format($total, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-4 text-muted">
                            <span>{{ __('Taxes & Fees') }}</span>
                            <span>{{ __('Calculated at checkout') }}</span>
                        </div>
                        
                        <div class="d-flex justify-content-between mb-4 border-top pt-3">
                            <span class="h5 fw-bold">{{ __('Total') }}</span>
                            <span class="h4 fw-bold" style="color: var(--theme-primary);">${{ number_format($total, 2) }}</span>
                        </div>
                        
                        <!-- Temporary Checkout Form -->
                        <form action="{{ route('checkout.process') }}" method="POST">
                            @csrf
                            <input type="hidden" name="customer_name" value="Guest User">
                            <input type="hidden" name="customer_email" value="guest@example.com">
                            <button type="submit" class="btn btn-theme-primary btn-lg w-100 fw-bold shadow-sm py-3">
                                {{ __('Proceed to Checkout') }}
                            </button>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
