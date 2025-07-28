<div>
    @if ($isAddContent)
        <livewire:course.course-content wire:key="add-content" :syllabus_id="$syllabusId" :courseContentId="$courseContentId ?? null" />
    @elseif ($isAddQuiz)
        <livewire:quiz.create wire:key="add-quiz" :syllabus_id="$syllabusId" :courseContentId="$courseContentId ?? null" />
    @else
        <div wire:key="list-content">
            <!-- Card -->
            <div class="card mb-3">
                <div class="card-header border-bottom px-4 py-3">
                    <h4 class="mb-0">Curriculum</h4>
                </div>
                <!-- Card body -->
                <div class="card-body">
                    @forelse ($course->syllabus as $syllabus)
                        <div class="bg-light rounded p-2 mb-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <a class="text-dark text-decoration-none flex-grow-1" data-bs-toggle="collapse"
                                    data-bs-target="#syllabus-{{ $syllabus->id }}" aria-expanded="false"
                                    aria-controls="syllabus-{{ $syllabus->id }}">
                                    <h4 class="mb-0 text-truncate text-wrap">
                                        {{ Str::title($syllabus->title) }}
                                    </h4>
                                </a>
                                <div class="ms-2">
                                    <button wire:click="$dispatch('edit-syllabus-mode',{id:{{ $syllabus->id }}})"
                                        type="button" class="text-inherit btn btn-sm p-1" data-bs-toggle="modal"
                                        data-bs-target="#courseSyllabusModal"><i class="fe fe-edit fs-6"></i></button>
                                    <button wire:click="$dispatch('delete-syllabus',{id: {{ $syllabus->id }}})"
                                        class="btn btn-sm text-danger p-1">
                                        <i class="fe fe-trash-2 fs-6"></i>
                                    </button>
                                    <button class="text-inherit btn btn-sm p-1" data-bs-toggle="collapse"
                                        data-bs-target="#syllabus-{{ $syllabus->id }}" aria-expanded="false"
                                        aria-controls="syllabus-{{ $syllabus->id }}">
                                        <span class="chevron-arrow"><i class="fe fe-chevron-down"></i></span>
                                    </button>
                                </div>
                            </div>
                            <!-- List group -->
                            <div id="syllabus-{{ $syllabus->id }}" class="collapse mt-3">
                                <div class="list-group list-group-flush border-top-0">
                                    @forelse($syllabus->contents as $content)
                                        <div class="list-group-item rounded px-3 text-nowrap mb-1">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <h5 class="mb-0 text-truncate">
                                                    <a href="#" class="text-inherit">
                                                        <i class="fe fe-menu me-1 align-middle"></i>
                                                        <span class="align-middle">{{ $content->title }}</span>
                                                    </a>
                                                </h5>
                                                <div>
                                                    @if ($content->is_assessment)
                                                        <a wire:click="$dispatch('open-add-quiz', { syllabusId: {{ $syllabus->id }}, courseContentId: {{ $content->id }} })"
                                                            class="me-1 text-inherit" data-bs-toggle="tooltip"
                                                            data-placement="top" title="Edit">
                                                            <i class="fe fe-edit fs-6"></i>
                                                        </a>
                                                    @else
                                                        <a wire:click="$dispatch('open-add-content', { syllabusId: {{ $syllabus->id }}, courseContentId: {{ $content->id }} })"
                                                            class="me-1 text-inherit" data-bs-toggle="tooltip"
                                                            data-placement="top" title="Edit">
                                                            <i class="fe fe-edit fs-6"></i>
                                                        </a>
                                                    @endif
                                                    <a wire:click="$dispatch('delete-course-content', { id: {{ $content->id }} })"
                                                        class="me-1 text-inherit" data-bs-toggle="tooltip"
                                                        data-placement="top" title="Delete">
                                                        <i class="fe fe-trash-2 fs-6 text-danger"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div>
                                            <h5 class="m-0">Belum ada konten.</h5>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                            <button class="btn btn-outline-primary btn-sm mt-3"
                                wire:click='$dispatch("open-add-content", {syllabusId: {{ $syllabus->id }} })'>Tambah
                                Konten</button>
                            <button class="btn btn-outline-primary btn-sm mt-3"
                                wire:click='$dispatch("open-add-quiz", {syllabusId: {{ $syllabus->id }} })'>Tambah
                                Kuis</button>
                        </div>
                    @empty
                        <p class="text-secondary text-sm">Belum ada Silabus.</p>
                    @endforelse
                    <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#courseSyllabusModal">Tambah Silabus</button>
                </div>
            </div>
            <!-- Button -->
            <div class="card-footer">
                <x-course-multi-step-nav :step="$step" :slug="$slug" />
            </div>
        </div>
    @endif
    <livewire:admin.course.syllabus-modal :courseId="$course->id" />
</div>

@assets
    <script src="https://cdn.jsdelivr.net/gh/livewire/sortable@v1.x.x/dist/livewire-sortable.js"></script>
@endassets


@script
    <script>
        Livewire.on('refresh-syllabus', () => {
            var myCourseSyllabusModalEl = document.querySelector('#courseSyllabusModal')
            var courseSyllabusModal = bootstrap.Modal.getOrCreateInstance(myCourseSyllabusModalEl)

            courseSyllabusModal.hide();
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) backdrop.remove();
            @this.dispatch('reset-course-syllabus-modal');
        });
        var myCourseSyllabusModalEl = document.getElementById('courseSyllabusModal')
        myCourseSyllabusModalEl.addEventListener('hidden.bs.modal', (event) => {
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) backdrop.remove();
            @this.dispatch('reset-course-syllabus-modal');
        });
    </script>
@endscript
