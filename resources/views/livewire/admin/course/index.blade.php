<section class="container-fluid p-4">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page Header -->
            <div
                class="border-bottom pb-3 mb-3 d-flex flex-column flex-md-row gap-3 align-items-md-center justify-content-between">
                <div class="d-flex flex-column gap-1">
                    <h1 class="mb-0 h2 fw-bold">Courses</h1>
                </div>
                <div>
                    <a href="{{ route('admin.course.create') }}" class="btn btn-primary">Add New
                        Courses</a>
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
                        <input type="search" class="form-control ps-6" placeholder="Search Course"
                            wire.model.live="search" />
                    </div>
                    <div class="d-flex justify-content-between align-items-center my-3">
                        <div class="d-flex align-items-center gap-2">
                            <div>
                                <select wire:model.live="filterType" class="form-select">
                                    <option value="">Filter: Semua Tipe</option>
                                    <option value="free_trial">Gratis Percobaan</option>
                                    <option value="free">Gratis</option>
                                    <option value="paid">Berbayar</option>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <select wire:model.live="sortBy" class="form-select">
                                <option value="title">Judul</option>
                                <option value="created_at">Tanggal Dibuat</option>
                            </select>

                            <select wire:model.live="sortDirection" class="form-select">
                                <option value="asc">A-Z / Terlama</option>
                                <option value="desc">Z-A / Terbaru</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div>
                    <!-- Table -->
                    <div class="tab-content" id="tabContent">
                        <!--Tab pane -->
                        <div class="tab-pane fade show active" id="courses">
                            @if ($courses->count() > 0)
                                <div class="table-responsive border-0 overflow-y-hidden">
                                    <table class="table mb-0 text-nowrap table-centered table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Nama Kursus</th>
                                                <th>Kategori</th>
                                                <th>Instruktur</th>
                                                <th>Tipe Kursus</th>
                                                <th>Status</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($courses as $course)
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('admin.course.create', ['slug' => $course->slug]) }}"
                                                            class="text-inherit">
                                                            <div class="d-flex align-items-center gap-3">
                                                                <div>
                                                                    <img src="{{ optional($course)->thumbnail ? asset('storage/' . $course->thumbnail) : 'https://placehold.co/100x60' }}"
                                                                        alt="" class="img-4by3-lg rounded" />
                                                                </div>
                                                                <div class="d-flex flex-column gap-1">
                                                                    <h4 class="mb-0 text-primary-hover">
                                                                        {{ Str::title($course->title) }}</h4>
                                                                    <span>Added on
                                                                        {{ $course->created_at->translatedFormat('d F, Y') }}</span>
                                                                </div>
                                                            </div>
                                                        </a>
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
                                                                : 'https://ui-avatars.com/api/?background=random&name=' . urlencode(optional($course->teacher)->first_name) }}"
                                                                alt="{{ $course->teacher->first_name . '-avatar' }}"
                                                                class="rounded-circle avatar-xs" />
                                                            <h5 class="mb-0">
                                                                {{ $course->teacher->first_name . ' ' . $course->teacher->surname }}
                                                            </h5>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center flex-row gap-2">
                                                            @switch($course->course_type)
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
                                                    <td>
                                                        <span
                                                            class="badge-dot bg-warning me-1 d-inline-block align-middle"></span>
                                                        {{ $course->is_published ? 'Published' : 'Draft' }}
                                                    </td>
                                                    <td>
                                                        <span class="dropdown dropstart">
                                                            <a class="btn-icon btn btn-ghost btn-sm rounded-circle"
                                                                href="#" role="button" id="courseDropdown1"
                                                                data-bs-toggle="dropdown" data-bs-offset="-20,20"
                                                                aria-expanded="false">
                                                                <i class="fe fe-more-vertical"></i>
                                                            </a>
                                                            <span class="dropdown-menu"
                                                                aria-labelledby="courseDropdown1">
                                                                <span class="dropdown-header">Settings</span>
                                                                {{-- <a class="dropdown-item"
                                                                href="{{ route('admin.user.profile', ['username' => $user->username]) }}">
                                                                <i class="fe fe-user dropdown-item-icon"></i>
                                                                Profile
                                                            </a> --}}
                                                                <button type="button" class="dropdown-item"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#createUserModal">
                                                                    <i class="fe fe-edit dropdown-item-icon"></i>
                                                                    Edit
                                                                </button>
                                                                <button
                                                                    wire:click="$dispatch('delete-user',{id: {{ $course->id }}})"
                                                                    class="dropdown-item text-danger">
                                                                    <i
                                                                        class="fe fe-trash dropdown-item-icon text-danger"></i>
                                                                    Remove
                                                                </button>
                                                            </span>
                                                        </span>
                                                    </td>
                                                </tr>
                                                @empty
                                                    <tr>
                                                        Belum ada course.
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-center">Belum ada course.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- Card Footer -->
                    <div class="card-footer">
                    </div>
                </div>
            </div>
        </div>
    </section>
