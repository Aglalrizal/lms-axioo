<main class="container">
    <!-- Hero Section -->
    <section style="padding: 4rem 0" class="d-flex align-items-center">
        <div style="aspect-ratio: 21/9; border-radius: 50px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
            class="position-relative overflow-hidden mx-auto">
            <img src="{{ asset('assets/images/blog_hero.jpg') }}" class="object-fit-cover w-100 h-100"
                alt="Learning Paths" />
            <div class="position-absolute bottom-0 left-0 d-flex flex-column justify-content-end w-100 h-100 p-5 text-white"
                style=" background: linear-gradient(to top, rgba(0, 0, 0, 0.8) 0%, rgba(0, 0, 0, 0) 90%);">
                <h2 class="text-white fs-1 mb-n2">STRUCTURED LEARNING,</h2>
                <h2 class="text-white fs-1">CLEAR PROGRESS</h2>
                <p>Ikuti jalur pembelajaran yang telah dirancang khusus untuk membantumu menguasai skill baru secara
                    bertahap dan terstruktur.</p>
            </div>
        </div>
    </section>


    <!-- Learning Paths Content -->
    <div style="padding: 4rem 0;">
        <div class="mb-6">
            <h2 class="fs-2 mb-0">Jalur Pembelajaran Tersedia</h2>
            <p class="">Pilih jalur pembelajaran yang sesuai dengan tujuan dan minatmu. Setiap jalur dirancang
                khusus untuk memberikan pengalaman belajar yang terstruktur.</p>
            <div class="mt-2 ms-2">
                <span class="fw-semibold" style="font-size: 1.1rem;">Total {{ $learningPaths->total() ?? 0 }}
                    Paths</span>
            </div>
        </div>

        <div class="mb-6">
            <div class="row g-5">
                @forelse($learningPaths as $path)
                    <div class="col-md-4 col-12" wire:key="path-{{ $path->id }}">
                        <!-- card -->
                        <div class="card mb-2 mb-lg-0">
                            <!-- card body -->
                            <div class="card-header bg-white border-0 ">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <span class="badge bg-primary-soft text-primary">
                                        {{ $path->steps_count }} Kursus
                                    </span>
                                    <div class="d-flex align-items-center text-muted">
                                        <i class="fe fe-clock me-1"></i>
                                        <small>{{ $path->steps_count * 4 }} Minggu</small>
                                    </div>
                                </div>
                                <h3 class="mb-2 text-truncate">
                                    <a href="{{ route('public.learning-paths.show', $path->slug) }}"
                                        class="text-inherit">{{ $path->title }}</a>
                                </h3>
                                <div class="">
                                    <p class="text-secondary">
                                        {{ Str::limit($path->description, 120) }}
                                    </p>
                                </div>
                            </div>

                            <!-- Path Footer -->
                            <div class=" bg-white border-0 pt-0 pb-4 px-4">
                                <div class="text-center mb-0">
                                    <a href="{{ route('public.learning-paths.show', $path->slug) }}"
                                        class="btn btn-light-primary text-primary">Lihat Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="fe fe-book-open fs-1 text-muted mb-3"></i>
                            <h4 class="text-muted">Tidak Ada Learning Path Ditemukan</h4>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Pagination -->
        @if ($learningPaths->hasPages())
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-center mt-8">
                        {{ $learningPaths->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>

</main>

@assets
    <style>
        .bg-primary-soft {
            background-color: rgba(13, 110, 253, 0.1);
        }

        .text-primary {
            color: #0d6efd !important;
        }

        .learning-path-preview {
            max-height: 240px;
            overflow: hidden;
        }

        .step-number {
            min-width: 32px;
            min-height: 32px;
        }

        .card {
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
        }
    </style>
@endassets
