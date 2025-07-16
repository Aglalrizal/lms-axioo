<!-- Container fluid -->
<section class="container-fluid p-4">
    <div class="row">
        <!-- Page Header -->
        <div class="col-lg-12 col-md-12 col-12">
            <div
                class="border-bottom pb-3 mb-3 d-flex flex-column flex-md-row gap-3 align-items-md-center justify-content-between">
                <div class="d-flex flex-column gap-1">
                    <h1 class="mb-0 h2 fw-bold">Courses Category</h1>
                </div>
                <div>
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#courseCategoryModal">Add
                        Course
                        Category</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Card -->
            <div class="card mb-4">
                <!-- Card header -->
                <div class="card-header border-bottom-0">
                    <!-- Form -->
                    <form class="d-flex align-items-center">
                        <span class="position-absolute ps-3 search-icon">
                            <i class="fe fe-search"></i>
                        </span>
                        <input wire:model.live="search" class="form-control ps-6"
                            placeholder="Search Course Category" />
                    </form>
                </div>
                <div class="card-body">
                    <!-- Table -->
                    <div class="table-responsive border-0 overflow-y-hidden">
                        <table class="table mb-0 text-nowrap table-centered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">Category</th>
                                    <th class="text-center">Course</th>
                                    <th class="text-center">Date Created</th>
                                    <th class="text-center">Date Updated</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($courseCategories as $category)
                                    <tr>
                                        <td class="text-left">
                                            <a href="#" class="text-inherit">
                                                <h5 class="mb-0 text-primary-hover">{{ $category->name }}</h5>
                                            </a>
                                        </td>
                                        <td class="text-center">{{ $category->courses->count() }}</td>
                                        <td class="text-center">{{ $category->created_at->translatedFormat('d F, Y') }}
                                        </td>
                                        <td class="text-center">{{ $category->updated_at->translatedFormat('d F, Y') }}
                                        </td>

                                        <td>
                                            <div class="hstack gap-4">
                                                <span class="dropdown dropstart">
                                                    <a class="btn-icon btn btn-ghost btn-sm rounded-circle"
                                                        href="#" role="button" data-bs-toggle="dropdown"
                                                        data-bs-offset="-20,20" aria-expanded="false">
                                                        <i class="fe fe-more-vertical"></i>
                                                    </a>
                                                    <span class="dropdown-menu">
                                                        <span class="dropdown-header">Action</span>
                                                        <button
                                                            wire:click="$dispatch('edit-mode',{id: {{ $category->id }}})"
                                                            class="dropdown-item" type="button" class="dropdown-item"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#courseCategoryModal">
                                                            <i class="fe fe-edit dropdown-item-icon"></i>
                                                            Edit
                                                        </button>
                                                        <button
                                                            wire:click="$dispatch('delete-category',{id: {{ $category->id }}})"
                                                            class="dropdown-item text-danger">
                                                            <i class="fe fe-trash dropdown-item-icon text-danger"></i>
                                                            Remove
                                                        </button>
                                                    </span>
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="5">Course category not found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    {{ $courseCategories->links() }}
                </div>
            </div>
        </div>
    </div>
    <livewire:admin.course.category-modal>
</section>

<script>
    document.addEventListener('livewire:initialized', () => {
        @this.on('refresh-categories', (event) => {
            var myCourseCategoryModalEl = document.querySelector('#courseCategoryModal')
            var courseCategoryModal = bootstrap.Modal.getOrCreateInstance(myCourseCategoryModalEl)


            courseCategoryModal.hide();
            @this.dispatch('reset-course-category-modal');
        })

        var myCourseCategoryModalEl = document.getElementById('courseCategoryModal')
        myCourseCategoryModalEl.addEventListener('hidden.bs.modal', (event) => {
            @this.dispatch('reset-course-category-modal');
        })
    })
</script>
