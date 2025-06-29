@props(['title'])

<div class="d-grid">
    <a href="{{ route('auth.redirect', ['provider' => 'google']) }}"
        class="btn btn-outline-dark d-flex align-items-center justify-content-center gap-1">
        <span>{{ $title }} with</span>
        <img src="{{ asset('assets/images/brand/logo/google-icon.png') }}" alt="Google Logo" height="45">
    </a>
</div>
