@extends('layouts.dashboard');
@section('content')
    <section class="py-8">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12">
                    <!-- Page Header -->
                    <div
                        class="border-bottom pb-3 mb-3 d-flex flex-column flex-md-row gap-3 align-items-md-center justify-content-between">
                        <div class="d-flex flex-column gap-1">
                            <h1 class="mb-0 h2 fw-bold">Create Course</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bs-stepper">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                        <!-- Stepper Button -->
                        <x-stepper></x-stepper>
                        <!-- Stepper content -->
                        <div class="bs-stepper-content mt-5">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/libs/glightbox/dist/css/glightbox.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/libs/bs-stepper/dist/css/bs-stepper.min.css') }}" />
@endsection

@assets
    <script src="{{ asset('assets/libs/quill/dist/quill.js') }}"></script>
    <script src="{{ asset('assets/libs/dragula/dist/dragula.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/customDragula.js') }}"></script>
    <script src="{{ asset('assets/libs/glightbox/dist/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/glight.js') }}"></script>
    <script src="{{ asset('assets/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/choice.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
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
