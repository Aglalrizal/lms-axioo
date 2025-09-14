<section class="p-lg-5 py-7">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 mb-5">
                <div class="position-relative rounded-4 overflow-hidden"
                    style="{{ $course->thumbnail ? '' : 'height: 300px' }}">
                    @if ($course->thumbnail)
                        @if (str_contains($course->thumbnail, 'samples'))
                            <img src="{{ asset($course->thumbnail) }}" alt="{{ $course->title }}-cover"
                                class="w-100 h-100 object-cover">
                        @else
                            <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}-cover"
                                class="w-100 h-100 object-cover">
                        @endif
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
                        <div class="d-flex mb-5 lh-1">
                            <span class="d-none d-md-block">
                                <i class="bi bi-bar-chart-fill"></i>
                                <span>{{ Str::title($course->level->label()) }}</span>
                            </span>
                            <span class="ms-4 d-none d-md-block">
                                <i class="bi bi-cash"></i>
                                <span>{{ Str::title($course->access_type->label()) }}</span>
                                @if ($course->access_type->value == 'paid' || $course->access_type->value == 'free_trial')
                                    | {{ $course->price_formatted }}
                                @endif
                            </span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div class="d-flex align-items-center">
                                <img src="{{ optional($course->teacher)->profile_picture
                                    ? asset('storage/' . $course->teacher->profile_picture)
                                    : 'https://ui-avatars.com/api/?background=random&name=' . urlencode(optional($course->teacher)->full_name) }}"
                                    alt="{{ $course->teacher->full_name . '-avatar' }}"
                                    class="rounded-circle avatar-xs" />
                                <div class="ms-2 lh-1">
                                    <h4 class="mb-1">
                                        {{ $course->teacher->full_name }}
                                    </h4>
                                    <p class="fs-6 mb-0">{{ '@' . $course->teacher->username }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <ul class="nav nav-lt-tab" id="tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link @if ($activeTab === 'description') active @endif"
                                wire:click.prevent="setActiveTab('description')" id="description-tab"
                                data-bs-toggle="pill" href="#description" role="tab" aria-controls="description"
                                aria-selected="false">Deskripsi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if ($activeTab === 'enrolled') active @endif"
                                wire:click.prevent="setActiveTab('enrolled')" id="enrolled-tab" data-bs-toggle="pill"
                                href="#enrolled" role="tab" aria-controls="enrolled"
                                aria-selected="false">Peserta</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if ($activeTab === 'quiz') active @endif"
                                wire:click.prevent="setActiveTab('quiz')" id="quiz-tab" data-bs-toggle="pill"
                                href="#quiz" role="tab" aria-controls="quiz" aria-selected="false">Quiz</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if ($activeTab === 'assignment') active @endif"
                                wire:click.prevent="setActiveTab('assignment')" id="assignment-tab"
                                data-bs-toggle="pill" href="#assignment" role="tab" aria-controls="assignment"
                                aria-selected="false">Tugas</a>
                        </li>
                    </ul>
                </div>
                <!-- Card -->
                <div class="card rounded-3">
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="tab-content" id="tabContent">
                            <!-- Tab pane -->
                            <div class="tab-pane fade @if ($activeTab === 'description') show active @endif"
                                id="description" role="tabpanel" aria-labelledby="description-tab">
                                <div class="mb-3">
                                    <h3 class="mb-2">Deskripsi Kursus</h3>
                                    {!! $course->description !!}
                                </div>
                                @if ($course->extra_description)
                                    <div class="mb-3">
                                        <hr />
                                        <h3 class="mb-2">Lain-lain</h3>
                                        <hr />
                                        {!! $course->extra_description !!}
                                    </div>
                                @endif
                            </div>
                            <div class="tab-pane fade @if ($activeTab === 'enrolled') show active @endif"
                                id="enrolled" role="tabpanel" aria-labelledby="enrolled-tab">
                                <div class="row mb-5">
                                    <div class="col-12">
                                        <div>
                                            <h1 class="h2 mb-0">Peserta</h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-5 gap-2 gap-md-0">
                                    <div class="col-md-6 col-12">
                                        <input type="search" class="form-control" placeholder="Cari berdasarkan nama"
                                            wire:model.live="searchEnrolled" />
                                    </div>
                                    <!-- Button -->
                                    <div class="col-md-4 col-12">
                                        <a class="btn btn-success text-center" data-bs-toggle="modal"
                                            data-bs-target="#enrollUserModal"><i class="bi bi-plus fs-5"></i></a>
                                        <a class="btn btn-success text-center"
                                            href="{{ route('admin.course.published.import', $course->slug) }}">Import</a>
                                    </div>
                                </div>
                                <div class="card">
                                    <!-- Table -->
                                    <div class="table-responsive">
                                        <table class="table table-hover table-centered m-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Nama</th>
                                                    <th>Tanggal Daftar</th>
                                                    <th>Progres</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($enrolledStudents as $enroll)
                                                    <tr>
                                                        <td>{{ $enroll->student->first_name . ' ' . $enroll->student->surname }}
                                                        </td>
                                                        <td>{{ $enroll->enrolled_at->format('d M Y H:i') }}
                                                        </td>
                                                        <td>
                                                            @php
                                                                $completed = (int) ($enroll->completed_contents ?? 0);
                                                                $total = (int) ($totalContents ?? 0);
                                                                $progress =
                                                                    $total > 0 ? round(($completed / $total) * 100) : 0;
                                                            @endphp
                                                            {{ $progress }}%
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="3" class="text-center">
                                                            <i class="bi bi-exclamation-triangle"></i>
                                                            Belum ada yang mendaftar
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="p-3">
                                    {{ $enrolledStudents->links() }}
                                </div>
                            </div>
                            <div class="tab-pane fade @if ($activeTab === 'quiz') show active @endif"
                                id="quiz" role="tabpanel" aria-labelledby="quiz-tab">
                                <div class="row mb-5">
                                    <div class="col-12">
                                        <div>
                                            <h1 class="h2 mb-0">Kuis</h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-5">
                                    <div class="col-md-6 col-12">
                                        <input type="search" class="form-control"
                                            placeholder="Cari berdasarkan nama" wire:model.live="searchQuiz" />
                                    </div>
                                </div>
                                <div class="card">
                                    <!-- Table -->
                                    <div class="table-responsive">
                                        <table class="table table-hover table-centered m-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Nama Kuis</th>
                                                    <th>Siswa</th>
                                                    <th>Nilai</th>
                                                    {{-- <th>Aksi</th> --}}
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($quizzes as $quiz)
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <a href="{{ route('admin.course.published.quiz', $course->slug) }}?quiz_id={{ $quiz->id }}"
                                                                    class="mb-0">
                                                                    {{ $quiz->courseContent->title }}</a>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            {{ $quiz->participants_count ?? 0 }} siswa
                                                        </td>
                                                        <td>
                                                            @if (($quiz->participants_count ?? 0) > 0 && ($quiz->questions_count ?? 0) > 0)
                                                                {{ number_format($quiz->average_percentage ?? 0, 1) }}%
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                        {{-- <td>
                                                            <a href="{{ route('admin.course.published.quiz', $course->slug) }}?quiz_id={{ $quiz->id }}"
                                                                class="btn btn-sm btn-primary">
                                                                <i class="bi bi-eye me-1"></i>Detail
                                                            </a>
                                                        </td> --}}
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center">
                                                            <i class="bi bi-exclamation-triangle"></i>
                                                            Belum ada kuis untuk kursus ini
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="p-3">
                                    {{ $quizzes->links() }}
                                </div>
                            </div>
                            <div class="tab-pane fade @if ($activeTab === 'assignment') show active @endif"
                                id="assignment" role="tabpanel" aria-labelledby="assignment-tab">
                                <div class="row mb-5">
                                    <div class="col-12">
                                        <div>
                                            <h1 class="h2 mb-0">Tugas</h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-5">
                                    <div class="col-md-6 col-12">
                                        <input type="search" class="form-control"
                                            placeholder="Cari berdasarkan nama" wire:model.live="searchAssignment" />
                                    </div>
                                </div>
                                <div class="card">
                                    <!-- Table -->
                                    <div class="table-responsive">
                                        <table class="table table-hover table-centered m-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Judul Tugas</th>
                                                    <th>Siswa Mengumpulkan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($assignments as $assignment)
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <span
                                                                    class="mb-0">{{ $assignment->courseContent->title }}</span>
                                                            </div>
                                                        </td>
                                                        <td>{{ $assignment->submitters_count ?? 0 }} siswa</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="2" class="text-center">
                                                            <i class="bi bi-exclamation-triangle"></i>
                                                            Belum ada tugas untuk kursus ini
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="p-3">
                                    {{ $assignments->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-xl-4 col-lg-12 col-md-12 col-12">
                <div class="card" id="courseAccordion">
                    <div>
                        <!-- List group -->
                        <ul class="list-group list-group-flush">
                            @foreach ($course->syllabus as $syllabus)
                                <li class="list-group-item p-0">
                                    <!-- Toggle -->
                                    <a class="h4 mb-0 d-flex justify-content-between py-3 px-4 w-100 border-bottom"
                                        data-bs-toggle="collapse" href="#syllabus{{ $syllabus->order }}"
                                        role="button" aria-expanded="false"
                                        aria-controls="syllabus{{ $syllabus->order }}">

                                        <div class="me-auto d-flex flex-column">
                                            <span>{{ $syllabus->title }}</span>

                                            <div class="fs-5 fw-normal text-break">
                                                {{ $syllabus->description }}
                                            </div>

                                            <p
                                                class="mb-0 fs-6 mt-3 fw-normal badge text-light-emphasis bg-light-subtle border border-light-subtle">
                                                {{ $syllabus->courseContents->where('type', 'article')->count() }}
                                                Artikel,
                                                {{ $syllabus->courseContents->where('type', 'video')->count() }}
                                                Video,
                                                {{ $syllabus->courseContents->where('type', 'quiz')->count() }}
                                                Kuis,
                                                {{ $syllabus->courseContents->where('type', 'assignment')->count() }}
                                                Tugas
                                            </p>
                                        </div>

                                        <!-- Chevron -->
                                        <div class="chevron-arrow ms-4 d-flex align-items-center">
                                            <i class="fe fe-chevron-down fs-4"></i>
                                        </div>
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
                                                    <div class="text-truncate text-dark">
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
    <livewire:course.published.enroll :courseId="$course->id" />
</section>
@script
    <script>
        Livewire.on('refresh-course', (event) => {
            var enrollUserModalEl = document.querySelector('#enrollUserModal')
            var enrollUserModal = bootstrap.Modal.getOrCreateInstance(enrollUserModalEl)
            enrollUserModal.hide();
            Livewire.dispatch('reset-enroll-modal');
        })

        var enrollUserModalEl = document.getElementById('enrollUserModal')
        enrollUserModalEl.addEventListener('hidden.bs.modal', (event) => {
            document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
            document.body.classList.remove('modal-open');
            document.body.style.overflow = '';
            Livewire.dispatch('reset-enroll-modal');
        })
    </script>
@endscript
