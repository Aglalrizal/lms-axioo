<div>
    <!-- Modal -->
    <div class="modal fade" id="quizAttemptModal" tabindex="-1" aria-labelledby="quizAttemptModalLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="quizAttemptModalLabel">Detail Hasil Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if ($attempt)
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-md me-3">
                                    <img class="rounded-circle"
                                        src="{{ $attempt['user']['avatar_url'] ?? 'https://ui-avatars.com/api/?background=random&name=' . urlencode(($attempt['user']['first_name'] ?? '') . ' ' . ($attempt['user']['surname'] ?? '')) }}"
                                        alt="avatar">
                                </div>
                                <div>
                                    <h5 class="mb-0">
                                        {{ ($attempt['user']['first_name'] ?? '') . ' ' . ($attempt['user']['surname'] ?? '') }}
                                    </h5>
                                    <small class="text-muted">{{ $attempt['user']['username'] ?? '' }}</small>
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="h4 mb-0">{{ $attempt['percentage'] }}%</div>
                                <small class="text-muted">Skor:
                                    {{ $attempt['correct'] }}/{{ $attempt['total_questions'] }}</small>
                                <div class="text-muted">Selesai: {{ $attempt['end_time'] ?? '-' }}</div>
                            </div>
                        </div>

                        <hr>

                        <div class="d-flex flex-column gap-4">
                            @forelse ($attempt['answers'] as $index => $answer)
                                @php
                                    $leftBorder = $answer['is_correct'] ? '#198754' : '#dc3545'; // success / danger
                                @endphp
                                <div class="card shadow-sm" style="border-left: 6px solid {{ $leftBorder }};">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <div class="small text-muted">
                                                {{ $answer['type'] === 'multiple_choice' ? 'Pilihan ganda' : ucfirst(str_replace('_', ' ', $answer['type'])) }}
                                            </div>
                                            <div class="d-flex align-items-center">
                                                @if ($answer['is_correct'])
                                                    <span class="text-success fw-semibold">
                                                        <i class="bi bi-check-circle-fill me-1"></i>Benar
                                                    </span>
                                                @else
                                                    <span class="text-danger fw-semibold">
                                                        <i class="bi bi-x-circle-fill me-1"></i> Salah
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <p class="mb-3 fw-bold">{{ $index + 1 . '. ' }}{!! $answer['question'] !!}</p>

                                        @if ($answer['type'] === 'multiple_choice')
                                            <div class="list-group">
                                                @foreach ($answer['choices'] as $choice)
                                                    @php
                                                        $isCorrect = $choice['is_correct'];
                                                        $isSelected = $choice['is_selected'];
                                                        $itemClasses =
                                                            'list-group-item d-flex justify-content-between align-items-start';
                                                        if ($isCorrect && $isSelected) {
                                                            $itemClasses .=
                                                                ' border border-success bg-success-soft text-success';
                                                        } elseif ($isCorrect) {
                                                            $itemClasses .= ' bg-success-soft text-success';
                                                        } elseif ($isSelected) {
                                                            $itemClasses .=
                                                                ' border border-danger bg-danger-soft text-danger';
                                                        }
                                                    @endphp
                                                    <div class="{{ $itemClasses }}">
                                                        <div class="pe-3">{!! $choice['text'] !!}</div>
                                                        <div class="text-nowrap">
                                                            @if ($isSelected && $isCorrect)
                                                                <span class="badge bg-success text-white"><i
                                                                        class="bi bi-check2 me-1"></i>Dipilih</span>
                                                            @elseif ($isSelected && !$isCorrect)
                                                                <span class="badge bg-danger text-white"><i
                                                                        class="bi bi-x-lg me-1"></i>Dipilih</span>
                                                            @elseif ($isCorrect)
                                                                <span class="badge bg-success-soft text-success"><i
                                                                        class="bi bi-check2 me-1"></i>Benar</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-muted">Tipe pertanyaan ini tidak mendukung detail pilihan.
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted">Tidak ada jawaban untuk ditampilkan.</p>
                            @endforelse
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-3 text-muted">Memuat data percobaan...</p>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bridge between Livewire event and Bootstrap modal -->
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('show-quiz-attempt-modal', () => {
                const el = document.getElementById('quizAttemptModal');
                if (!el) return;
                const modal = bootstrap.Modal.getOrCreateInstance(el);
                modal.show();
            });
        });
    </script>
</div>
