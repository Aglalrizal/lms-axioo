<section class="container-fluid p-4">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page Header -->
            <div
                class="border-bottom pb-3 mb-3 d-flex flex-column flex-md-row gap-3 align-items-md-center justify-content-between">
                <div class="d-flex flex-column gap-1">
                    <h1 class="mb-0 h2 fw-bold">Daftar Kursus Aktif
                    </h1>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Card -->
            <div class="card rounded-3">
                <!-- Card header -->
                <div class="p-4 row">
                    <!-- Form -->
                    <div class="d-flex align-items-center col-12 col-md-12 col-lg-12">
                        <span class="position-absolute ps-3 search-icon"><i class="fe fe-search"></i></span>
                        <input type="search" class="form-control ps-6"
                            style="color: var(--gk-body-color); 
                                    font-size: 0.875em !important;"
                            placeholder="Cari kursus" wire:model.live="search" />
                    </div>
                    <div class="col-12 d-flex mt-3 gap-2">
                        <div class="mb-3 col-12 col-md-2 flex-grow-1 flex-lg-grow-2" wire:ignore>
                            <select id="select-program" class="form-select text-secondary">
                                <option value="">Pilih Program</option>
                                <option value="no-program">Tidak Ada Program</option>
                                @foreach ($programs as $program)
                                    <option value="{{ $program->slug }}">{{ $program->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 col-12 col-md-2 flex-grow-1 flex-lg-grow-2" wire:ignore>
                            <select id="select-instructor" class="form-select text-secondary">
                                <option value="">Pilih Instruktur</option>
                                @foreach ($instructors as $instructor)
                                    <option value="{{ $instructor->id }}">{{ $instructor->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Course Topic -->
                        <div class="mb-3 col-12 col-md-2 flex-grow-1" wire:ignore>
                            <select id="select-category" class="form-select text-secondary">
                                <option value="">Topik Kursus</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->slug }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 col-12 col-md-2 flex-grow-1" wire:ignore>
                            <select id="select-access-type" class="form-select text-secondary">
                                <option value="">Tipe Akses</option>
                                @foreach ($accessTypes as $type)
                                    <option value="{{ $type['value'] }}">{{ $type['label'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Difficulty Level -->
                        <div class="mb-3 col-12 col-md-2 flex-grow-1" wire:ignore>
                            <select id="select-level" class="form-select text-secondary">
                                <option value="">Tingkat Kesulitan</option>
                                @foreach ($courseLevels as $level)
                                    <option value="{{ $level['value'] }}">{{ $level['label'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="d-flex col-lg-5 gap-2">
                        <select wire:model.live="sortBy" class="form-select fs-5"
                            style="color: var(--gk-body-color); 
                                    font-size: 0.875em !important;">
                            <option value="title">Judul</option>
                            <option value="created_at">Tanggal Dibuat</option>
                            <option value="updated_at">Tanggal Diperbarui</option>
                        </select>

                        <select wire:model.live="sortDirection" class="form-select fs-5"
                            style="color: var(--gk-body-color); 
                                    font-size: 0.875em !important;">
                            <option value="asc">A-Z / Terlama</option>
                            <option value="desc">Z-A / Terbaru</option>
                        </select>
                    </div>
                </div>
                <div>
                    <div class="tab-content" id="tabContent">
                        <div class="tab-pane fade show active" id="courses">
                            @if ($courses->count() > 0)
                                <div class="table-responsive border-0 overflow-y-hidden">
                                    <table class="table mb-0 text-nowrap table-centered table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Nama Kursus</th>
                                                <th>Program</th>
                                                <th>Kategori</th>
                                                <th>Instruktur</th>
                                                <th>Tipe Kursus</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($courses as $course)
                                                <tr>
                                                    <td>
                                                        <a wire:navigate
                                                            href="{{ route('admin.course.published.show', ['slug' => $course->slug]) }}"
                                                            class="text-inherit">
                                                            <div class="d-flex align-items-center gap-3">
                                                                <div>
                                                                    @if ($course->thumbnail)
                                                                        @if (str_contains($course->thumbnail, 'samples'))
                                                                            <img src="{{ asset($course->thumbnail) }}"
                                                                                alt="{{ $course->slug }}-image"
                                                                                class="img-4by3-lg rounded" />
                                                                        @else
                                                                            <img src="{{ asset('storage/' . $course->thumbnail) }}"
                                                                                alt="{{ $course->slug }}-image"
                                                                                class="img-4by3-lg rounded" />
                                                                        @endif
                                                                    @else
                                                                        <img src="https://placehold.co/100x60"
                                                                            alt="{{ $course->slug }}-image"
                                                                            class="img-4by3-lg rounded" />
                                                                    @endif
                                                                </div>
                                                                <div class="d-flex flex-column gap-1">
                                                                    <h4 class="mb-0 text-primary-hover">
                                                                        {{ Str::title($course->title) }}</h4>
                                                                    <span>Dibuat pada
                                                                        {{ $course->created_at->translatedFormat('d F, Y') }}</span>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center flex-row gap-2">
                                                            <h5 class="mb-0">
                                                                {{ Str::title($course->program->name ?? '-') }}
                                                            </h5>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center flex-row gap-2">
                                                            <h5 class="mb-0">
                                                                {{ Str::title($course->courseCategory->name) }}
                                                            </h5>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center flex-row gap-2">
                                                            <img src="{{ optional($course->teacher)->profile_picture
                                                                ? asset('storage/' . $course->teacher->profile_picture)
                                                                : 'https://ui-avatars.com/api/?background=random&name=' . urlencode(optional($course->teacher)->full_name) }}"
                                                                alt="{{ $course->teacher->full_name . '-avatar' }}"
                                                                class="rounded-circle avatar-xs" />
                                                            <h5 class="mb-0">
                                                                {{ $course->teacher->full_name }}
                                                            </h5>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center flex-row gap-2">
                                                            @switch($course->access_type->value)
                                                                @case('free')
                                                                    <span class="badge bg-success">Gratis</span>
                                                                @break

                                                                @case('free_trial')
                                                                    <span class="badge bg-warning text-dark">Gratis
                                                                        Percobaan</span>
                                                                @break

                                                                @case('paid')
                                                                    <span class="badge bg-primary">Berbayar</span>
                                                                @break
                                                            @endswitch
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-center">Belum ada kursus yang aktif.</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-footer pt-5">
                    {{ $courses->links() }}
                </div>
            </div>
        </div>
    </div>
</section>
@assets
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">

    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endassets

@script
    <script>
        $(document).ready(function() {
            $('#select-program').select2();
            $('#select-access-type').select2();
            $('#select-category').select2();
            $('#select-level').select2();
            $('#select-instructor').select2();

            $('#select-program').val(@this.program).trigger('change');
            $('#select-access-type').val(@this.accessType).trigger('change');
            $('#select-category').val(@this.category).trigger('change');
            $('#select-level').val(@this.level).trigger('change');
            $('#select-instructor').val(@this.level).trigger('change');

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
            $('#select-instructor').on('change', function(e) {
                @this.set('instructor', e.target.value);
            });
        });
    </script>
@endscript
