<main class="container">
    <x-hero-card photo_path="{{ asset('assets/images/course_hero.jpg') }}" title_top="BELAJAR KAPAN SAJA,"
        title_bottom="DIMANA SAJA"
        description="Ratusan kursus online untuk upgrade skill-mu di bidang teknologi, desain, bisnis, dan banyak lagi. Mulai perjalanan belajarmu sekarang!" />

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
        <div class="mb-3 col-12 col-md-3" wire:ignore>
            <select id="select-program" class="form-select text-secondary">
                <option value="">Pilih Program</option>
                @foreach ($programs as $program)
                    <option value="{{ $program->slug }}">{{ $program->name }}</option>
                @endforeach
            </select>
        </div>
        <!-- Course Topic -->
        <div class="mb-3 col-12 col-md-3" wire:ignore>
            <select id="select-category" class="form-select text-secondary">
                <option value="">Topik Kursus</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->slug }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <!-- Access Type -->
        <div class="mb-3 col-12 col-md-3" wire:ignore>
            <select id="select-access-type" class="form-select text-secondary">
                <option value="">Tipe Akses</option>
                @foreach ($accessTypes as $type)
                    <option value="{{ $type['value'] }}">{{ $type['label'] }}</option>
                @endforeach
            </select>
        </div>
        <!-- Difficulty Level -->
        <div class="mb-3 col-12 col-md-3" wire:ignore>
            <select id="select-level" class="form-select text-secondary">
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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">

    <style>
        .select2-container--default .select2-selection--single {
            border-radius: 0.75rem !important;
        }
    </style>

    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endassets

@script
    <script>
        // Sync on initial load (for URL parameters)
        $(document).ready(function() {
            $('#select-program').select2();
            $('#select-access-type').select2();
            $('#select-category').select2();
            $('#select-level').select2();

            $('#select-program').val(@this.program).trigger('change');
            $('#select-access-type').val(@this.accessType).trigger('change');
            $('#select-category').val(@this.category).trigger('change');
            $('#select-level').val(@this.level).trigger('change');

            $('#select-program').on('change', function(e) {
                @this.set('program', e.target.value);
            });
            $('#select-access-type').on('change', function(e) {
                @this.set('accessType', e.target.value);
            });
            $('#select-category').on('change', function(e) {
                @this.set('category', e.target.value);
            });
            $('#select-level').on('change', function(e) {
                @this.set('level', e.target.value);
            });
        });
    </script>
@endscript
