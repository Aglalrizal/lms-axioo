<section class="p-lg-5 py-7">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 mb-5">
                <div class="position-relative rounded-4 overflow-hidden"
                    style="{{ $course->thumbnail ? '' : 'height: 300px' }}">
                    @if ($course->thumbnail)
                        <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}-cover"
                            class="w-100 h-100 object-cover">
                    @else
                        <img src="{{ asset('assets/images/course-bg.jpg') }}" alt="{{ $course->title }}-cover"
                            class="w-100 h-100 object-fit-cover position-absolute top-0 start-0">
                        <div class="position-absolute top-0 start-0 w-100 h-100"
                            style="background: linear-gradient(to top, rgba(0,0,0,0.25) 25%, transparent 100%);"></div>
                        <div class="position-relative p-4 d-flex flex-column justify-content-end h-100">
                            <h1 class="fw-bold text-white m-0" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);">
                                {{ $course->title }}
                            </h1>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- Content -->
        <div class="row">
            <div class="col-xl-8 col-lg-12 col-md-12 col-12 mb-4 mb-xl-0">
                <!-- Card -->
                <div class="card mb-5">
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h1 class="fw-semibold mb-2">{{ $course->title }}</h1>
                            {{-- <a href="#" data-bs-toggle="tooltip" data-placement="top" title="Add to Bookmarks">
                                <i class="fe fe-bookmark fs-4 fs-3 text-inherit"></i>
                            </a> --}}
                        </div>
                        <div class="d-flex mb-3 lh-1">
                            <span class="d-none d-md-block">
                                <i class="bi bi-bar-chart-fill"></i>
                                <span>{{ Str::title($course->level) }}</span>
                            </span>
                            <span class="ms-4 d-none d-md-block">
                                <i class="bi bi-cash"></i>
                                <span>{{ Str::title($course->access_type) }}</span>
                            </span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div class="d-flex align-items-center">
                                <img src="{{ optional($course->teacher)->profile_picture
                                    ? asset('storage/' . $course->teacher->profile_picture)
                                    : 'https://ui-avatars.com/api/?background=random&name=' . urlencode(optional($course->teacher)->first_name) }}"
                                    alt="{{ $course->teacher->first_name . '-avatar' }}"
                                    class="rounded-circle avatar-xs" />
                                <div class="ms-2 lh-1">
                                    <h4 class="mb-1">
                                        {{ $course->teacher->first_name . ' ' . $course->teacher->surname }}
                                    </h4>
                                    <p class="fs-6 mb-0">{{ '@' . $course->teacher->username }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <ul class="nav nav-lt-tab" id="tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link @if ($activeTab === 'description') active @endif"
                                wire:click.prevent="setActiveTab('description')" id="description-tab"
                                data-bs-toggle="pill" href="#description" role="tab" aria-controls="description"
                                aria-selected="false">Deskripsi</a>
                        </li>
                    </ul> --}}
                </div>
                <!-- Card -->
                <div class="card rounded-3">
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="tab-content" id="tabContent">
                            <!-- Tab pane -->
                            <div class="tab-pane fade show active" id="description" role="tabpanel"
                                aria-labelledby="description-tab">
                                <div>
                                    <h3 class="mb-2">Deskripsi Kursus</h3>
                                    {!! $course->description !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-12 col-md-12 col-12">
                <div class="card mb-3">
                    @if ($is_enrolled)
                        <div class="card-body p-0">
                            <div class="alert alert-info m-0 text-center">
                                Sudah terdaftar!
                            </div>
                        </div>
                    @else
                        <div class="card-body p-0">
                            <button wire:click='confirmEnrollUser' class="btn btn-success w-100">Daftar Kursus</button>
                        </div>
                    @endif
                </div>
                <div class="card" id="courseAccordion">
                    <div>
                        <ul class="list-group list-group-flush">
                            @foreach ($course->syllabus as $syllabus)
                                <li class="list-group-item p-0">
                                    <!-- Toggle -->
                                    <a class="h4 mb-0 d-flex align-items-center py-3 px-4" data-bs-toggle="collapse"
                                        href="#syllabus{{ $syllabus->order }}" role="button" aria-expanded="false"
                                        aria-controls="syllabus{{ $syllabus->order }}">
                                        <div class="me-auto">
                                            {{ $syllabus->title }}
                                            <p class="mb-0 fs-6 mt-1 fw-normal">
                                                {{ $syllabus->courseContents->where('type', 'article')->count() }}
                                                Artikel,
                                                {{ $syllabus->courseContents->where('type', 'video')->count() }} Video,
                                                {{ $syllabus->courseContents->where('type', 'quiz')->count() }} Kuis,
                                                {{ $syllabus->courseContents->where('type', 'assignment')->count() }}
                                                Assignment</p>
                                        </div>
                                        <!-- Chevron -->
                                        <span class="chevron-arrow ms-4">
                                            <i class="fe fe-chevron-down fs-4"></i>
                                        </span>
                                    </a>
                                    <!-- Row -->
                                    <!-- Collapse -->
                                    <div class="collapse show" id="syllabus{{ $syllabus->order }}"
                                        data-bs-parent="#courseAccordion">
                                        <!-- List group item -->
                                        <ul class="list-group list-group-flush">
                                            @foreach ($syllabus->courseContents as $content)
                                                <!-- List group item -->
                                                <li class="list-group-item">
                                                    <a
                                                        href="{{ route('course.show.content', ['slug' => $course->slug, 'syllabusId' => $syllabus->id, 'courseContentId' => $content->id]) }}">
                                                        <div class="text-truncate">
                                                            <span
                                                                class="icon-shape bg-light text-primary icon-md rounded-circle me-2"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                data-bs-title="{{ Str::title($content->type) }}">
                                                                <i
                                                                    class="bi
                                                                {{ $content->icon }}">
                                                                </i>
                                                            </span>
                                                            <span>
                                                                {{ $content->title }}
                                                            </span>
                                                        </div>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
