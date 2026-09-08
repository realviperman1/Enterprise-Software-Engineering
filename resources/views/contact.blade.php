@extends('layouts.app')

@section('content')
<div class="bg-theme-primary text-white text-center py-5 mb-4 shadow-sm">
    <div class="container py-4">
        <h1 class="display-3 fw-bold mb-0">{{ __('Contact Us') }}</h1>
    </div>
</div>
<div class="container pb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <p class="lead">{{ __('Have a question? We would love to hear from you.') }}</p>
                    <form>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Name') }}</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Email') }}</label>
                            <input type="email" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Message') }}</label>
                            <textarea class="form-control" rows="4"></textarea>
                        </div>
                        <button type="button" class="btn btn-primary">{{ __('Send Message') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
