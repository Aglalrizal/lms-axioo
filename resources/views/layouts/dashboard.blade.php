@extends('layouts.base')
@section('container')
    <div id="db-wrapper">
        <!-- navbar vertical -->
        <!-- Sidebar -->
        @include('layouts.sidebar')
        <!-- Page Content -->
        <main id="page-content">
            @include('layouts.dashboard-header')

            @yield('content')
        </main>
    </div>
@endsection
