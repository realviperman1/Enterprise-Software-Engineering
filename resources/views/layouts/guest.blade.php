@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow-sm w-100" style="max-width: 450px;">
        <div class="card-body p-4">
            {{ $slot }}
        </div>
    </div>
</div>
@endsection
