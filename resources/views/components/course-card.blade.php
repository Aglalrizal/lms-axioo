@props(['course'])

<a href={{ route('course.show', $course->slug) }} class="course-card">
    <div class="course-img-container">
        <img src="{{ asset($course->thumbnail) }}" alt="#">
        <div class="course-badge-container">
            @if ($course->access_type->value === 'free')
                <div class="course-badge">Free</div>
            @elseif ($course->access_type->value === 'free_trial')
                <div class="course-badge">Free Trial</div>
            @endif
        </div>
    </div>
    <div class="course-card-body">
        <div class="course-card-body-top">
            <p class="course-program text-secondary"> {{ $course->program->name }}</p>
            <p class="course-title"> {{ $course->title }} </p>
            <p class="course-description text-secondary"> {{ $course->short_desc }}</p>
        </div>
        <div class="course-card-body-bottom text-secondary">
            <p>{{ ucfirst($course->level->value) }} &#9702; {{ $course->duration }} Jam</p>
        </div>
    </div>
</a>
