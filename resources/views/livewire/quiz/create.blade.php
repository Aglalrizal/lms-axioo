<div>
    @if ($courseContent)
        <div class="row">
            <div class="col-12">
                <!-- Card -->
                <div class="card mb-4">
                    <!-- Card body -->
                    <div class="card-body">
                        <!-- quiz -->
                        <div class="d-lg-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <!-- quiz content -->
                                <div class="ms-3">
                                    <h3 class="mb-2"><a href="#"
                                            class="text-inherit">{{ Str::title($quiz->title) }}</a></h3>
                                    <div>
                                        <span>
                                            <span class="align-middle"><i class="fe fe-list"></i></span>
                                            {{ $quiz->number_of_questions }} Pertanyaan
                                        </span>
                                        <span class="ms-2">
                                            <span class="align-middle"><i class="fe fe-clock"></i></span>
                                            {{ $quiz->duration }} Menit
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-none d-lg-block">
                                <button type="button" wire:click='toogleQuizForm' class="btn btn-outline-info"><i
                                        class="bi bi-pencil-square"></i></button>
                                <a class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addQuizQuestionModal">Tambah Pertanyaan</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if ($showForm)
        <div>
            <form wire:submit="saveQuiz">
                <!-- Card -->
                <div class="card mb-3">
                    <div class="card-header border-bottom px-4 py-3">
                        <h4 class="mb-0">Identitas Quiz</h4>
                    </div>
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Judul</label>
                            <input id="title" wire:model="title"
                                class="form-control @error('title') is-invalid @enderror" type="text"
                                autocomplete="off" />
                            @error('title')
                                <small class="d-block mt-2 text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="duration" class="form-label">Durasi <small
                                        class="text-muted text-sm">(menit)</small></label>
                                <input id="duration" wire:model="duration"
                                    class="form-control @error('duration') is-invalid @enderror" type="number"
                                    min="0" />
                                @error('duration')
                                    <small class="d-block mt-2 text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-6 mb-3">
                                <label for="number_of_questions" class="form-label">Jumlah Soal</label>
                                <input id="number_of_questions" wire:model="number_of_questions"
                                    class="form-control @error('number_of_questions') is-invalid @enderror"
                                    type="number" min="0" />
                                @error('number_of_questions')
                                    <small class="d-block mt-2 text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <livewire:jodit-text-editor wire:model="content" />
                            @error('content')
                                <small class="d-block mt-2 text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        @if ($courseContent)
                            <button type="button" wire:click='toogleQuizForm'
                                class="btn btn-outline-dark">Tutup</button>
                        @endif
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    @endif
    @if ($courseContent)
        <div class="card mb-4">
            <div class="card-header">
                <input wire:model.live="search" class="form-control" placeholder="Cari pertanyaan..." />
                <div class="d-flex justify-content-between align-items-center my-3">
                    <div>
                        <select wire:model.live="filterType" class="form-select">
                            <option value="">Filter: Semua Tipe</option>
                            <option value="multiple_choice">Pilihan Ganda</option>
                            <option value="short_answer">Isian Pendek</option>
                        </select>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <select wire:model.live="sortBy" class="form-select">
                            <option value="order">Urutan</option>
                            <option value="created_at">Tanggal Dibuat</option>
                            <option value="question">Pertanyaan (A-Z)</option>
                        </select>

                        <select wire:model.live="sortDirection" class="form-select">
                            <option value="asc">A-Z / Terlama</option>
                            <option value="desc">Z-A / Terbaru</option>
                        </select>
                    </div>
                </div>
            </div>
            @forelse($questions as $question)
                <div class="card-body border-bottom">
                    <h3 class="mb-3">{{ $question->question }}</h3>
                    <!-- list group -->
                    <div class="list-group">
                        @foreach ($question->choices as $choice)
                            <div class="list-group-item list-group-item-action" aria-current="true">
                                <!-- form check -->
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="question_{{ $question->id }}"
                                        id="choice_{{ $choice->id }}" {{ $choice->is_correct ? 'checked' : '' }}
                                        disabled>
                                    <label class="form-check-label"
                                        for="flexRadioDefault5">{{ $choice->answer_option }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- buttons -->
                    <div class="mt-3">
                        <a wire:click="dispatch('edit-question-mode', { id: {{ $question->id }} })"
                            class="btn btn-outline-secondary" data-bs-toggle="modal"
                            data-bs-target="#addQuizQuestionModal">Edit</a>
                        <a wire:click="$dispatch('delete-question', { id:{{ $question->id }} })"
                            class="btn btn-outline-danger ms-2">Delete</a>
                    </div>
                </div>
            @empty
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <h5 class="card-title m-0">Tidak ada soal</h5>
                    </div>
                </div>
            @endforelse
            <div class="card-footer">
                <div class="mt-3">
                    {{ $questions->links() }}
                </div>
            </div>
        </div>
        <livewire:quiz.create-quiz-question :quizId="$quiz->id" />
    @endif
    <div>
        <div class="card-footer">
            <button type="button" wire:click="backToStepThree" class="btn btn-outline-secondary">Kembali ke
                kurikulum</button>
        </div>
    </div>
</div>


@assets
    <link rel="stylesheet" href="//unpkg.com/jodit@4.1.16/es2021/jodit.min.css">
    <script src="//unpkg.com/jodit@4.1.16/es2021/jodit.min.js"></script>
    <style>
        .jodit-wysiwyg pre {
            background-color: #1f2937;
            color: #ffffff;
            padding: 1rem;
            border-radius: 0.5rem;
            max-width: 100%;
            overflow-wrap: break-word;
            white-space: pre-wrap;
            word-break: break-word;
        }

        .jodit-wysiwyg code {
            font-size: 0.875rem;
        }

        .jodit-wysiwyg blockquote {
            border-left: 4px solid #9ca3af;
            padding-left: 1rem;
            font-style: italic;
            color: #4b5563;
        }
    </style>
@endassets

@if (session('succes'))
    <script>
        document.addEventListener('livewire:initialized', () => {
            flasher.success('{{ session('success') }}');
        });
    </script>
@endif

@script
    <script>
        Livewire.on('refresh-questions', () => {
            var myQuizQuestionModalEl = document.querySelector('#addQuizQuestionModal')
            var quizQuestionModal = bootstrap.Modal.getOrCreateInstance(myQuizQuestionModalEl)

            quizQuestionModal.hide();
            @this.dispatch('reset-quiz-question-modal');
        });
        var myQuizQuestionModalEl = document.getElementById('addQuizQuestionModal')
        myQuizQuestionModalEl.addEventListener('hidden.bs.modal', (event) => {
            @this.dispatch('reset-quiz-question-modal');
        });
    </script>
@endscript
