<section class="container-fluid p-4">
    <div class="row d-flex">
        <!-- Page header -->
        <div class="col-lg-12 col-md-12 col-12">
            <div
                class="border-bottom pb-3 mb-3 d-flex flex-column flex-md-row gap-3 align-items-md-center justify-content-between">
                <div class="d-flex flex-column gap-1">
                    <h1 class="mb-0 h2 fw-bold">Sunting Jalur Pembelajaran</h1>
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.learning-paths.index') }}">Jalur Pembelajaran</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Sunting</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.learning-paths.index') }}" class="btn btn-outline-secondary">
                        <i class="fe fe-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row gy-4">

        <!-- Publication Status -->
        <div class="col-xl-12">
            <div class="card border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="pb-1">Status Publikasi</h4>

                            <div class="d-flex align-items-center gap-2">
                                @if ($learningPath->is_published)
                                    <span class="badge bg-success-soft text-success px-3 py-2">
                                        <i class="fe fe-eye me-1"></i>Publis
                                    </span>
                                @else
                                    <span class="badge bg-warning-soft text-warning px-3 py-2">
                                        <i class="fe fe-edit me-1"></i>Draf
                                    </span>
                                @endif

                                <p class="text-muted mb-0">
                                    @if ($learningPath->is_published)
                                        Jalur pembelajaran ini saat ini dipublikasikan dan terlihat oleh pengguna.
                                    @else
                                        Jalur pembelajaran ini saat ini dalam mode draf.
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div>
                            <button type="button" wire:click="togglePublish({{ $learningPath->id }})"
                                class="btn btn-{{ $learningPath->is_published ? 'warning' : 'success' }} btn-sm">
                                <i class="fe fe-{{ $learningPath->is_published ? 'eye-off' : 'eye' }} me-2"></i>
                                {{ $learningPath->is_published ? 'Batalkan Publikasi' : 'Publikasikan' }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Basic Information -->
        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
            <form wire:submit="save">
                <div class="card border-0">
                    <div class="card-header d-flex gap-2 align-items-center justify-content-between">
                        <h4 class="mb-0">Informasi Dasar</h4>
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fe fe-save me-2"></i>Simpan Info Dasar
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="title" class="form-label">Judul Jalur Pembelajaran <span
                                        class="text-danger">*</span></label>
                                <input wire:model="title" type="text" id="title" class="form-control"
                                    placeholder="Masukkan judul jalur pembelajaran" required />
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="description" class="form-label">Deskripsi <span
                                        class="text-danger">*</span></label>
                                <textarea wire:model="description" id="description" class="form-control" rows="4"
                                    placeholder="Jelaskan apa yang akan dicapai oleh peserta didik..." required></textarea>
                                @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Learning Steps -->
        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
            <div class="card border-0">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Jalur Pembelajaran</h4>
                    <button type="button" class="btn btn-primary btn-sm" wire:click="addStep">
                        <i class="fe fe-plus me-2"></i>Tambah Langkah
                    </button>
                </div>
                <div class="card-body">
                    @php
                        $steps = $learningPath->steps()->orderBy('order')->get();
                    @endphp
                    @if (count($steps) > 0)
                        <div wire:sortable="updateStepOrder"
                            wire:sortable.options="{ animation: 250, ghostClass: 'sortable-ghost', chosenClass: 'sortable-chosen' }"
                            class="sortable-container">

                            @foreach ($steps as $index => $step)
                                <div wire:sortable.item="{{ $step->id }}"
                                    class="step-item mb-4 border rounded p-3 bg-white"
                                    wire:key="step-{{ $step->id }}">

                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="d-flex align-items-center">
                                            <div wire:sortable.handle class="drag-handle me-3" style="cursor: move;">
                                                <i class="fe fe-move text-muted"></i>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <h6 class="mb-0 me-2">Langkah {{ $index + 1 }}</h6>
                                            </div>
                                        </div>
                                        @if (count($steps) > 1)
                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                wire:click="$dispatch('delete-step', { id: {{ $step->id }} })">
                                                <i class="fe fe-trash-2"></i>
                                            </button>
                                        @endif
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Judul Langkah <span
                                                    class="text-danger">*</span></label>
                                            <input value="{{ $step->title }}"
                                                wire:change="updateStep({{ $step->id }}, 'title', $event.target.value)"
                                                type="text" class="form-control" placeholder="Judul Langkah" />
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Kursus <span class="text-danger">*</span></label>
                                            <select class="form-select select2-course"
                                                id="course-select-{{ $step->id }}">
                                                <option value="">Pilih Kursus</option>
                                                @foreach ($courses as $course)
                                                    <option value="{{ $course->id }}"
                                                        {{ $step->course_id == $course->id ? 'selected' : '' }}>
                                                        {{ $course->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Deskripsi Langkah <span
                                                    class="text-danger">*</span></label>
                                            <textarea wire:change="updateStep({{ $step->id }}, 'description', $event.target.value)" class="form-control"
                                                rows="3" placeholder="Apa yang akan dipelajari siswa di langkah ini?">{{ $step->description }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fe fe-layers fs-1 text-muted"></i>
                            <h6 class="text-muted mt-3">No steps found</h6>
                            <p class="text-muted">Add your first step to get started</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>
</section>

@assets
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" />

    <!-- Pastikan jQuery dimuat sebelum Select2 -->
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>
        .drag-handle {
            cursor: move;
            padding: 8px;
            margin: -8px;
            border-radius: 4px;
            transition: all 0.2s ease;
        }

        .drag-handle:hover {
            color: #007bff !important;
            background-color: rgba(0, 123, 255, 0.1);
        }

        .sortable-ghost {
            opacity: 0.5;
            background-color: #f8f9fa;
            border: 2px dashed #dee2e6;
        }

        .sortable-chosen {
            opacity: 0.8;
            transform: rotate(1.5deg);
        }
    </style>
@endassets

@script
    <script>
        $(document).ready(function() {
            initializeSelect2();
        });

        Livewire.hook('morph.updated', () => {
            initializeSelect2();
        });

        function initializeSelect2() {
            // Initialize Select2 untuk setiap dropdown menggunakan ID
            $('select[id^="course-select-"]').each(function() {
                var $element = $(this);
                var stepId = $element.attr('id').replace('course-select-', '');

                // Destroy existing instance if any
                if ($element.hasClass('select2-hidden-accessible')) {
                    $element.select2('destroy');
                }

                // Initialize Select2
                $element.select2({
                    placeholder: 'Pilih Kursus',
                    width: '100%'
                });

                // Remove existing event listeners to prevent duplicates
                $element.off('change.select2Custom');

                // Add custom change event listener
                $element.on('change.select2Custom', function() {
                    var selectedValue = $(this).val();
                    // Directly call Livewire method
                    @this.updateStep(parseInt(stepId), 'course_id', selectedValue);
                });
            });
        }
    </script>
@endscript
