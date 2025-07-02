@props(['status'])

@if ($status)
    <div class="alert alert-success alert-dismissible mb-0" role="alert">
        {{ $status }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
