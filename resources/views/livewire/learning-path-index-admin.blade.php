<section class="container-fluid p-4">
    <div class="row">
        <!-- Page Header -->
        <div class="col-lg-12 col-md-12 col-12">
            <div class="border-bottom pb-3 mb-3 d-flex align-items-center justify-content-between">
                <div class="d-flex flex-column gap-1">
                    <h1 class="mb-0 h2 fw-bold">Learning Paths</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Learning Paths</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('admin.learning-paths.create') }}" class="btn btn-primary">
                        <i class="fe fe-plus me-2"></i>Create Learning Path
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Card -->
            <div class="card rounded-3">
                <!-- Card Header -->
                <div class="card-header p-0">
                    <ul class="nav nav-lb-tab border-bottom-0" id="tab" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active">All Learning Paths</button>
                        </li>
                    </ul>
                </div>
                <div class="p-4 row">
                    <!-- Search Form -->
                    <form class="d-flex align-items-center col-12 col-md-8 col-lg-4">
                        <span class="position-absolute ps-3 search-icon">
                            <i class="fe fe-search"></i>
                        </span>
                        <input wire:model.live.debounce.300ms="search" type="search" class="form-control ps-6"
                            placeholder="Search Learning Paths" />
                    </form>
                </div>
                <div>
                    <div class="tab-content" id="tabContent">
                        <!-- Tab -->
                        <div class="tab-pane fade show active" id="all-paths" role="tabpanel">
                            <div class="table-responsive">
                                <!-- Table -->
                                <table class="table mb-0 text-nowrap table-centered table-hover">
                                    <!-- Table Head -->
                                    <thead class="table-light">
                                        <tr>
                                            <th>Title</th>
                                            <th>Steps</th>
                                            <th>Status</th>
                                            <th>Created</th>
                                            <th>Author</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Table body -->
                                        @forelse ($learningPaths as $path)
                                            <tr wire:key="path-{{ $path->id }}">
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="ms-3">
                                                            <h5 class="mb-0">
                                                                <a href="{{ route('admin.learning-paths.edit', $path->slug) }}"
                                                                    class="text-inherit">{{ $path->title }}</a>
                                                            </h5>
                                                            <p class="mb-0 text-muted text-truncate"
                                                                style="max-width: 300px;">
                                                                {{ Str::limit($path->description, 60) }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-light text-dark">
                                                        {{ $path->steps_count ?? $path->steps->count() }} Steps
                                                    </span>
                                                </td>
                                                <td>
                                                    @if ($path->is_published)
                                                        <span
                                                            class="badge-dot bg-success me-1 d-inline-block align-middle"></span>
                                                        Published
                                                    @else
                                                        <span
                                                            class="badge-dot bg-warning me-1 d-inline-block align-middle"></span>
                                                        Draft
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($path->created_at->lessThan(now()->subDays(2)))
                                                        {{ $path->created_at->format('d M Y') }}
                                                    @else
                                                        {{ $path->created_at->diffForHumans() }}
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <h6 class="mb-0">{{ $path->created_by ?? 'Admin' }}</h6>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="dropdown dropstart">
                                                        <a class="btn-icon btn btn-ghost btn-sm rounded-circle"
                                                            href="#" role="button"
                                                            id="pathDropdown{{ $path->id }}"
                                                            data-bs-toggle="dropdown" data-bs-offset="-20,20"
                                                            aria-expanded="false">
                                                            <i class="fe fe-more-vertical"></i>
                                                        </a>
                                                        <span class="dropdown-menu"
                                                            aria-labelledby="pathDropdown{{ $path->id }}">
                                                            <span class="dropdown-header">Actions</span>
                                                            <a href="{{ route('admin.learning-paths.edit', $path->slug) }}"
                                                                class="dropdown-item">
                                                                <i class="fe fe-edit dropdown-item-icon"></i>
                                                                Edit
                                                            </a>
                                                            <a wire:click="togglePublish({{ $path->id }})"
                                                                wire:loading.attr="disabled" class="dropdown-item">
                                                                <i
                                                                    class="fe fe-{{ $path->is_published ? 'eye-off' : 'eye' }} dropdown-item-icon"></i>
                                                                {{ $path->is_published ? 'Unpublish' : 'Publish' }}
                                                            </a>
                                                            <div class="dropdown-divider"></div>
                                                            <a wire:click="confirmDelete({{ $path->id }})"
                                                                wire:loading.attr="disabled"
                                                                class="dropdown-item text-danger">
                                                                <i class="fe fe-trash dropdown-item-icon"></i>
                                                                Delete
                                                            </a>
                                                        </span>
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">
                                                    <div class="d-flex justify-content-center align-items-center py-4">
                                                        <div class="text-center">
                                                            <i class="fe fe-map fs-1 text-muted mb-3"></i>
                                                            <h5 class="text-muted">No Learning Paths Found</h5>
                                                            <p class="text-muted mb-0">Start by creating your first
                                                                learning path</p>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Card Footer -->
                    <div class="card-footer">
                        {{ $learningPaths->links(data: ['scrollTo' => false]) }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    @if ($selectedPath)
        <div class="modal fade show" id="deleteModal" tabindex="-1" style="display: block;" aria-modal="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirm Delete</h5>
                        <button type="button" class="btn-close" wire:click="cancelDelete"></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-lg bg-danger-soft rounded-circle me-3">
                                <i class="fe fe-alert-triangle text-danger"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Delete Learning Path</h6>
                                <p class="mb-0 text-muted">This action cannot be undone</p>
                            </div>
                        </div>
                        <p class="text-muted">
                            Are you sure you want to delete <strong>"{{ $selectedPath->title }}"</strong>?
                            All steps and associated data will be permanently removed.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="cancelDelete">Cancel</button>
                        <button type="button" class="btn btn-danger" wire:click="deletePath">
                            <i class="fe fe-trash me-2"></i>Delete Path
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif
</section>
