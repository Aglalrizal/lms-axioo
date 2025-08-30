@props(['blog'])

<a href={{ route('public.blog.show', $blog->id) }} class="custom-card custom-card-blog">
    <div class="custom-card-img-container">
        <img src="{{ asset($blog->photo_path) }}" alt="#">
        {{-- <div class="custom-card-badge-container">
            @if ($blog->access_type->value === 'free')
                <div class="custom-card-badge">Free</div>
            @elseif ($blog->access_type->value === 'free_trial')
                <div class="custom-card-badge">Free Trial</div>
            @endif
        </div> --}}
    </div>
    <div class="custom-card-body">
        <div class="custom-card-body-top card-body-top-blog">
            <div class="custom-card-meta-container">
                <p class="custom-card-meta-left text-secondary"> {{ $blog->author->username }}</p>
                <p class="custom-card-meta-right text-secondary"> {{ $blog->created_at->diffForHumans() }}</p>
            </div>
            <p class="custom-card-title"> {{ $blog->title }} </p>
            <p class="custom-card-content text-secondary content-blog"> {{ $blog->excerpt }}</p>
        </div>
        {{-- <div class="custom-card-body-bottom text-secondary">
            <p>{{ ucfirst($blog->level->value) }} &#9702; {{ $blog->duration }} Jam</p>
        </div> --}}
    </div>
</a>
