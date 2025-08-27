<main class="container">
    <section style="padding: 4rem 0" class="d-flex align-items-center">
        <div style="aspect-ratio: 21/9; border-radius: 50px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
            class="position-relative overflow-hidden mx-auto">
            <img src="{{ asset('assets/images/blog_hero.jpg') }}" class="object-fit-cover w-100 h-100" alt="blogpost" />
            <div class="position-absolute bottom-0 left-0 d-flex flex-column justify-content-end w-100 h-100 p-5 text-white"
                style=" background: linear-gradient(to top, rgba(0, 0, 0, 0.8) 0%, rgba(0, 0, 0, 0) 90%);">
                <h2 class="text-white fs-1 mb-n2">BELAJAR KAPAN SAJA,</h2>
                <h2 class="text-white fs-1">DIMANA SAJA</h2>
                <p>Ratusan kursus online untuk upgrade skill-mu di bidang teknologi, desain, bisnis, dan banyak
                    lagi. Mulai perjalanan belajarmu sekarang!</p>
            </div>
        </div>
    </section>

    <!-- Form -->
    <form class="row" id="cardpayment">
        <div class="mb-3 mt-4 col-12">
            <div class="input-group">
                <span class="input-group-text rounded-start-4"><i class="fe fe-search"></i></span>
                <input wire:model.live.debounce="search" type="text" class="form-control rounded-end-4"
                    id="card-mask" placeholder="Cari sesuatu" />
            </div>
        </div>
        <!-- Month -->
        <div class="mb-3 col-12 col-md-3">
            <select wire:model.live="program" id="select-program" class="form-select">
                <option value="">Pilih Program</option>
                @foreach ($programs as $program)
                    <option value="{{ $program->slug }}">{{ $program->name }}</option>
                @endforeach
            </select>
        </div>
        <!-- Course Topic -->
        <div class="mb-3 col-12 col-md-3">
            <select wire:model.live="category" id="select-course-topic" class="form-select">
                <option value="">Topik Kursus</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->slug }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <!-- Access Type -->
        <div class="mb-3 col-12 col-md-3">
            <select wire:model.live="accessType" id="select-access-type" class="form-select">
                <option value="">Tipe Akses</option>
                @foreach ($accessTypes as $type)
                    <option value="{{ $type['value'] }}">{{ $type['label'] }}</option>
                @endforeach
            </select>
        </div>
        <!-- Difficulty Level -->
        <div class="mb-3 col-12 col-md-3">
            <select wire:model.live="level" id="select-difficulty-level" class="form-select">
                <option value="">Tingkat Kesulitan</option>
                @foreach ($courseLevels as $level)
                    <option value="{{ $level['value'] }}">{{ $level['label'] }}</option>
                @endforeach
            </select>
        </div>
    </form>

    <div style="padding: 4rem 0;">
        <div class="mb-6">
            <h2 class="fs-2 mb-0">Mood Belajar Apa Hari Ini?</h2>
            <p class="">Pilih topik sesuai suasana hatimu dan mulai eksplorasi ilmu baru sekarang juga!</p>
        </div>

        <div class="mb-6">
            <div class="row g-5">

                @forelse ($courses as $course)
                    <div class="col-md-4 col-12" wire:key="course-{{ $course->id }}">
                        <!-- card -->
                        <div class="card mb-2 mb-lg-0">
                            <!-- card body -->
                            <a href="#!">
                                @if (str_contains($course->thumbnail, 'samples'))
                                    <img src="{{ asset($course->thumbnail) }}" alt="Current"
                                        class="img-fluid w-100 rounded-top-3 object-fit-cover" style="height: 300px;">
                                @else
                                    <img src="{{ $course->thumbnail ? asset('storage/' . $course->thumbnail) : asset('assets/images/education/edu-webinar-1.jpg') }}"
                                        alt="Current" class="img-fluid w-100 rounded-top-3 object-fit-cover"
                                        style="height: 300px;">
                                @endif
                            </a>
                            <div class="card-body">
                                <p class="text-secondary">{{ $course->program->name ?? '' }}</p>
                                <h3 class="mb-2 text-truncate">
                                    <a href="#!" class="text-inherit">{{ $course->title }}</a>
                                </h3>
                                <div class="">
                                    <p class="text-secondary">
                                        {{ Str::limit($course->short_desc ?? $course->description, 120) }}
                                    </p>
                                </div>
                                <div class="text-center mb-0">
                                    <a href={{ route('course.show', $course->slug) }}
                                        class="btn btn-light-primary text-primary">Lihat Kursus</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="fe fe-book-open fs-1 text-muted mb-3"></i>
                            <h4 class="text-muted">Tidak Ada Kursus Ditemukan</h4>
                            <p class="text-muted">Coba ubah filter pencarian atau kata kunci yang Anda gunakan.</p>
                        </div>
                    </div>
                @endforelse

            </div>
        </div>
    </div>

</main>

@assets
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <style>
        /* Custom CSS to make Select2 look like Bootstrap form-select */
        .select2-container--default .select2-selection--single {
            height: 2.5rem !important;
            padding: 0 0.5rem !important;
            font-size: 0.9rem !important;
            color: #ced4da !important;

            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m1 6 7 7 7-7'/%3e%3c/svg%3e") !important;
            background-repeat: no-repeat !important;
            background-position: right 1rem center !important;
            background-size: 16px 12px !important;

            border: 1px solid #ced4da !important;
            border-radius: 0.75rem !important;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out !important;
            display: flex !important;
            align-items: center !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            display: none !important;
        }

        .select2-dropdown {
            border: 1px solid #ced4da !important;
        }

        .select2-container--default .select2-results__option {
            padding: 0.5rem 1rem !important;
        }
    </style>
@endassets

@script
    <script>
        // Initialize Select2
        $('#select-program').select2({
            width: '100%'
        });
        $('#select-access-type').select2({
            width: '100%'
        });
        $('#select-course-topic').select2({
            width: '100%'
        });
        $('#select-difficulty-level').select2({
            width: '100%'
        });

        // Sync Select2 changes with Livewire
        $('#select-program').on('change', function(e) {
            @this.set('program', $(this).val());
        });

        $('#select-access-type').on('change', function(e) {
            @this.set('accessType', $(this).val());
        });

        $('#select-course-topic').on('change', function(e) {
            @this.set('category', $(this).val());
        });

        $('#select-difficulty-level').on('change', function(e) {
            @this.set('level', $(this).val());
        });

        // Function to sync Livewire values to Select2 (for URL parameters)
        function syncLivewireToSelect2() {
            $('#select-program').val(@this.program).trigger('change.select2');
            $('#select-access-type').val(@this.accessType).trigger('change.select2');
            $('#select-course-topic').val(@this.category).trigger('change.select2');
            $('#select-difficulty-level').val(@this.level).trigger('change.select2');
        }

        // Sync on initial load (for URL parameters)
        $(document).ready(function() {
            syncLivewireToSelect2();
        });
    </script>
@endscript
