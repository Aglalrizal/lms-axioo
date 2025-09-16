<div wire:ignore.self class="modal fade" id="fullscreenModal" tabindex="-1" aria-labelledby="fullscreenModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fullscreenModalLabel">
                    {{ $quizAttempt ? $quizAttempt->quiz->courseContent->title : '' }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body row">
                <!-- Kiri: Skor -->
                <div class="col-md-3 text-center border-end">
                    <h2>Persentase</h2>
                    @if ($quizAttempt)
                        @php
                            $totalQuestions = $quizAttempt->quiz->questions->count();
                            $percent =
                                $totalQuestions > 0 ? round(($quizAttempt->total_score / $totalQuestions) * 100) : 0;
                        @endphp

                        <p class="display-4 fw-bold {{ $percent >= 75 ? 'text-success' : 'text-danger' }}">
                            {{ $percent }}%
                        </p>
                        <p>{{ $quizAttempt->total_score }} / {{ $totalQuestions }} soal</p>
                    @endif
                </div>

                <!-- Kanan: Soal -->
                <div class="col-md-8" style="max-height: 80vh; overflow-y: auto;">
                    @if ($quizAttempt)
                        @foreach ($quizAttempt->quiz->questions as $index => $question)
                            <div class="mb-4">
                                <h5>{{ $index + 1 }}. {{ $question->text }}</h5>
                                <ul class="list-group mt-2">
                                    @foreach ($question->choices as $choice)
                                        @php
                                            // jawaban student untuk pertanyaan ini
                                            $answer = $quizAttempt->answers->firstWhere(
                                                'quiz_question_id',
                                                $question->id,
                                            );

                                            $isSelected = $answer && $answer->quiz_choice_id == $choice->id;
                                            $isCorrect = $choice->is_correct;
                                        @endphp

                                        <li
                                            class="list-group-item 
                            @if ($isSelected && $isCorrect) list-group-item-success 
                            @elseif($isSelected && !$isCorrect) list-group-item-danger @endif">
                                            {{ $choice->text }}
                                            @if ($isCorrect)
                                                <span class="badge bg-success float-end">Correct</span>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
