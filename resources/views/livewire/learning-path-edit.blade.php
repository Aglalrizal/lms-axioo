<section class="container-fluid p-4">
    <div class="row d-flex">
        <!-- Page header -->
        <div class="col-lg-12 col-md-12 col-12">
            <div
                class="border-bottom pb-3 mb-3 d-flex flex-column flex-md-row gap-3 align-items-md-center justify-content-between">
                <div class="d-flex flex-column gap-1">
                    <h1 class="mb-0 h2 fw-bold">Edit Learning Path</h1>
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.learning-paths.index') }}">Learning Paths</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Edit</li>
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

    <form wire:submit="save">
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
                                            <i class="fe fe-edit me-1"></i>Draft
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
                                    class="btn btn-outline-{{ $learningPath->is_published ? 'warning' : 'success' }} btn-sm">
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
                <div class="card border-0">
                    <div class="card-header d-flex gap-2 align-items-center">
                        <h4 class="mb-0">Informasi Dasar</h4>
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
            </div>

            <!-- Learning Steps -->
            <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                <div class="card border-0">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Jalur Pembelajaran</h4>
                        <button type="button" class="btn btn-outline-primary btn-sm" wire:click="addStep">
                            <i class="fe fe-plus me-2"></i>Tambah Langkah
                        </button>
                    </div>
                    <div class="card-body">
                        @if (count($steps) > 0)
                            <div id="sortable-steps" class="sortable-container">
                                @foreach ($steps as $index => $step)
                                    <div class="step-item mb-4 border rounded p-3 {{ isset($step['id']) && $step['id'] ? 'bg-white' : 'bg-light border-primary' }}"
                                        wire:key="step-{{ $step['temp_id'] }}" data-step-id="{{ $step['temp_id'] }}">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="drag-handle me-3" style="cursor: move;">
                                                    <i class="fe fe-move text-muted"></i>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <h6 class="mb-0 me-2">Step {{ $index + 1 }}</h6>
                                                    @if (!isset($step['id']) || !$step['id'])
                                                        <span class="badge bg-primary-soft text-primary">New</span>
                                                    @endif
                                                </div>
                                            </div>
                                            @if (count($steps) > 1)
                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                    wire:click="removeStep({{ $index }})">
                                                    <i class="fe fe-trash-2"></i>
                                                </button>
                                            @endif
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Judul Langkah <span
                                                        class="text-danger">*</span></label>
                                                <input wire:model="steps.{{ $index }}.title" type="text"
                                                    class="form-control" placeholder="Judul Langkah" />
                                                @error("steps.{$index}.title")
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Kursus <span
                                                        class="text-danger">*</span></label>
                                                <select wire:model="steps.{{ $index }}.course_id"
                                                    class="form-select">
                                                    <option value="">Select a course</option>
                                                    @foreach ($courses as $course)
                                                        <option value="{{ $course->id }}">{{ $course->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error("steps.{$index}.course_id")
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">Deskripsi Langkah <span
                                                        class="text-danger">*</span></label>
                                                <textarea wire:model="steps.{{ $index }}.description" class="form-control" rows="3"
                                                    placeholder="Apa yang akan dipelajari siswa di langkah ini?"></textarea>
                                                @error("steps.{$index}.description")
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
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
    </form>
</section>

@assets
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
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
    </style>
@endassets

@script
    <script>
        let sortable;

        function initSortable() {
            const container = document.getElementById('sortable-steps');
            if (container) {
                // Destroy existing sortable if it exists
                if (sortable) {
                    sortable.destroy();
                }

                // Create new sortable instance
                sortable = Sortable.create(container, {
                    handle: '.drag-handle',
                    animation: 150,
                    ghostClass: 'sortable-ghost',
                    chosenClass: 'sortable-chosen',
                    onEnd: function(evt) {
                        const stepIds = Array.from(container.children).map(el => el.dataset.stepId);
                        $wire.updateStepOrder(stepIds);
                    }
                });
            }
        }

        // Listen for component-loaded event from Livewire component
        Livewire.on('component-loaded', () => {
            initSortable();
        });
    </script>
@endscript
