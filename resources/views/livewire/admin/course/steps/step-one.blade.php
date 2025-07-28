<div>
    <form wire:submit="stepOne">
        <!-- Card -->
        <div class="card mb-3">
            <div class="card-header border-bottom px-4 py-3">
                <h4 class="mb-0">Informasi Dasar</h4>
            </div>
            <!-- Card body -->
            <div class="card-body">
                <div class="mb-3">
                    <label for="addCourseTitle" class="form-label">Judul Kursus</label>
                    <input id="addCourseTitle" wire:model="title"
                        class="form-control @error('title') is-invalid @enderror" type="text" autocomplete="off" />
                    @error('title')
                        <small class="d-block mt-2 text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="duration" class="form-label">Durasi Kursus <small>(jam)</small></label>
                    <input id="duration" wire:model="duration"
                        class="form-control @error('duration') is-invalid @enderror" type="number" min="0" />
                    @error('duration')
                        <small class="d-block mt-2 text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <div wire:ignore>
                        <label class="form-label" for="select-category">Kategori</label>
                        <select class="form-select" id="select-category" wire:model="courseCategory">
                            <option value="">Pilih Kategori
                            </option>
                            @foreach ($categories as $item)
                                <option value="{{ $item->id }}">{{ Str::title($item->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('courseCategory')
                        <small class="d-block mt-2 text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <div wire:ignore>
                        <label class="form-label" for="select-instructor">Instruktur</label>
                        <select class="form-select" id="select-instructor" wire:model="courseInstructor">
                            <option value="">Pilih Instruktur
                            </option>
                            @foreach ($instructors as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->first_name . ' ' . $item->surname }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('courseInstructor')
                        <small class="d-block mt-2 text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="addCourseLevel">Level Kursus</label>
                    <select class="form-select text-dark" id="addCourseLevel" wire:model="courseLevel">
                        <option value="">Pilih Level</option>
                        <option value="beginner">Pemula</option>
                        <option value="intermediate">Menengah</option>
                        <option value="advanced">Mahir</option>
                    </select>
                    @error('courseLevel')
                        <small class="d-block mt-2 text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="addCourseType">Tipe Kursus</label>
                    <select class="form-select text-dark" id="addCourseType" wire:model="courseType">
                        <option value="">Pilih Level</option>
                        <option value="free_trial">Gratis Percobaan</option>
                        <option value="free">Gratis</option>
                        <option value="paid">Berbayar</option>
                    </select>
                    @error('courseType')
                        <small class="d-block mt-2 text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <livewire:jodit-text-editor wire:model.live="description" />
                    @error('description')
                        <small class="d-block mt-2 text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>
        <!-- Button -->
        <div class="card-footer">
            <x-course-multi-step-nav :step="$step" :slug="$slug" />
        </div>
    </form>
</div>

@assets
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="//unpkg.com/jodit@4.1.16/es2021/jodit.min.css">
    <script src="//unpkg.com/jodit@4.1.16/es2021/jodit.min.js"></script>
    <style>
        .jodit-wysiwyg pre {
            background-color: #1f2937;
            color: #ffffff;
            padding: 1rem;
            border-radius: 0.5rem;
            max-width: 100%;
            overflow-wrap: break-word;
            white-space: pre-wrap;
            word-break: break-word;
        }

        .jodit-wysiwyg code {
            font-size: 0.875rem;
        }

        .jodit-wysiwyg blockquote {
            border-left: 4px solid #9ca3af;
            padding-left: 1rem;
            font-style: italic;
            color: #4b5563;
        }
    </style>
@endassets

@if (session('succes'))
    <script>
        document.addEventListener('livewire:initialized', () => {
            flasher.success('{{ session('success') }}');
        });
    </script>
@endif

@script
    <script>
        $('#select-category').select2();
        $('#select-instructor').select2();

        Livewire.on('init-category', ([categoryId]) => {
            $('#select-category').val(categoryId).trigger('change');
        });
        Livewire.on('init-instructor', ([instructorId]) => {
            $('#select-instructor').val(instructorId).trigger('change');
        });

        document.getElementById('save-button').addEventListener('click', function() {

            const instructor = $('#select-instructor').val();
            const category = $('#select-category').val();
            @this.set('courseCategory', category);
            @this.set('courseInstructor', instructor);
        });
    </script>
@endscript
