<div>
    <form wire:submit="stepOne">
        <!-- Card -->
        <div class="card mb-3">
            <div class="card-header border-bottom px-4 py-3">
                <h4 class="mb-0">Basic Information</h4>
            </div>
            <!-- Card body -->
            <div class="card-body">
                <div class="mb-3">
                    <label for="addCourseTitle" class="form-label">Course Title</label>
                    <input id="addCourseTitle" wire:model="title"
                        class="form-control @error('title') is-invalid @enderror" type="text"
                        placeholder="Course Title " />
                    <small>Write a 60 character course title.</small>
                    @error('title')
                        <small class="d-block mt-2 text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <div wire:ignore>
                        <label class="form-label" for="select-category">Courses
                            Category</label>
                        <select class="form-select" id="select-category" wire:model="courseCategory">
                            <option value="">Select Category
                            </option>
                            @foreach ($categories as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        <small>Help people find your courses by choosing categories that
                            represent your
                            course.</small>
                    </div>
                    @error('courseCategory')
                        <small class="d-block mt-2 text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <div wire:ignore>
                        <label class="form-label" for="select-instructor">Select
                            Instructor</label>
                        <select class="form-select" id="select-instructor" wire:model="courseInstructor">
                            <option value="">Select Instructor
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
                    <label class="form-label" for="addCourseLevel">Courses level</label>
                    <select class="form-select text-dark" id="addCourseLevel" wire:model="courseLevel">
                        <option value="">Select level</option>
                        <option value="beginner">Beginner</option>
                        <option value="intermediate">Intermediate</option>
                        <option value="advanced">Advanced</option>
                    </select>
                    @error('courseLevel')
                        <small class="d-block mt-2 text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <livewire:jodit-text-editor wire:model.live="description" />
                    @error('description')
                        <small class="d-block mt-2 text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>
        <!-- Button -->
        <div class="card-footer">
            <div class="d-flex justify-content-between">
                <div>
                    <a href="{{ route('admin.course.all') }}" type="button" class="btn btn-secondary">Back to all
                        courses</a>
                </div>
                <div>
                    @if ($step > 1)
                        <button type="button" class="btn btn-primary" wire:click="$dispatch('back')">Previous</button>
                    @endif
                    <button type="submit" class="btn btn-success" id="save-button">Simpan</button>
                    @if ($slug && $step < 4)
                        <button type="button" class="btn btn-primary" wire:click="$dispatch('next')">Next</button>
                    @endif
                </div>
            </div>
        </div>
    </form>
</div>

@assets
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="//unpkg.com/jodit@4.1.16/es2021/jodit.min.css">
    <script src="//unpkg.com/jodit@4.1.16/es2021/jodit.min.js"></script>
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
