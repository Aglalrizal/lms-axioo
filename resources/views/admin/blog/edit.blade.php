@extends('layouts.dashboard')
@section('styles')
    <link rel="stylesheet" href={{ asset('assets/libs/flatpickr/dist/flatpickr.min.css') }} />
    <link rel="stylesheet" href={{ asset('assets/libs/quill/dist/quill.snow.css') }} />
    <link rel="stylesheet" href={{ asset('assets/libs/dropzone/dist/dropzone.css') }} />
@endsection

@section('content')
    <livewire:blog-edit :$blog />
@endsection

@section('scripts')
    <script src={{ asset('assets/libs/dropzone/dist/min/dropzone.min.js') }}></script>
    <script src={{ asset('assets/libs/flatpickr/dist/flatpickr.min.js') }}></script>
    <script src={{ asset('assets/js/vendors/flatpickr.js') }}></script>
    <script src={{ asset('assets/libs/quill/dist/quill.js') }}></script>
    <script src={{ asset('assets/js/vendors/editor.js') }}></script>
    <script src={{ asset('assets/js/vendors/validation.js') }}></script>
    <script src={{ asset('assets/js/vendors/dropzone.js') }}></script>
    <script src={{ asset('assets/libs/choices.js/public/assets/scripts/choices.min.js') }}></script>

    <script src={{ asset('assets/js/vendors/choice.js') }}></script>
@endsection
