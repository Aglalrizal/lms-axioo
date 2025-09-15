<main class="container">
    <!-- Hero Section -->
    <section style="padding: 4rem 0;">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-12">
                {{-- <!-- Breadcrumb -->
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('public.learning-paths.index') }}">Learning
                                Paths</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $path->title }}</li>
                    </ol>
                </nav> --}}

                <!-- Path Header -->
                <div class="text-center">
                    <h1 class="display-4 fw-bold mb-3">{{ $path->title }}</h1>
                    <p class="lead text-muted">{{ $path->description }}</p>

                    <div class="d-flex justify-content-center gap-4 mt-4">
                        <div class="text-center">
                            <div class="badge bg-primary-soft text-primary fs-6 px-3 py-2">
                                {{ $path->steps_count }} Langkah
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="badge bg-primary-soft text-primary fs-6 px-3 py-2">
                                {{ $path->steps_count * 4 }} Minggu
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Learning Steps Section -->
    <section>
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-12">
                <div class="mb-5">
                    <h2 class="lead mb-0">Perjalanan Pembelajaran</h2>
                    <p class="">Ikuti langkah-langkah pembelajaran yang telah dirancang khusus untuk mencapai
                        tujuan pembelajaran Anda.</p>
                </div>

                <div class="mb-6">
                    @forelse($path->steps->sortBy('order') as $index => $step)
                        <div class="card mb-4 shadow-sm border-0">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-start gap-4">
                                    <!-- Step Number -->
                                    <div class="flex-shrink-0">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 48px; height: 48px;">
                                            <span class="fw-bold">{{ $index + 1 }}</span>
                                        </div>
                                    </div>

                                    <!-- Step Content -->
                                    <div class="flex-grow-1">
                                        <h4 class="mb-2">{{ $step->title }}</h4>
                                        @if ($step->description)
                                            <p class="text-muted mb-3">{{ $step->description }}</p>
                                        @endif

                                        @if ($step->course)
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center gap-2">
                                                    <i class="fe fe-book-open text-primary"></i>
                                                    <span class="text-muted">Kursus:</span>
                                                    <strong>{{ $step->course->title }}</strong>
                                                </div>
                                                <a href="{{ route('course.show', $step->course->slug) }}"
                                                    class="btn btn-light-primary text-primary">
                                                    Mulai Kursus
                                                    <i class="fe fe-arrow-right ms-1"></i>
                                                </a>
                                            </div>
                                        @else
                                            <div class="alert alert-light border-0" role="alert">
                                                <i class="fe fe-info text-muted me-2"></i>
                                                <span class="text-muted">Kursus belum tersedia untuk step ini.</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if (!$loop->last)
                            <div class="d-flex justify-content-center mb-4">
                                <div class="border-start border-3 border-primary" style="height: 30px;"></div>
                            </div>
                        @endif
                    @empty
                        <div class="text-center py-5">
                            <i class="fe fe-book-open fs-1 text-muted mb-3"></i>
                            <h4 class="text-muted">Belum Ada Langkah Pembelajaran</h4>
                            <p class="text-muted">Learning path ini masih dalam tahap persiapan. Silakan kembali lagi
                                nanti.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Action Buttons -->
                <div class="text-center my-5">
                    <a href="{{ route('public.learning-paths.index') }}" class="btn btn-outline-primary">
                        <i class="fe fe-arrow-left me-2"></i>Kembali ke Daftar Path
                    </a>
                    @if ($path->steps->isNotEmpty())
                        <a href="{{ route('course.show', $path->steps->first()->course->slug ?? '#') }}"
                            class="btn btn-primary ms-3">
                            Mulai Learning Path
                            <i class="fe fe-play-circle ms-2"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </section>
</main>
