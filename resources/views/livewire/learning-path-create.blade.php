<section class="container-fluid p-4">
    <div class="row d-flex">
        <!-- Page header -->
        <div class="col-lg-12 col-md-12 col-12">
            <div
                class="border-bottom pb-3 mb-3 d-flex flex-column flex-md-row gap-3 align-items-md-center justify-content-between">
                <div class="d-flex flex-column gap-1">
                    <h1 class="mb-0 h2 fw-bold">Buat Jalur Pembelajaran</h1>
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.learning-paths.index') }}">Jalur Pembelajaran</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Buat</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('admin.learning-paths.index') }}" class="btn btn-outline-secondary">
                        <i class="fe fe-arrow-left me-2"></i>Kembali ke Daftar Jalur Pembelajaran
                    </a>
                </div>
            </div>
        </div>
    </div>

    <form wire:submit="save">
        <div class="row gy-4">
            <!-- Basic Information -->
            <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                <div class="card border-0">
                    <div class="card-header">
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
                        <h4 class="mb-0">Langkah Pembelajaran</h4>
                        <button type="button" class="btn btn-primary btn-sm" wire:click="addStep">
                            <i class="fe fe-plus me-2"></i>Tambah Langkah
                        </button>
                    </div>
                    <div class="card-body">
                        @if (count($steps) > 0)
                            <div id="sortable-steps" class="sortable-container">
                                @foreach ($steps as $index => $step)
                                    <div class="step-item mb-4 border rounded p-3 bg-light"
                                        wire:key="step-{{ $step['temp_id'] }}" data-step-id="{{ $step['temp_id'] }}">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="drag-handle me-3" style="cursor: move;">
                                                    <i class="fe fe-move text-muted"></i>
                                                </div>
                                                <h6 class="mb-0">Step {{ $index + 1 }}</h6>
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
                                                <label class="form-label">Judul langkah <span
                                                        class="text-danger">*</span></label>
                                                <input wire:model="steps.{{ $index }}.title" type="text"
                                                    class="form-control" placeholder="Judul langkah" />
                                                @error("steps.{$index}.title")
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Kursus <span
                                                        class="text-danger">*</span></label>
                                                <select wire:model="steps.{{ $index }}.course_id"
                                                    class="form-select">
                                                    <option value="">Pilih kursus</option>
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

                            <div class="alert alert-info">
                                <i class="fe fe-info me-2"></i>
                                <strong>Tip:</strong> Anda dapat menyeret dan menjatuhkan langkah-langkah untuk mengubah
                                urutannya. Setiap langkah harus
                                dibangun di atas langkah sebelumnya.
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fe fe-layers fs-1 text-muted"></i>
                                <h6 class="text-muted mt-3">Belum ada langkah yang ditambahkan</h6>
                                <p class="text-muted">Tambahkan langkah pertama Anda untuk memulai</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="col-xl-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="d-flex gap-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fe fe-save me-2"></i>Buat Jalur Pembelajaran
                            </button>
                            <a href="{{ route('admin.learning-paths.index') }}" class="btn btn-outline-secondary">
                                Batal
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>

@assets
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <style>
        .step-item {
            transition: all 0.3s ease;
        }

        .step-item:hover {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .sortable-ghost {
            opacity: 0.4;
        }

        .sortable-chosen {
            background-color: #f8f9fa;
        }

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

        .bg-primary-soft {
            background-color: rgba(13, 110, 253, 0.1);
        }

        .text-primary {
            color: #0d6efd !important;
        }

        .bg-success-soft {
            background-color: rgba(25, 135, 84, 0.1);
        }

        .bg-warning-soft {
            background-color: rgba(255, 193, 7, 0.1);
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
