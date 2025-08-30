<main class="container">
    <x-hero-card photo_path="{{ asset('assets/images/course_hero.jpg') }}" title_top="BELAJAR KAPAN SAJA,"
        title_bottom="DIMANA SAJA"
        description="Ratusan kursus online untuk upgrade skill-mu di bidang teknologi, desain, bisnis, dan banyak lagi. Mulai perjalanan belajarmu sekarang!" />

    <!-- Form -->
    <form class="row" id="cardpayment">
        <div class="mb-3 mt-4 col-12">
            <div class="input-group">
                <span class="input-group-text rounded-start-4"><i class="fe fe-search"></i></span>
                <input wire:model.live.debounce="search" type="text"
                    class="form-control text-secondary rounded-end-4" id="card-mask" placeholder="Cari sesuatu" />
            </div>
        </div>
        <!-- Month -->
        <div class="mb-3 col-12 col-md-3">
            <select wire:model.live="program" id="select-program" class="form-select text-secondary">
                <option value="">Pilih Program</option>
                @foreach ($programs as $program)
                    <option value="{{ $program->slug }}">{{ $program->name }}</option>
                @endforeach
            </select>
        </div>
        <!-- Course Topic -->
        <div class="mb-3 col-12 col-md-3">
            <select wire:model.live="category" id="select-course-topic" class="form-select text-secondary">
                <option value="">Topik Kursus</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->slug }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <!-- Access Type -->
        <div class="mb-3 col-12 col-md-3">
            <select wire:model.live="accessType" id="select-access-type" class="form-select text-secondary">
                <option value="">Tipe Akses</option>
                @foreach ($accessTypes as $type)
                    <option value="{{ $type['value'] }}">{{ $type['label'] }}</option>
                @endforeach
            </select>
        </div>
        <!-- Difficulty Level -->
        <div class="mb-3 col-12 col-md-3">
            <select wire:model.live="level" id="select-difficulty-level" class="form-select text-secondary">
                <option value="">Tingkat Kesulitan</option>
                @foreach ($courseLevels as $level)
                    <option value="{{ $level['value'] }}">{{ $level['label'] }}</option>
                @endforeach
            </select>
        </div>
    </form>

    <div style="padding: 4rem 0;">
        <div class="mb-6">
            <h2 class="fs-2 mb-0 text-dark">Mood Belajar Apa Hari Ini?</h2>
            <p class="text-dark">Pilih topik sesuai suasana hatimu dan mulai eksplorasi ilmu baru sekarang juga!</p>
        </div>

        <div class="mb-6">
            <div class="row g-5">

                @forelse ($courses as $course)
                    <div class="col-md-6 col-lg-4 col-xl-3 col-12 mb-3 d-flex justify-content-center">
                        <x-course-card :key="$course->id" :course="$course" />
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

                {{ $courses->links(data: ['scrollTo' => false]) }}
            </div>
        </div>
    </div>

</main>

@assets
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

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

    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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

            @this.call('triggerRender')
        }

        // Sync on initial load (for URL parameters)
        $(document).ready(function() {
            syncLivewireToSelect2();
        });
    </script>
@endscript
