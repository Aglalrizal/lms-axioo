<section class="p-lg-5 py-7">
    <div class="container">
        <!-- Content -->
        <div class="row">
            <div class="col-12">
                <!-- Navigation Back to Course -->
                <div class="mb-4">
                    <a href="{{ route('admin.course.published.show', $course->slug) }}" class="btn btn-light">
                        <i class="bi bi-arrow-left me-2"></i>Kembali ke Detail Kursus
                    </a>
                </div>

                <!-- Card -->
                <div class="card mb-5">
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h1 class="fw-semibold pb-3">
                                <small class="text-muted">{{ $selectedQuiz->courseContent->title }}</small>
                            </h1>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-6 col-12 mb-3">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h4 class="text-success mb-1">
                                            {{ $totalQuestions }}
                                        </h4>
                                        <span class="text-muted small">Total Pertanyaan</span>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-md-3 col-sm-6 col-12 mb-3">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h4 class="text-danger mb-1">
                                            {{ $participants->where('total_score', '<', 80)->count() }}
                                        </h4>
                                        <span class="text-muted small">Tidak Lulus (<80%) </span>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-md-4 col-sm-6 col-12 mb-3">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h4 class="text-primary mb-1">
                                            @if ($totalParticipants > 0)
                                                {{ number_format($averageScore, 0) }}%
                                            @else
                                                0%
                                            @endif
                                        </h4>
                                        <span class="text-muted small">Rata-rata Nilai</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-12 mb-3">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h4 class="text-info mb-1">{{ $totalParticipants }}</h4>
                                        <span class="text-muted small">Total Murid</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <ul class="nav nav-lt-tab" id="tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link @if ($activeTab === 'participants') active @endif"
                                wire:click.prevent="setActiveTab('participants')" id="participants-tab"
                                data-bs-toggle="pill" href="#participants" role="tab" aria-controls="participants"
                                aria-selected="true">Peserta</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if ($activeTab === 'questions') active @endif"
                                wire:click.prevent="setActiveTab('questions')" id="questions-tab" data-bs-toggle="pill"
                                href="#questions" role="tab" aria-controls="questions"
                                aria-selected="false">Pertanyaan</a>
                        </li>
                    </ul>
                </div>
                <!-- Card -->
                <div class="card rounded-3">
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="tab-content" id="tabContent">
                            <!-- Peserta Tab -->
                            <div class="tab-pane fade @if ($activeTab === 'participants') show active @endif"
                                id="participants" role="tabpanel" aria-labelledby="participants-tab">
                                <div class="row mb-5">
                                    <div class="col-12">
                                        <div>
                                            <h1 class="h2 mb-0">
                                                Peserta
                                            </h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-5">
                                    <div class="col-md-6 col-12">
                                        <input type="search" class="form-control" placeholder="Cari berdasarkan nama"
                                            wire:model.debounce.300ms="search" />
                                    </div>
                                </div>

                                <div class="card">
                                    <!-- Table -->
                                    <div class="table-responsive">
                                        <table class="table table-hover table-centered">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Nama</th>
                                                    <th>Nilai</th>
                                                    <th>Poin</th>
                                                    {{-- <th>Performa</th> --}}
                                                    <th>Waktu Selesai</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($participants as $participant)
                                                    @php
                                                        $correctAnswers = $participant->answers
                                                            ->where('is_correct', true)
                                                            ->count();
                                                        $percent =
                                                            $totalQuestions > 0
                                                                ? ($participant->total_score / $totalQuestions) * 100
                                                                : 0;
                                                    @endphp
                                                    <tr role="button"
                                                        wire:click="openParticipant({{ $participant->id }})">
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar avatar-xs me-2">
                                                                    <img src="{{ $participant->user->avatar_url }}"
                                                                        alt="{{ $participant->user->first_name }}"
                                                                        class="rounded-circle">
                                                                </div>
                                                                <div>
                                                                    <h6 class="mb-0">
                                                                        {{ $participant->user->first_name . ' ' . $participant->user->surname }}
                                                                    </h6>
                                                                    <small
                                                                        class="text-muted">{{ '@' . $participant->user->username }}</small>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="badge  bg-primary-soft">
                                                                {{ number_format($percent, 0) }}%
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="fw-bold">{{ $correctAnswers }}/{{ $totalQuestions }}</span>
                                                        </td>
                                                        {{-- <td>
                                                                <div class="progress mb-1" style="height: 8px;">
                                                                    <div class="progress-bar 
                                                                        @if ($participant->total_score >= 90) bg-success
                                                                        @elseif($participant->total_score >= 80) bg-warning  
                                                                        @else bg-danger @endif"
                                                                        role="progressbar"
                                                                        style="width: {{ $participant->total_score }}%"
                                                                        aria-valuenow="{{ $participant->total_score }}"
                                                                        aria-valuemin="0" aria-valuemax="100">
                                                                    </div>
                                                                </div>
                                                                <small
                                                                    class="text-muted">{{ number_format($participant->total_score, 1) }}%</small>
                                                            </td> --}}
                                                        <td>
                                                            <span class="text-muted">
                                                                {{ $participant->end_time ? $participant->end_time->format('d M Y H:i') : '-' }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="6" class="text-center">
                                                            <i class="bi bi-exclamation-triangle"></i>
                                                            @if ($this->search)
                                                                Tidak ada peserta yang sesuai dengan pencarian
                                                            @else
                                                                Belum ada peserta yang menyelesaikan quiz ini
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                    @if ($participants->hasPages())
                                        <div class="p-3">
                                            {{ $participants->links() }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Pertanyaan Tab -->
                            <div class="tab-pane fade @if ($activeTab === 'questions') show active @endif"
                                id="questions" role="tabpanel" aria-labelledby="questions-tab">
                                <div class="row mb-5">
                                    <div class="col-12">
                                        <div>
                                            <h1 class="h2 mb-0">
                                                Pertanyaan
                                            </h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-5">
                                    <div class="col-md-6 col-12">
                                        <input type="search" class="form-control" placeholder="Cari pertanyaan..."
                                            wire:model.debounce.300ms="search" />
                                    </div>
                                </div>

                                <!-- Questions Detail -->
                                @php
                                    $searchTerm = $this->search ?? '';
                                    $filteredQuestions = $selectedQuiz->questions->filter(function ($question) use (
                                        $searchTerm,
                                    ) {
                                        return empty($searchTerm) ||
                                            str_contains(strtolower($question->question), strtolower($searchTerm));
                                    });
                                @endphp
                                @foreach ($filteredQuestions as $index => $question)
                                    @php
                                        // Pre-compute answers and quick stats for header usage (only for multiple choice)
                                        $questionAnswers = collect();
                                        $totalAnswers = 0;
                                        $correctCount = 0;
                                        $wrongCount = 0;

                                        if ($question->question_type === 'multiple_choice') {
                                            foreach ($participants as $participant) {
                                                $answer = $participant->answers
                                                    ->where('quiz_question_id', $question->id)
                                                    ->first();
                                                if ($answer) {
                                                    $questionAnswers->push($answer);
                                                }
                                            }
                                            $totalAnswers = $questionAnswers->count();
                                            $correctCount = $questionAnswers->where('is_correct', true)->count();
                                            $wrongCount = $totalAnswers - $correctCount;
                                        }
                                    @endphp
                                    <div class="card mb-4">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <span
                                                class="badge bg-primary me-2">{{ $question->question_type === 'multiple_choice' ? 'Pilihan ganda' : ucfirst(str_replace('_', ' ', $question->question_type)) }}
                                            </span>
                                            @if ($question->question_type === 'multiple_choice')
                                                <div class="d-flex align-items-center small text-muted">
                                                    <span class="badge bg-success-soft text-success me-2">Benar
                                                        {{ $correctCount }}</span>
                                                    <span class="badge bg-danger-soft text-danger me-2">Salah
                                                        {{ $wrongCount }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title mb-4">
                                                <strong>{{ $index + 1 }}. {!! $question->question !!}</strong>
                                            </h5>

                                            @if ($question->question_type === 'multiple_choice' && $question->choices->count() > 0)
                                                <div class="row">
                                                    <div class="col-12 d-flex flex-column gap-3">
                                                        @foreach ($question->choices as $optionIndex => $choice)
                                                            @php
                                                                $optionLetter =
                                                                    ['A', 'B', 'C', 'D'][$optionIndex] ?? '';
                                                                if (empty($optionLetter)) {
                                                                    continue;
                                                                }

                                                                // Count how many students chose this specific choice ID
                                                                $choiceCount = $questionAnswers
                                                                    ->where('answer', $choice->id)
                                                                    ->count();

                                                                $percentage =
                                                                    $totalAnswers > 0
                                                                        ? ($choiceCount / $totalAnswers) * 100
                                                                        : 0;
                                                                $isCorrect = $choice->is_correct;
                                                            @endphp

                                                            <div class="row align-items-center">
                                                                <div class="col-md-8">
                                                                    <div class="d-flex align-items-center">
                                                                        <span
                                                                            class="me-3 fw-bold">{{ $optionLetter }}</span>
                                                                        <span>{{ $choice->answer_option }}</span>
                                                                        @if ($isCorrect)
                                                                            <i
                                                                                class="bi bi-check-circle-fill text-success ms-2"></i>
                                                                        @else
                                                                            <i
                                                                                class="bi bi-x-circle-fill text-danger ms-2"></i>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div
                                                                        class="d-flex align-items-center justify-content-end">
                                                                        <div class="me-3" style="min-width: 120px;">
                                                                            <div class="progress"
                                                                                style="height: 20px;">
                                                                                <div class="progress-bar {{ $isCorrect ? 'bg-success' : 'bg-danger' }}"
                                                                                    role="progressbar"
                                                                                    style="width: {{ $percentage }}%"
                                                                                    aria-valuenow="{{ $percentage }}"
                                                                                    aria-valuemin="0"
                                                                                    aria-valuemax="100">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="text-end"
                                                                            style="min-width: 80px;">
                                                                            <div class="fw-bold">
                                                                                {{ $choiceCount }} students</div>
                                                                            <small
                                                                                class="text-muted">{{ number_format($percentage, 0) }}%</small>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @else
                                                <p class="text-muted">Tipe pertanyaan ini tidak mendukung analisis
                                                    pilihan jawaban.</p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach

                                @if ($filteredQuestions->count() === 0)
                                    <div class="card">
                                        <div class="card-body text-center py-5">
                                            <i class="bi bi-search text-muted mb-3" style="font-size: 3rem;"></i>
                                            <h5 class="text-muted">Tidak Ada Pertanyaan</h5>
                                            <p class="text-muted">
                                                @if ($searchTerm)
                                                    Tidak ada pertanyaan yang sesuai dengan pencarian
                                                    "{{ $searchTerm }}"
                                                @else
                                                    Belum ada pertanyaan untuk quiz ini
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @livewire('course.published.quiz-attempt-report-modal')
</section>
