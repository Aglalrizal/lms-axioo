<div class="container py-6">
    <h2>{{ $content->title }}</h2>
    <livewire:quiz.timer :attemptId="$attempt->id"></livewire:quiz.timer>
    @foreach ($questions as $q)
        <div class="card mb-3">
            <div class="card-body">
                <h5>{{ $q->question }}</h5>

                @foreach ($q->choices as $choice)
                    <div class="form-check">
                        <input type="radio" id="choice-{{ $choice->id }}" name="question-{{ $q->id }}"
                            value="{{ $choice->id }}" wire:click="saveAnswer({{ $q->id }}, {{ $choice->id }})"
                            @checked(isset($answers[$q->id]) && $answers[$q->id] == $choice->id)>

                        <label for="choice-{{ $choice->id }}" class="form-check-label">
                            {{ $choice->answer_option }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

    <button wire:click="finishQuiz" class="btn btn-primary">Finish Quiz</button>
</div>
