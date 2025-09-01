<main class="container">
    <!-- Learning Paths Content -->
    <div style="padding: 4rem 0;">
        <div class="mb-6">
            <h2 class="fs-2 mb-0">Jalur Pembelajaran Tersedia</h2>
            <p class="">Pilih jalur pembelajaran yang sesuai dengan tujuan dan minatmu. Setiap jalur dirancang
                khusus untuk memberikan pengalaman belajar yang terstruktur.</p>
            {{-- <div class="mt-2 ">
                <span class="fw-semibold" style="font-size: 1.1rem;">Total {{ $learningPaths->total() ?? 0 }}
                    Paths</span>
            </div> --}}
        </div>

        <div class="mb-6">
            <div class="row g-5">
                @forelse($learningPaths as $path)
                    <div class="col-md-4 col-12" wire:key="path-{{ $path->id }}">
                        <!-- card -->
                        <a class="card mb-lg-0 path-card h-100"
                            href="{{ route('public.learning-paths.show', $path->slug) }}">
                            <!-- card body -->
                            <div class="card-header border-0 ">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <span class="badge bg-primary-soft text-primary">
                                        {{ $path->steps_count }} Kursus
                                    </span>
                                    <div class="d-flex align-items-center text-muted">
                                        <i class="fe fe-clock me-1"></i>
                                        <small>{{ $path->steps_count * 4 }} Minggu</small>
                                    </div>
                                </div>
                                <h3 class="mb-2">
                                    {{ $path->title }}
                                </h3>
                                <p class="text-secondary mb-0 custom-card-content">
                                    {{ Str::limit($path->description, 120) }}
                                </p>
                            </div>
                        </a>

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
    </div>

</main>
