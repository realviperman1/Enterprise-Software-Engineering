@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-8">
            <h1 class="display-4 text-primary">{{ $tour->name }}</h1>
            <img src="{{ asset('images/tour-' . $tour->id . '.jpg') }}" class="img-fluid rounded mb-4" alt="{{ $tour->name }}">
            <p class="lead">{{ $tour->description }}</p>
            <hr>
            <h3>{{ __('Select a Date') }}</h3>
            <!-- Interactive Booking Calendar Component -->
            <x-booking-calendar :tour="$tour" />
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 sticky-top" style="top: 100px;">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">{{ __('Book Tour') }}</h3>
                    <h2 class="text-center text-primary mb-4">$<span id="price">{{ number_format($tour->base_price, 2) }}</span></h2>
                    
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="tour_id" value="{{ $tour->id }}">
                        <input type="hidden" name="selected_date" id="selected_date" required>
                        
                        <div class="mb-3">
                            <label class="form-label">{{ __('Number of Guests') }}</label>
                            <input type="number" name="quantity" class="form-control" value="1" min="1">
                        </div>
                        
                        <div class="d-grid mt-4">
                            <button type="submit" id="add-to-cart-btn" class="btn btn-theme-primary btn-lg fw-semibold text-white" disabled>
                                {{ __('Add to Cart') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
