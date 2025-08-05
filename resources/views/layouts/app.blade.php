@extends('layouts.base')

@section('container')
    {{-- navbar --}}
    {{--    @if (Request::is('help-center')) --}}
    {{--        @include('layouts.navigation-help-center') --}}
    {{--    @elseif (Request::is('help-center/*') || Request::is('help-center/*/*')) --}}
    {{--        @include('layouts.navigation-help-center-2') --}}
    {{--    @else --}}
    {{--        --}}{{-- Default navigation --}}
    {{--        @include('layouts.navigation') --}}
    {{--    @endif --}}

    @include('layouts.navigation')
    <x-modal></x-modal>

    {{-- content --}}
    @hasSection('content')
        @yield('content')
    @else
        {{ $slot ?? '' }}
    @endif

    {{-- footer --}}
    @include('layouts.footer')

    <!-- Scroll top -->
    <div class="btn-scroll-top">
        <svg class="progress-square svg-content" width="100%" height="100%" viewBox="0 0 40 40">
            <path
                d="M8 1H32C35.866 1 39 4.13401 39 8V32C39 35.866 35.866 39 32 39H8C4.13401 39 1 35.866 1 32V8C1 4.13401 4.13401 1 8 1Z" />
        </svg>
    </div>
@endsection
