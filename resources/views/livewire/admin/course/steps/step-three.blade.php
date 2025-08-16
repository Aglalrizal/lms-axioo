<section>
    @if ($isAddArticle)
        <livewire:course.course-contents.article.create-article wire:key="add-article" :syllabus_id="$syllabusId"
            :courseContentId="$courseContentId ?? null" />
    @elseif ($isAddVideo)
        <livewire:course.course-contents.video.create wire:key="add-video" :syllabus_id="$syllabusId" :courseContentId="$courseContentId ?? null" />
    @elseif ($isAddQuiz)
        <livewire:quiz.create wire:key="open-quiz" :courseId="$course->id ?? null" :syllabus_id="$syllabusId ?? null" :courseContentId="$courseContentId ?? null" />
    @elseif ($isAddAssignment)
        <livewire:course.course-contents.assignment.create wire:key="open-assignment" :courseId="$course->id ?? null" :syllabus_id="$syllabusId ?? null"
            :courseContentId="$courseContentId ?? null" />
    @else
        <div wire:key="list-content">
            <!-- Card -->
            <div class="card mb-3">
                <div class="card-header border-bottom px-4 py-3">
                    <h4 class="mb-0">Kurikulum</h4>
                </div>
                <!-- Card body -->
                <div class="card-body">
                    @forelse ($course->syllabus as $s)
                        @php
                            $isLastSyllabus = $s->id === $course->syllabus->last()->id;
                        @endphp
                        <div class="bg-light rounded p-2 mb-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <a class="text-dark text-decoration-none flex-grow-1" data-bs-toggle="collapse"
                                    data-bs-target="#syllabus-{{ $s->id }}" aria-expanded="false"
                                    aria-controls="syllabus-{{ $s->id }}">
                                    <h4 class="mb-0 text-truncate text-wrap">
                                        {{ Str::title($s->title) }}
                                    </h4>
                                </a>
                                <div class="ms-2">
                                    <button wire:click="$dispatch('edit-syllabus-mode',{id:{{ $s->id }}})"
                                        type="button" class="text-inherit btn btn-sm p-1" data-bs-toggle="modal"
                                        data-bs-target="#courseSyllabusModal"><i class="fe fe-edit fs-6"></i></button>
                                    <button wire:click="$dispatch('delete-syllabus',{id: {{ $s->id }}})"
                                        class="btn btn-sm text-danger p-1">
                                        <i class="fe fe-trash-2 fs-6"></i>
                                    </button>
                                    <button class="text-inherit btn btn-sm p-1" data-bs-toggle="collapse"
                                        data-bs-target="#syllabus-{{ $s->id }}" aria-expanded="false"
                                        aria-controls="syllabus-{{ $s->id }}">
                                        <span class="chevron-arrow"><i class="fe fe-chevron-down"></i></span>
                                    </button>
                                </div>
                            </div>
                            <!-- List group -->
                            <div id="syllabus-{{ $s->id }}" class="collapse mt-3">
                                <div class="list-group list-group-flush border-top-0">
                                    @forelse($s->courseContents as $content)
                                        <div class="list-group-item rounded px-3 text-nowrap mb-1">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <h5 class="mb-0 text-truncate">
                                                    <a wire:click="$dispatch('open-add-{{ $content->type }}', { syllabusId: {{ $s->id }}, courseContentId: {{ $content->id }} })"
                                                        class="text-inherit">
                                                        <i class="fe fe-menu me-1 align-middle"></i>
                                                        <span class="align-middle">{{ $content->title }}</span>
                                                    </a>
                                                    @php
                                                        $types = [
                                                            'article' => [
                                                                'label' => 'Artikel',
                                                                'class' => 'bg-primary',
                                                            ],
                                                            'video' => ['label' => 'Video', 'class' => 'bg-danger'],
                                                            'quiz' => [
                                                                'label' => 'Kuis',
                                                                'class' => 'bg-warning text-dark',
                                                            ],
                                                            'assignment' => [
                                                                'label' => 'Tugas',
                                                                'class' => 'bg-success',
                                                            ],
                                                        ];

                                                        $badge = $types[$content->type] ?? [
                                                            'label' => 'Tidak diketahui',
                                                            'class' => 'bg-secondary',
                                                        ];
                                                    @endphp

                                                    <span class="badge {{ $badge['class'] }}">
                                                        {{ $badge['label'] }}
                                                    </span>
                                                </h5>
                                                <div>
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
                                wire:click='$dispatch("open-add-article", {syllabusId: {{ $s->id }} })'>Tambah
                                Artikel</button>
                            <button class="btn btn-outline-primary btn-sm mt-3"
                                wire:click='$dispatch("open-add-video", {syllabusId: {{ $s->id }} })'>Tambah
                                Video Pembelajaran</button>
                            @if (!$s->courseContents->where('type', 'quiz')->count())
                                <button class="btn btn-outline-primary btn-sm mt-3"
                                    wire:click='$dispatch("open-add-quiz", {syllabusId: {{ $s->id }} })'>Tambah
                                    Kuis</button>
                            @endif
                            @if ($s->id === $lastSyllabusId && !$hasAssignment)
                                <button class="btn btn-outline-primary btn-sm mt-3"
                                    wire:click='$dispatch("open-add-assignment", {syllabusId: {{ $s->id }} })'>Tambah
                                    Assignment</button>
                            @endif
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
                @role(['super-admin', 'admin'])
                    <x-course-multi-step-nav :step="$step" :slug="$slug" />
                    @elserole('instructor')
                    <div class="d-flex justify-content-between">
                        <div>
                            <a wire:click="$set('selectedCourse', 'null')" type="button" class="btn btn-secondary">Kembali
                                ke
                                Daftar Kursus</a>
                        </div>
                    </div>
                @endrole
            </div>
        </div>
    @endif
    <livewire:admin.course.syllabus-modal wire:key="syllabusModal" :courseId="$course->id" />
</section>
@script
    <script>
        Livewire.on('refresh-syllabus', () => {
            let el = document.getElementById('courseSyllabusModal');
            let syllabusModal = bootstrap.Modal.getInstance(el) || new bootstrap.Modal(el);

            // Paksa close walau animasi belum selesai
            setTimeout(() => {
                syllabusModal.hide();
            }, 50);

            Livewire.dispatch('reset-syllabus-modal');
        });
        var mySyllabusModalEl = document.getElementById('courseSyllabusModal')
        mySyllabusModalEl.addEventListener('hidden.bs.modal', (event) => {
            document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
            document.body.classList.remove('modal-open');
            document.body.style.overflow = '';
            Livewire.dispatch('reset-syllabus-modal');
        })
    </script>
@endscript
