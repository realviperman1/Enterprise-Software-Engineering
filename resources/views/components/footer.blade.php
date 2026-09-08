@props(['website'])

<footer class="footer-theme py-4 mt-auto">
    <div class="container text-center">
        <small class="mb-0">&copy; {{ date('Y') }} {{ $website->name }}. {{ __('All rights reserved.') }}</small>
    </div>
</footer>
