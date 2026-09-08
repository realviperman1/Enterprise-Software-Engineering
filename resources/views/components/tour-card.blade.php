@props(['title', 'description', 'price', 'imageUrl'])

<article class="card h-100 border-0 shadow-sm overflow-hidden">
    <img src="{{ $imageUrl }}" class="card-img-top object-fit-cover" alt="{{ $title }}" height="220" loading="lazy">
    <div class="card-body d-flex flex-column p-4">
        <h3 class="card-title h5 fw-bold text-theme-primary">{{ $title }}</h3>
        <p class="card-text text-muted mb-4 small">{{ $description }}</p>
        <div class="mt-auto d-flex justify-content-between align-items-center">
            <span class="fs-5 fw-bold text-dark">${{ number_format($price, 2) }}</span>
            <button class="btn btn-theme-primary px-4">{{ __('Book Now') }}</button>
        </div>
    </div>
</article>
