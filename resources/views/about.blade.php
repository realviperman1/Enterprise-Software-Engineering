@extends('layouts.app')

@section('content')
<div class="bg-theme-primary text-white text-center py-5 mb-4 shadow-sm">
    <div class="container py-4">
        <h1 class="display-3 fw-bold mb-0">{{ __('About Us') }}</h1>
    </div>
</div>
<div class="container pb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <img src="{{ asset('images/about-' . $website->id . '.jpg') }}" alt="{{ __('About') }} {{ $website->name }}" class="float-md-end ms-md-4 mb-3 rounded img-fluid shadow-sm" style="max-width: 400px; object-fit: cover; aspect-ratio: 4/3;">
                    <p class="lead">
                        {{ __('Welcome to') }} <strong>{{ $website->name }}</strong>. {{ __('We are dedicated to providing the best travel experiences and tours in the world.') }}
                    </p>
                    <p>
                        {{ $website->description }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
