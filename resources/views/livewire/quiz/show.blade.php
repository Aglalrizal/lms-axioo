<div class="container min-vh-100">
    <div class="row py-4">
        <div class="col-12">
            <div class="d-flex flex-row align-items-center justify-content-between mb-4">
                <h2 class="mb-0">{{ $content->title }}</h2>

                <a wire:click="finishQuiz" class="btn btn-primary">Akhiri Kuis</a>
            </div>
            <div id="courseForm" class="bs-stepper">
                <div class="bs-stepper-content">
                    <div role="tablist">
                        @foreach ($questions as $q)
                            <div class="step" data-target="#test-l-{{ $loop->iteration }}">
                                <div class="step-trigger visually-hidden" role="tab"
                                    id="courseFormtrigger{{ $loop->iteration }}"
                                    aria-controls="test-l-{{ $loop->iteration }}"></div>
                            </div>
                        @endforeach
                    </div>
                    <form onSubmit="return false" wire:ignore>
                        <!-- Content one -->
                        @foreach ($questions as $index => $question)
                            <div id="test-l-{{ $index + 1 }}" role="tabpanel" class="bs-stepper-pane fade">
                                <div class="card">
                                    <div class="card-body d-flex flex-column gap-5">
                                        <div class="d-flex align-content-center justify-content-between">
                                            <div class="d-flex flex-column gap-1">
                                                <span class="fw-semibold text-secondary">Pertanyaan
                                                    {{ $index + 1 }}</span>
                                                <h3 class="mb-0">{{ $question->question }}</h3>
                                            </div>
                                            <div>
                                                <livewire:quiz.timer :attemptId="$attempt->id" />
                                            </div>
                                        </div>
                                        <div class="list-group">
                                            @foreach ($question->choices as $choiceIndex => $choice)
                                                <div class="list-group-item list-group-item-action">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="question_{{ $question->id }}"
                                                            id="q{{ $question->id }}_opt{{ $choiceIndex }}"
                                                            value="{{ $choice->id }}"
                                                            wire:click="saveAnswer({{ $q->id }}, {{ $choice->id }})"
                                                            @checked(isset($answers[$q->id]) && $answers[$q->id] == $choice->id)>
                                                        <label class="form-check-label stretched-link"
                                                            for="q{{ $question->id }}_opt{{ $choiceIndex }}">
                                                            {{ $choice->answer_option }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="d-flex justify-content-between">
                                            @if ($index > 0)
                                                <button class="btn btn-secondary" onclick="courseForm.previous()">
                                                    <i class="fe fe-arrow-left"></i> Previous
                                                </button>
                                            @endif

                                            @if ($index < count($questions) - 1)
                                                <button class="btn btn-primary" onclick="courseForm.next()">
                                                    Next <i class="fe fe-arrow-right"></i>
                                                </button>
                                            @else
                                                <button wire:click="finishQuiz" class="btn btn-primary">Finish</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@assets
    <link rel="stylesheet" href="{{ asset('assets/libs/bs-stepper/dist/css/bs-stepper.min.css') }}" />
@endassets
@section('scripts')
    <script src="{{ asset('assets/libs/bs-stepper/dist/js/bs-stepper.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/beStepper.js') }}"></script>
@endsection
