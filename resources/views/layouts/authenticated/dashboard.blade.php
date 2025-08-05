@extends('layouts.base')
@section('container')
    {{-- Navbar --}}
    @include('layouts.public.dashboard-navbar', ['user' => Auth::user()])

    {{-- Sidebar --}}
    @include('layouts.authenticated.sidebar', ['user' => Auth::user()])

    <!-- Page Content -->
    <div class="db-content">
        <div class="container mb-4">

            @hasSection('content')
                @yield('content')
            @else
                {{ $slot ?? '' }}
            @endif

        </div>
    </div>

    <div class="btn-scroll-top">
        <svg class="progress-square svg-content" width="100%" height="100%" viewBox="0 0 40 40">
            <path
                d="M8 1H32C35.866 1 39 4.13401 39 8V32C39 35.866 35.866 39 32 39H8C4.13401 39 1 35.866 1 32V8C1 4.13401 4.13401 1 8 1Z"
                style="transition: stroke-dashoffset 10ms linear; stroke-dasharray: 139.989, 139.989; stroke-dashoffset: 139.989;">
            </path>
        </svg>
    </div>

    <svg id="SvgjsSvg1001" width="2" height="0" xmlns="http://www.w3.org/2000/svg" version="1.1"
        xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev"
        style="overflow: hidden; top: -100%; left: -100%; position: absolute; opacity: 0;">
        <defs id="SvgjsDefs1002"></defs>
        <polyline id="SvgjsPolyline1003" points="0,0"></polyline>
        <path id="SvgjsPath1004" d="M0 0 "></path>
    </svg>

    <scribe-shadow id="crxjs-ext" data-crx="okfkdaglfjjjfefdcppliegebpoegaii"
        style="position: fixed; width: 0px; height: 0px; top: 0px; left: 0px; z-index: 2147483647; overflow: visible; visibility: visible;"></scribe-shadow>
@endsection
