<section class="container-fluid p-4">
    <div class="row d-flex">
        <!-- Page header -->
        <div class="col-lg-12 col-md-12 col-12">
            <div
                class="border-bottom pb-3 mb-3 d-flex flex-column flex-md-row gap-3 align-items-md-center justify-content-between">
                <div class="d-flex flex-column gap-1">
                    <h1 class="mb-0 h2 fw-bold">Create Learning Path</h1>
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.learning-paths.index') }}">Learning Paths</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Create</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('admin.learning-paths.index') }}" class="btn btn-outline-secondary">
                        <i class="fe fe-arrow-left me-2"></i>Back to Learning Paths
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
                        <h4 class="mb-0">Basic Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="title" class="form-label">Learning Path Title <span
                                        class="text-danger">*</span></label>
                                <input wire:model="title" type="text" id="title" class="form-control"
                                    placeholder="Enter learning path title" required />
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="description" class="form-label">Description <span
                                        class="text-danger">*</span></label>
                                <textarea wire:model="description" id="description" class="form-control" rows="4"
                                    placeholder="Describe what learners will achieve..." required></textarea>
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
                        <h4 class="mb-0">Learning Steps</h4>
                        <button type="button" class="btn btn-outline-primary btn-sm" wire:click="addStep">
                            <i class="fe fe-plus me-2"></i>Add Step
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
                                                <label class="form-label">Step Title <span
                                                        class="text-danger">*</span></label>
                                                <input wire:model="steps.{{ $index }}.title" type="text"
                                                    class="form-control" placeholder="Step title" />
                                                @error("steps.{$index}.title")
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Course <span
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
                                                <label class="form-label">Step Description <span
                                                        class="text-danger">*</span></label>
                                                <textarea wire:model="steps.{{ $index }}.description" class="form-control" rows="3"
                                                    placeholder="What will students learn in this step?"></textarea>
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
                                <strong>Tip:</strong> You can drag and drop steps to reorder them. Each step should
                                build upon the previous one.
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fe fe-layers fs-1 text-muted"></i>
                                <h6 class="text-muted mt-3">No steps added yet</h6>
                                <p class="text-muted">Add your first step to get started</p>
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
                                <i class="fe fe-save me-2"></i>Create Learning Path
                            </button>
                            <a href="{{ route('admin.learning-paths.index') }}" class="btn btn-outline-secondary">
                                Cancel
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

        .drag-handle:hover {
            color: #007bff !important;
        }
    </style>
@endassets

@script
    <script>
        let sortable;

        function initSortable() {
            const container = document.getElementById('sortable-steps');
            if (container && !sortable) {
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

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', initSortable);

        // Re-initialize after Livewire updates
        Livewire.hook('morph.updated', () => {
            if (sortable) {
                sortable.destroy();
                sortable = null;
            }
            setTimeout(initSortable, 100);
        });
    </script>
@endscript
