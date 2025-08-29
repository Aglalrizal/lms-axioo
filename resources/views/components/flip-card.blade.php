@props(['item'])

<div class="flip-card">
    <div class="flip-card-inner">
        <div class="flip-card-front">
            <div class="flip-card-img">
                <img @if (isset($item->photo_path) && $item->photo_path) src="{{ $item->photo_path }}" 
                @else src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" @endif
                    alt="Foto {{ $item->nama }}">
            </div>
            <div class="team-info text-center">
                <p class="fw-bold mb-n1" style="color: white;">{{ $item->nama }}</p>
                <p class="fw-dark mb-0" style="color: white;">{{ $item->jabatan }}</p>
            </div>
        </div>
        <div class="flip-card-back p-5 d-flex flex-column justify-content-center align-items-center">
            <p class="text-center text-dark fw-semibold">{{ $item->deskripsi }}</p>
            <a href="{{ $item->linkedin }}">
                <i class="bi bi-linkedin text-warning" style="font-size: 2rem;"></i>
            </a>
        </div>

    </div>
</div>
