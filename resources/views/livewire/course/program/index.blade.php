<!-- Container fluid -->
<section class="container-fluid p-4">
    <div class="row">
        <!-- Page Header -->
        <div class="col-lg-12 col-md-12 col-12">
            <div
                class="border-bottom pb-3 mb-3 d-flex flex-column flex-md-row gap-3 align-items-md-center justify-content-between">
                <div class="d-flex flex-column gap-1">
                    <h1 class="mb-0 h2 fw-bold">Program</h1>
                </div>
                <div>
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#createProgramModal">Tambah Program</a>
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
                        <input wire:model.live="search" class="form-control ps-6" placeholder="Cari Program" />
                    </form>
                </div>
                <div class="card-body">
                    <!-- Table -->
                    <div class="table-responsive border-0 overflow-y-hidden">
                        <table class="table mb-0 text-nowrap table-centered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">Program</th>
                                    <th class="text-center">Jumlah Kursus</th>
                                    <th class="text-center">Tanggal dibuat</th>
                                    <th class="text-center">Tanggal diperbarui</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($programs as $program)
                                    <tr>
                                        <td class="text-left">
                                            <div class="text-inherit">
                                                <div class="d-flex align-items-center gap-3">
                                                    <div>
                                                        @if ($program->image_path)
                                                            <img src="{{ asset('storage/' . $program->image_path) }}"
                                                                alt="{{ $program->slug }}-image"
                                                                class="img-4by3-lg rounded" />
                                                        @else
                                                            <img src="https://placehold.co/100x60"
                                                                alt="{{ $program->slug }}-image"
                                                                class="img-4by3-lg rounded" />
                                                        @endif
                                                    </div>
                                                    <div class="d-flex flex-column gap-1">
                                                        <h4 class="mb-0 text-primary-hover">
                                                            {{ Str::title($program->name) }}</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">{{ $program->course->count() }}</td>
                                        <td class="text-center">{{ $program->created_at->translatedFormat('d F, Y') }}
                                        </td>
                                        <td class="text-center">{{ $program->updated_at->translatedFormat('d F, Y') }}
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
                                                        <span class="dropdown-header">Aksi</span>
                                                        <button
                                                            wire:click="$dispatch('edit-mode',{id: {{ $program->id }}})"
                                                            class="dropdown-item" type="button" class="dropdown-item"
                                                            data-bs-toggle="modal" data-bs-target="#createProgramModal">
                                                            <i class="fe fe-edit dropdown-item-icon"></i>
                                                            Edit
                                                        </button>
                                                        <button
                                                            wire:click="$dispatch('delete-program',{id: {{ $program->id }}})"
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
                                        <td class="text-center" colspan="5">Tidak ada program.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    {{ $programs->links() }}
                </div>
            </div>
        </div>
    </div>
    <livewire:course.program.create />
</section>

@script
    <script>
        Livewire.on('refresh-program', () => {
            let el = document.getElementById('createProgramModal');
            let programModal = bootstrap.Modal.getOrCreateInstance(el);
            setTimeout(() => {
                programModal.hide();
            }, 50);

            Livewire.dispatch('reset-program-modal');
        });
        var myProgramModalEl = document.getElementById('createProgramModal')
        myProgramModalEl.addEventListener('hidden.bs.modal', (event) => {
            document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
            document.body.classList.remove('modal-open');
            document.body.style.overflow = '';
            Livewire.dispatch('reset-program-modal');
        })
    </script>
@endscript
