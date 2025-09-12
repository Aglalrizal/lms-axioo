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
                    <label for="short_desc" class="form-label">Deskripsi Singkat</label>
                    <textarea wire:model="short_desc" class="form-control" id="short_desc" rows="2"
                        placeholder="Minimal 75 karakter dan maksimal 150 karakter" maxlength="150"
                        oninput="document.getElementById('shortDescCount').textContent = this.value.length"></textarea>
                    <small id="shortDescCount" class="text-muted">{{ Str::length($short_desc ?? '') }}</small>
                    <small class="text-muted">/ 150 karakter</small>
                    @error('short_desc')
                        <small class="d-block mt-2 text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="duration" class="form-label">Durasi Kursus <small>(jam)</small></label>
                    <input id="duration" wire:model="duration"
                        class="form-control @error('duration') is-invalid @enderror" type="number" min="0"
                        x-on:wheel.prevent x-on:keydown.arrow-up.prevent x-on:keydown.arrow-down.prevent />
                    @error('duration')
                        <small class="d-block mt-2 text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <div wire:ignore>
                        <label class="form-label" for="select-program">Program</label>
                        <select class="form-select" id="select-program" wire:model="program_id" style="width: 100%">
                            <option value="">Tidak ada program
                            </option>
                            @foreach ($programs as $item)
                                <option value="{{ $item->id }}">{{ Str::title($item->name) }}</option>
                            @endforeach
                        </select>
                        <div class="form-text">
                            Jika kursus merupakan bagian dari sebuah program, pilih program terkait. Biarkan kosong
                            jika kursus tidak terkait program apapun.
                        </div>
                    </div>
                    @error('courseprogram')
                        <small class="d-block mt-2 text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <div wire:ignore>
                        <label class="form-label" for="select-category">Kategori</label>
                        <select class="form-select" id="select-category" wire:model="category" style="width: 100%">
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
                        <select class="form-select" id="select-instructor" wire:model="instructor" style="width: 100%">
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
                    <select class="form-select text-dark" id="select-level" wire:model="level">
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
                    <label class="form-label" for="select-access-type">Tipe Kursus</label>
                    <select class="form-select text-dark" id="select-access-type" wire:model="accessType">
                        <option value="">Pilih Level</option>
                        <option value="free_trial">Gratis Percobaan</option>
                        <option value="free">Gratis</option>
                        <option value="paid">Berbayar</option>
                    </select>
                    @error('accessType')
                        <small class="d-block mt-2 text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Harga Kursus</label>
                    <input id="price" wire:model="price" class="form-control @error('price') is-invalid @enderror"
                        type="number" min="0" x-on:wheel.prevent x-on:keydown.arrow-up.prevent
                        x-on:keydown.arrow-down.prevent placeholder="Kosongkan jika tipe kursus adalah gratis" />
                    @error('price')
                        <small class="d-block mt-2 text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <livewire:jodit-text-editor wire:model.live="description" />
                    <div class="form-text">
                        Deskripsi minimal 100 karakter</div>
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

@if (session('success'))
    <script>
        document.addEventListener('livewire:initialized', () => {
            flasher.success('{{ session('success') }}');
        });
    </script>
@endif

@script
    <script>
        $(document).ready(function() {
            $('#select-program').select2();
            $('#select-category').select2();
            $('#select-instructor').select2();
            $('#select-access-type').select2();
            $('#select-level').select2();

            $('#select-program').val(@this.program).trigger('change');
            $('#select-category').val(@this.category).trigger('change');
            $('#select-instructor').val(@this.instructor).trigger('change');
            $('#select-access-type').val(@this.accessType).trigger('change');
            $('#select-level').val(@this.level).trigger('change');

            $('#select-program').on('change', function(e) {
                @this.set('program', e.target.value);
            });
            $('#select-category').on('change', function(e) {
                @this.set('category', e.target.value);
            });
            $('#select-instructor').on('change', function(e) {
                @this.set('instructor', e.target.value);
            });
            $('#select-access-type').on('change', function(e) {
                @this.set('accessType', e.target.value);
            });
            $('#select-level').on('change', function(e) {
                @this.set('level', e.target.value);
            });
        });
    </script>
@endscript
