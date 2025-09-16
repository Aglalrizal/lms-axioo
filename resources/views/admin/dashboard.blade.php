@extends('layouts.dashboard')
@section('content')
    <section class="container-fluid p-4">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div
                    class="border-bottom pb-3 mb-3 d-flex flex-column flex-lg-row gap-3 justify-content-between align-items-lg-center">
                    <div>
                        <h1 class="mb-0 h2 fw-bold">Dashboard</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="row gy-4 mb-4">
            <div class="col-xl-3 col-lg-6 col-md-12 col-12">
                <!-- Card -->
                <div class="card">
                    <!-- Card body -->
                    <div class="card-body d-flex flex-column gap-3">
                        <div class="d-flex align-items-center justify-content-between lh-1">
                            <div>
                                <span class="fs-6 text-uppercase fw-semibold ls-md">Revenue</span>
                            </div>
                            <div>
                                <span class="fe fe-shopping-bag fs-3 text-primary"></span>
                            </div>
                        </div>
                        <div class="d-flex flex-column gap-1">
                            <h2 class="fw-bold mb-0">Rp {{ number_format($thisMonth, 0, ',', '.') }}</h2>
                            <div class="d-flex flex-row gap-2">
                                <span class="{{ $revenueGrowth >= 0 ? 'text-success' : 'text-danger' }}">
                                    {{ number_format($revenueGrowth, 1) }}%
                                    {{-- {{ $growth >= 0 ? 'naik 📈' : 'turun 📉' }} dari bulan lalu --}}
                                    @if ($revenueGrowth >= 0)
                                        <i class="fe fe-trending-up me-1"></i>
                                    @else
                                        <i class="fe fe-trending-down me-1"></i>
                                    @endif
                                    dari bulan lalu
                                </span>
                                {{-- <span class="text-success fw-semibold">
                                    <i class="fe fe-trending-up me-1"></i>
                                    +20.9$
                                </span> --}}

                                {{-- <span class="fw-medium">Number of sales</span> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-12 col-12">
                <!-- Card -->
                <div class="card">
                    <!-- Card body -->
                    <div class="card-body d-flex flex-column gap-3">
                        <div class="d-flex align-items-center justify-content-between lh-1">
                            <div>
                                <span class="fs-6 text-uppercase fw-semibold ls-md">Kursus Aktif</span>
                            </div>
                            <div>
                                <span class="fe fe-book-open fs-3 text-primary"></span>
                            </div>
                        </div>
                        <div class="d-flex flex-column gap-1">
                            <h2 class="fw-bold mb-0">{{ number_format($publishedCourses, 0, ',', '.') }}</h2>
                            <div class="d-flex flex-row gap-2">
                                <span class="fw-medium">Seluruh Kursus</span>
                                <span class="text-primary fw-semibold">{{ number_format($allCourses, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-12 col-12">
                <!-- Card -->
                <div class="card">
                    <!-- Card body -->
                    <div class="card-body d-flex flex-column gap-3">
                        <div class="d-flex align-items-center justify-content-between lh-1">
                            <div>
                                <span class="fs-6 text-uppercase fw-semibold ls-md">Siswa</span>
                            </div>
                            <div>
                                <span class="fe fe-users fs-3 text-primary"></span>
                            </div>
                        </div>
                        <div class="d-flex flex-column gap-1">
                            <h2 class="fw-bold mb-0">{{ number_format($allStudents, 0, ',', '.') }}</h2>
                            <div class="d-flex flex-row gap-2">
                                <span class="text-success fw-semibold">
                                    <i class="fe fe-trending-up me-1"></i>
                                    +{{ $studentGrowth }}
                                </span>
                                <span class="fw-medium">Siswa Baru</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-12 col-12">
                <!-- Card -->
                <div class="card">
                    <!-- Card body -->
                    <div class="card-body d-flex flex-column gap-3">
                        <div class="d-flex align-items-center justify-content-between lh-1">
                            <div>
                                <span class="fs-6 text-uppercase fw-semibold ls-md">Instruktur</span>
                            </div>
                            <div>
                                <span class="fe fe-user-check fs-3 text-primary"></span>
                            </div>
                        </div>
                        <div class="d-flex flex-column gap-1">
                            <h2 class="fw-bold mb-0">{{ number_format($allInstructors, 0, ',', '.') }}</h2>
                            <div class="d-flex flex-row gap-1">
                                <span class="text-success fw-semibold">
                                    <i class="fe fe-trending-up me-1"></i>
                                    +{{ $instructorGrowth }}
                                </span>
                                <span class="ms-1 fw-medium">Instruktrur Baru</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row gy-4 mb-4">
            <div class="col-xl-8 col-lg-12 col-md-12 col-12">
                <!-- Card -->
                <div class="card">
                    <!-- Card header -->
                    <div
                        class="card-header align-items-center card-header-height d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">Revenue Bulanan</h4>
                        </div>
                        <div>
                            <div class="dropdown dropstart">
                                <a class="btn-icon btn btn-ghost btn-sm rounded-circle" href="#" role="button"
                                    id="courseDropdown1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fe fe-more-vertical"></i>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="courseDropdown1">
                                    <span class="dropdown-header">Settings</span>
                                    <a class="dropdown-item" href="#">
                                        <i class="fe fe-external-link dropdown-item-icon"></i>
                                        Export
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        <i class="fe fe-mail dropdown-item-icon"></i>
                                        Email Report
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        <i class="fe fe-download dropdown-item-icon"></i>
                                        Download
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Card body -->
                    <div class="card-body">
                        <!-- Earning chart -->
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-12 col-md-12 col-12">
                <!-- Card -->
                <div class="card">
                    <!-- Card header -->
                    <div
                        class="card-header align-items-center card-header-height d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">Tingkat Penyelesaian</h4>
                        </div>
                        <div>
                            <div class="dropdown dropstart">
                                <a class="btn-icon btn btn-ghost btn-sm rounded-circle" href="#" role="button"
                                    id="courseDropdown2" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fe fe-more-vertical"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- Card body -->
                    <div class="card-body">
                        <canvas id="completionChart" class="d-flex justify-content-center"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row gy-4">
            <div class="col-xl-4 col-lg-12 col-md-12 col-12">
                <!-- Card -->
                <div class="card h-100">
                    <!-- Card header -->
                    <div class="card-header d-flex align-items-center justify-content-between card-header-height">
                        <h4 class="mb-0">Instruktur Populer</h4>
                    </div>
                    <!-- Card body -->
                    <div class="card-body">
                        <!-- List group -->
                        <ul class="list-group list-group-flush">
                            @forelse ($popularInstructors as $i)
                                <li class="list-group-item px-0 pt-2">
                                    <div class="row">
                                        <div class="col-auto">
                                            <div class="avatar avatar-md">
                                                <img alt="{{ $i->username }}-avatar"
                                                    src="{{ optional($i)->profile_picture
                                                        ? asset('storage/' . $i->profile_picture)
                                                        : 'https://ui-avatars.com/api/?background=random&name=' . urlencode(optional($i)->full_name) }}"
                                                    class="rounded-circle" />
                                            </div>
                                        </div>
                                        <div class="col ms-n3">
                                            <h4 class="mb-0 h5">{{ $i->full_name }}</h4>
                                            <span class="me-2 fs-6">
                                                <span class="text-dark me-1 fw-semibold">{{ $i->courses_count }}</span>
                                                Kursus
                                            </span>
                                            <span class="me-2 fs-6">
                                                <span
                                                    class="text-dark me-1 fw-semibold">{{ number_format($i->total_students, 0, ',', '.') }}</span>
                                                Siswa
                                            </span>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li>Belum Ada Data Instruktrur</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-12 col-md-12 col-12">
                <!-- Card -->
                <div class="card h-100">
                    <!-- Card header -->
                    <div class="card-header d-flex align-items-center justify-content-between card-header-height">
                        <h4 class="mb-0">Kursus Terbaru</h4>
                    </div>
                    <!-- Card body -->
                    <div class="card-body">
                        <!-- List group flush -->
                        <ul class="list-group list-group-flush">
                            @forelse ($latestCourses as $course)
                                <li class="list-group-item px-0 pt-2">
                                    <div class="row flex-column flex-md-row gap-3 gap-md-0">
                                        <!-- Col -->
                                        <div class="col-md-3 col-12">
                                            <img src="{{ asset($course->thumbnail) }}" alt="{{ $course->slug }}-image"
                                                class="img-fluid rounded" />
                                        </div>
                                        <!-- Col -->
                                        <div class="col-md-8 col-10">
                                            <div class="d-flex flex-column gap-2">
                                                <h5 class="text-primary-hover mb-0 text-truncate">{{ $course->title }}
                                                </h5>
                                                <div class="d-flex align-items-center gap-2">
                                                    <img alt="{{ $course->teacher->username }}-avatar"
                                                        src="{{ optional($course->teacher)->profile_picture
                                                            ? asset('storage/' . $course->teacher->profile_picture)
                                                            : 'https://ui-avatars.com/api/?background=random&name=' . urlencode(optional($course->teacher)->full_name) }}"
                                                        class="rounded-circle avatar-xs" />
                                                    <span class="fs-6">{{ $course->teacher->full_name }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li>Belum Ada Data Kursus</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-12 col-md-12 col-12">
                <!-- Card -->
                <div class="card h-100">
                    <!-- Card header -->
                    <div class="card-header card-header-height d-flex align-items-center">
                        <h4 class="mb-0">Aktivitas Terkini</h4>
                    </div>
                    <!-- Card body -->
                    <div class="card-body">
                        <!-- List group -->
                        <ul class="list-group list-group-flush list-timeline-activity">
                            @forelse ($latestStudentActivities as $log)
                                <li class="list-group-item px-0 pt-2 border-0 mb-2">
                                    <div class="row">
                                        <div class="col-auto">
                                            <div class="avatar avatar-md avatar-indicators avatar-online">
                                                <img alt="{{ $log->causer->username }}-avatar"
                                                    src="{{ optional($log->causer)->profile_picture
                                                        ? asset('storage/' . $log->causer->profile_picture)
                                                        : 'https://ui-avatars.com/api/?background=random&name=' . urlencode(optional($log->causer)->full_name) }}"
                                                    class="rounded-circle" />
                                            </div>
                                        </div>
                                        <div class="col ms-n2">
                                            <div class="d-flex flex-column gap-1">
                                                <div>
                                                    <h4 class="mb-0 h5">{{ $log->causer->full_name }}</h4>
                                                    <p class="mb-0">{{ $log->description }}</p>
                                                </div>
                                                <div>
                                                    <span class="fs-6">{{ $log->created_at->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li>Belum Ada Aktivitas</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const revenueCtx = document.getElementById('revenueChart');
            new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: @json($revenueChartLabels),
                    datasets: [{
                        label: 'Revenue',
                        data: @json($revenueChartData),
                        borderColor: '#0d6efd',
                        backgroundColor: 'rgba(13, 110, 253, 0.2)',
                        fill: true,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
            const completionCtx = document.getElementById('completionChart');
            new Chart(completionCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Selesai', 'Sedang dipelajari'],
                    datasets: [{
                        data: [{{ $completed }}, {{ $ongoing }}],
                        backgroundColor: ['#4CAF50', '#FF9800']
                    }]
                }
            });
        });
    </script>
@endsection
