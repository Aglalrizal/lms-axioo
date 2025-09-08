@props(['course'])

<a href={{ route('course.show', $course->slug) }} class="custom-card">
    <div class="custom-card-img-container">
        <img src="{{ asset($course->thumbnail) }}" alt="#">
        {{-- <div class="custom-card-badge-container">
            @if ($course->access_type->value === 'free')
                <div class="custom-card-badge">Free</div>
            @elseif ($course->access_type->value === 'free_trial')
                <div class="custom-card-badge">Free Trial</div>
            @endif
        </div> --}}
    </div>
    <div class="custom-card-body">
        <div class="custom-card-body-top">
            <div class="custom-card-meta-container">
                <p class="custom-card-meta-left text-secondary"> {{ $course->program->name }}</p>
            </div>
            <p class="custom-card-title"> {{ $course->title }} </p>
            <div class="pt-2 d-flex flex-column gap-1">
                <div class="progress" style="height: 6px;">
                    <div class="progress-bar bg-success" role="progressbar"
                        style="width: {{ $course->progress_percentage }}%;"
                        aria-valuenow="{{ $course->progress_percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <small class="text-secondary">{{ $course->progress_percentage }}% Completed</small>
            </div>
        </div>
        <div class="custom-card-body-bottom text-secondary">
            <p>{{ ucfirst($course->level->value) }} &#9702; {{ $course->duration }} Jam</p>
        </div>
    </div>
</a>
