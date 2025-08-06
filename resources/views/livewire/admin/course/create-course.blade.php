<section class="p-4">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <!-- Page Header -->
                <div
                    class="border-bottom pb-3 mb-3 d-flex flex-column flex-md-row gap-3 align-items-md-center justify-content-between">
                    <div class="d-flex flex-column gap-1">
                        <h1 class="mb-0 h2 fw-bold">{{ $slug ? 'Edit Kursus' : 'Buat Kursus' }}</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="bs-stepper">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12">
                    @if ($slug)
                        <!-- Stepper Button -->
                        <div class="bs-stepper-header shadow-sm">
                            <div class="step {{ $step == 1 ? 'active' : '' }}">
                                <a wire:navigate wire:click="$set('step', 1)" class="step-trigger">
                                    <span class="bs-stepper-circle">1</span>
                                    <span class="bs-stepper-label">Informasi Dasar</span>
                                </a>
                            </div>
                            <div class="bs-stepper-line"></div>
                            <div class="step {{ $step == 2 ? 'active' : '' }}">
                                <a wire:navigate wire:click="$set('step', 2)" class="step-trigger">
                                    <span class="bs-stepper-circle">2</span>
                                    <span class="bs-stepper-label">Kursus Media</span>
                                </a>
                            </div>
                            <div class="bs-stepper-line"></div>
                            <div class="step {{ $step == 3 ? 'active' : '' }}">
                                <a wire:navigate wire:click="$set('step', 3)" class="step-trigger">
                                    <span class="bs-stepper-circle">3</span>
                                    <span class="bs-stepper-label">Kurikulum</span>
                                </a>
                            </div>
                            <div class="bs-stepper-line"></div>
                            <div class="step {{ $step == 4 ? 'active' : '' }}">
                                <a wire:navigate wire:click="$set('step', 4)" class="step-trigger">
                                    <span class="bs-stepper-circle">4</span>
                                    <span class="bs-stepper-label">Lain-Lain</span>
                                </a>
                            </div>
                        </div>
                    @endif
                    <!-- Stepper content -->
                    <div class="bs-stepper-content mt-5">
                        @if ($step === 1)
                            <livewire:admin.course.steps.step-one wire:navigate :slug="$slug" />
                        @elseif ($step === 2)
                            <livewire:admin.course.steps.step-two wire:navigate :slug="$slug" />
                        @elseif ($step === 3)
                            <livewire:admin.course.steps.step-three wire:navigate :slug="$slug" />
                        @elseif ($step === 4)
                            <livewire:admin.course.steps.step-four wire:navigate :slug="$slug" />
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/libs/glightbox/dist/css/glightbox.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/libs/bs-stepper/dist/css/bs-stepper.min.css') }}" />
@endsection

@assets
    <script src="{{ asset('assets/libs/dragula/dist/dragula.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/customDragula.js') }}"></script>
    <script src="{{ asset('assets/libs/glightbox/dist/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/glight.js') }}"></script>
@endassets

{{-- @script
    <script>
        document.getElementById('save-button').addEventListener('click', function() {
            let description = quill.root.innerHTML;
            @this.set('description', description);

            const instructor = $('#select-instructor').val();
            const category = $('#select-category').val();
            @this.set('selectedCategory', category);
            @this.set('selectedInstructor', instructor);
        });
    </script>
@endscript --}}
