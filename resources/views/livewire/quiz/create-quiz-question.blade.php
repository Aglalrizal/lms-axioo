<div wire:ignore.self class="modal fade" id="addQuizQuestionModal" tabindex="-1"
    aria-labelledby="addQuizQuestionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- modal body -->
            <div class="modal-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="modal-title" id="addQuizQuestionModalLabel">{{ $formtitle }}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div>
                    <!-- form -->
                    <form wire:submit="{{ $editform ? 'update' : 'saveQuestion' }}">
                        {{-- Pertanyaan --}}
                        <div class="mb-3">
                            <label for="question" class="form-label">Pertanyaan</label>
                            <textarea id="question" class="form-control @error('question') is-invalid @enderror" wire:model.defer="questionText"
                                rows="3"></textarea>
                            @error('question')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tipe Pertanyaan --}}
                        {{-- <div class="mb-3">
                            <label for="question_type" class="form-label">Tipe Pertanyaan</label>
                            <select id="question_type"
                                class="form-select text-dark @error('question_type') is-invalid @enderror"
                                wire:model.live="question_type" required>
                                <option value="">-- Pilih tipe pertanyaan --</option>
                                <option value="multiple_choice">Pilihan Ganda</option>
                                <option value="short_answer">Isian Singkat</option>
                            </select>
                            @error('question_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div> --}}

                        {{-- Pilihan Ganda --}}
                        @if ($question_type === 'multiple_choice')
                            <div class="mb-3">
                                <label class="form-label">Pilihan Jawaban</label>
                                @foreach ($choices as $index => $choice)
                                    <div class="mb-2">
                                        <div class="mb-2 d-flex justify-content-between align-items-center">
                                            <div>
                                                <h5 class="mb-0 fw-normal">Opsi {{ $loop->iteration }}</h5>
                                            </div>
                                            <div>
                                                <div class="d-flex align-items-center lh-1">
                                                    <span>Jawaban Benar</span>
                                                    <div class="form-check form-switch ms-2">
                                                        <input class="form-check-input me-2" type="radio"
                                                            role="switch" required="" wire:model="correctIndex"
                                                            value="{{ $index }}"
                                                            id="correct_{{ $index }}">
                                                        <label class="form-check-label"
                                                            for="correct_{{ $index }}"></label>
                                                    </div>
                                                    <a wire:click="removeChoice({{ $index }})"
                                                        data-bs-toggle="tooltip" data-placement="top" title="Hapus">
                                                        <i class="bi bi-trash text-danger fs-5"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="text" placeholder="Pilihan Jawaban" class="form-control"
                                            id="correctAnswer" wire:model="choices.{{ $index }}.text"
                                            required="">
                                    </div>
                                @endforeach

                                <button type="button" wire:click="addChoice"
                                    class="btn btn-outline-primary btn-sm mt-2">
                                    + Tambah Opsi
                                </button>
                            </div>
                        @endif

                        {{-- Isian Singkat --}}
                        @if ($question_type === 'short_answer')
                            <div>
                            </div>
                        @endif

                        {{-- Submit --}}
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Simpan Pertanyaan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
