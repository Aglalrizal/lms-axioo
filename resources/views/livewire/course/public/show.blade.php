<main>
    <!-- Page header -->
    <section class="pt-lg-8 pb-8 bg-primary">
        <div class="container pb-lg-8">
            <div class="row align-items-center">
                <div class="col-xl-7 col-lg-7 col-md-12">
                    <div>
                        <h1 class="text-white display-4 fw-semibold">{{ $course->title }}</h1>
                        <p class="text-white mb-6 lead">{{ $course->short_desc ?? '' }}</p>
                        <div class="d-flex align-items-center">
                            <a href="#" class="bookmark text-white">
                                <i class="fe fe-bookmark fs-4 me-2"></i>
                                Bookmark
                            </a>

                            <span class="text-white ms-3">
                                <i class="fe fe-user"></i>
                                1200 Enrolleds
                            </span>
                            {{-- <div>
                                <span class="fs-6 ms-4 align-text-top">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                        fill="currentColor" class="bi bi-star-fill text-warning" viewBox="0 0 16 16">
                                        <path
                                            d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z">
                                        </path>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                        fill="currentColor" class="bi bi-star-fill text-warning" viewBox="0 0 16 16">
                                        <path
                                            d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z">
                                        </path>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                        fill="currentColor" class="bi bi-star-fill text-warning" viewBox="0 0 16 16">
                                        <path
                                            d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z">
                                        </path>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                        fill="currentColor" class="bi bi-star-fill text-warning" viewBox="0 0 16 16">
                                        <path
                                            d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z">
                                        </path>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                        fill="currentColor" class="bi bi-star-fill text-warning" viewBox="0 0 16 16">
                                        <path
                                            d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z">
                                        </path>
                                    </svg>
                                </span>
                                <span class="text-white">(140)</span>
                            </div> --}}
                            <span class="text-white ms-4 d-none d-md-block">
                                <i class="bi bi-bar-chart-fill"></i>
                                <span class="align-middle">{{ $course->level->label() }}</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Page content -->
    <section class="pb-8">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12 col-12 mt-n8 mb-4 mb-lg-0">
                    <!-- Card -->
                    <div class="card rounded-3">
                        <!-- Card header -->
                        <div class="card-header border-bottom-0 p-0">
                            <div>
                                <!-- Nav -->
                                <ul class="nav nav-lb-tab" id="tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" id="description-tab" data-bs-toggle="pill"
                                            href="#description" role="tab" aria-controls="description"
                                            aria-selected="true" tabindex="-1">Deskripsi</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="table-tab" data-bs-toggle="pill" href="#instructor"
                                            role="tab" aria-controls="table" aria-selected="false">Instruktur</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body">
                            <div class="tab-content" id="tabContent">
                                <div class="tab-pane fade show active" id="description" role="tabpanel"
                                    aria-labelledby="description-tab">
                                    <div class="mb-4">
                                        <h3 class="mb-2">Deskripsi Kursus</h3>
                                        {!! $course->description !!}
                                    </div>
                                    <div class="mb-3">
                                        <hr />
                                        <h3 class="mb-2">Lain-lain</h3>
                                        <hr />
                                        {!! $course->extra_description !!}
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="instructor" role="tabpanel"
                                    aria-labelledby="instructor-tab">
                                    <div class="my-3">
                                        <div class="d-flex align-items-center">
                                            <div class="position-relative">
                                                <img src="{{ $course->teacher->avatar_url }}"
                                                    alt="{{ $course->teacher->full_name }}-avatar"
                                                    class="rounded-circle avatar-xl">
                                                <a href="#" class="position-absolute mt-2 ms-n3"
                                                    data-bs-toggle="tooltip" data-placement="top" aria-label="Verifed"
                                                    data-bs-original-title="Verifed">
                                                    <img src="../assets/images/svg/checked-mark.svg" alt="checked-mark"
                                                        height="30" width="30">
                                                </a>
                                            </div>
                                            <div class="ms-4">
                                                <h4 class="mb-0">{{ $course->teacher->full_name }}</h4>
                                                <p class="mb-1 fs-6">Front-end Developer, Designer</p>
                                                <p class="fs-6 mb-1 d-flex align-items-center">
                                                    <span class="text-warning">4.5</span>
                                                    <span class="mx-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="10"
                                                            height="10" fill="currentColor"
                                                            class="bi bi-star-fill text-warning" viewBox="0 0 16 16">
                                                            <path
                                                                d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z">
                                                            </path>
                                                        </svg>
                                                    </span>
                                                    Instructor Rating
                                                </p>
                                            </div>
                                        </div>
                                        <div class="border-top row mt-3 border-bottom mb-3 g-0">
                                            <div class="col">
                                                <div class="pe-1 ps-2 py-3">
                                                    <h5 class="mb-0">11,604</h5>
                                                    <span>Students</span>
                                                </div>
                                            </div>
                                            <div class="col border-start">
                                                <div class="pe-1 ps-3 py-3">
                                                    <h5 class="mb-0">{{ $course->teacher->courses->count() }}</h5>
                                                    <span>Courses</span>
                                                </div>
                                            </div>
                                            <div class="col border-start">
                                                <div class="pe-1 ps-3 py-3">
                                                    <h5 class="mb-0">12,230</h5>
                                                    <span>Reviews</span>
                                                </div>
                                            </div>
                                        </div>
                                        <p>I am an Innovation designer focussing on UX/UI based in Berlin. As a
                                            creative resident at
                                            Figma explored the city of the future and how new technologies.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-12 mt-lg-n8">
                    <!-- Card -->
                    <div class="card mb-3">
                        <div class="p-1">
                            <div class="d-flex justify-content-center align-items-center rounded border-white border rounded-3 bg-cover"
                                style="background-image: 
                                url(
                                    @if (str_contains($course->thumbnail, 'samples')) {{ asset($course->thumbnail) }}
                                    @else {{ asset('storage/' . $course->thumbnail) }} @endif
                                ); height: 210px">
                            </div>
                        </div>
                        <!-- Card body -->
                        <div class="card-body">
                            <!-- Price single page -->
                            <div class="mb-3">
                                <span class="text-dark fw-bold h2">{{ $course->price_formatted }}</span>
                            </div>
                            <div class="d-grid">
                                <a @if ($is_enrolled) href="{{ $this->url }}"
                                @else
                                wire:click="enrollUser" @endif
                                    class="btn btn-primary mb-2">{{ $is_enrolled ? 'Lanjut Belajar' : 'Daftar Sekarang' }}</a>
                            </div>
                        </div>
                    </div>
                    <!-- Card -->
                    <div class="card" id="courseAccordion">
                        <div>
                            <ul class="list-group list-group-flush">
                                @foreach ($course->syllabus as $syllabus)
                                    <li class="list-group-item p-0">
                                        <!-- Toggle -->
                                        <a class="h4 mb-0 d-flex align-items-center py-3 px-4"
                                            data-bs-toggle="collapse" href="#syllabus{{ $syllabus->order }}"
                                            role="button" aria-expanded="false"
                                            aria-controls="syllabus{{ $syllabus->order }}">
                                            <div class="me-auto">
                                                {{ $syllabus->title }}
                                                <p class="mb-0 fs-6 mt-1 fw-normal">
                                                    {{ $syllabus->courseContents->where('type', 'article')->count() }}
                                                    Artikel,
                                                    {{ $syllabus->courseContents->where('type', 'video')->count() }}
                                                    Video,
                                                    {{ $syllabus->courseContents->where('type', 'quiz')->count() }}
                                                    Kuis,
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
                                                            @if ($content->is_unlocked && $is_enrolled) href="{{ route('course.show.content', ['slug' => $course->slug, 'syllabusId' => $syllabus->id, 'courseContentId' => $content->id]) }}" @endif>
                                                            <div
                                                                class="text-truncate {{ $content->is_unlocked ? '' : 'text-dark' }}">
                                                                <span
                                                                    class="icon-shape bg-light text-primary icon-md rounded-circle me-2"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    data-bs-title="{{ Str::title($content->type_formatted) }}">
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
</main>
