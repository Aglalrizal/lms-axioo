<div class="p-4">
    <p class="display-4 text-dark">Halo,
        {{ $user->first_name ? $user->first_name . ' ' . $user->surname : $user->username }}</p>
    <p class="text-dark">Selamat datang!</p>

    <div class="row">
        <div class="col-md-4 col-12">
            <!-- card -->
            <div class="card mb-4 mb-lg-0">
                <!-- card body -->
                <div class="card-body p-5 text-center">
                    <h3 class="mb-2 display-3 text-dark">{{ $totalCompletedCourses }}</h3>
                    <p class="mb-0 text-dark">Kelas yang diselesaikan</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-12">
            <!-- card -->
            <div class="card mb-4 mb-lg-0">
                <!-- card body -->
                <div class="card-body p-5 text-center">
                    <h3 class="mb-2 display-3 text-dark">{{ $totalEnrolledCourses }}</h3>
                    <p class="mb-0 text-dark">Kelas yang Dipelajari</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-12">
            <!-- card -->
            <div class="card mb-4 mb-lg-0">
                <!-- card body -->
                <div class="card-body p-5 text-center">
                    <h3 class="mb-2 display-3 text-dark">0</h3>
                    <p class="mb-0 text-dark">Sertifikat Diperoleh</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body" style="padding: 3rem;">
            <div class="row">
                <p class="display-6 mb-0 text-dark">Aktivitas Belajar</p>
            </div>

            <div class="mb-6">
                <div class="text-end mb-2">
                    <a href="#" class="text-dark"><u>Lainnya</u></a>
                </div>
                <div class="row">
                    @forelse ($courses as $course)
                        <div class="col-md-6 col-lg-4 col-xl-3 col-12 mb-3 d-flex justify-content-center">
                            <x-course-progress-card :key="$course->id" :course="$course" />
                        </div>
                    @empty
                        <div class="card">
                            <div class="card-body text-center">
                                <p class="text-muted mb-0">Belum ada kelas yang sedang dipelajari.</p>
                                <a href="{{ route('public.course.explore') }}" class="btn btn-primary mt-2">Ikuti
                                    Kelas</a>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="row pt-4">
                <p class="display-6 mb-0 text-dark">Rekomendasi Kelas Untukmu</p>
            </div>

            <div class="mb-6">
                <div class="text-end mb-2">
                    <a href="#" class="text-dark"><u>Lainnya</u></a>
                </div>
                <div class="row">
                    @forelse ($recommendCourses as $rc)
                        <div class="col-md-6 col-lg-4 col-xl-3 col-12 mb-3 d-flex justify-content-center">
                            <x-course-card :key="$rc->id" :course="$rc" />
                        </div>
                    @empty
                        <div class="card">
                            <div class="card-body text-center">
                                <p class="text-muted mb-0">Belum ada rekomendasi kursus untukmu.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="d-flex align-items-center justify-content-between py-4 ">
                <p class="display-6 mb-0 text-dark">Catat Rencana Belajarmu!</p>
                <button type="button" class="btn btn-primary" wire:click="openModal">
                    <i class="fe fe-plus"></i> Buat Rencana Belajar
                </button>
            </div>

            <div class="mb-6">
                @forelse ($rencanaBelajar as $rencana)
                    <!-- Header & Footer -->
                    <div class="card mb-4" wire:key="{{ $rencana->id }}">
                        <div class="card-header text-dark">
                            {{ $rencana->tanggal }}
                        </div>
                        <div class="row card-body">
                            <div class="col-md-5">
                                <p class="text-dark"><strong>Kelas</strong>: {{ $rencana->kelas }}</p>
                                <p class="mb-0 text-dark"><strong>Program</strong>: {{ $rencana->program }}</p>
                            </div>
                            <div class="col-md-5">
                                <p class="text-dark"><strong>Tanggal</strong>: {{ $rencana->tanggal }}</p>
                                <p class="mb-0 text-dark"><strong>Target</strong>: {{ $rencana->target }}%</p>
                            </div>
                            <div class="col-md-2 d-flex justify-content-center align-items-center">
                                <button wire:click="openModal({{ $rencana->id }})" type="button"
                                    class="btn btn-primary btn-icon">
                                    <i class="fe fe-edit"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="card">
                        <div class="card-body text-center">
                            <p class="text-muted mb-0">Belum ada rencana belajar yang dibuat.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <section class="py-lg-8 py-6">
                <div class="container py-lg-8">
                    <!--row-->
                    <div class="row align-items-center">
                        <div class="offset-xl-1 col-xl-4 col-lg-6 d-none d-lg-block">
                            <!--img-->

                            <img src="../assets/images/mentor/become-mentor.jpg" alt="mentor img"
                                class="img-fluid w-100 rounded-4">

                        </div>
                        <div class="col-xl-6 col-lg-5 offset-lg-1 offset-xl-1">
                            <div class="d-flex flex-column gap-6">
                                <div class="d-flex flex-column gap-2">
                                    <p class="opacity-75 mb-0">Pelajari lebih lanjut.</p>
                                    <!--heading-->
                                    <h2 class="mb-0 display-2">Security Product knowledge</h2>
                                    <!--para-->
                                    <p>Pahami produk-produk keamanan untuk melindungi sistem, jaringan,
                                        data, dan aset digital dari berbagai ancaman keamanan siber.</p>
                                    <div>
                                        <a href="#!" class="btn btn-primary">Lihat Kursus</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>


    <!-- Modal -->
    @if ($showModal)
        <div class="modal show fade" style="display: block;" tabindex="-1" role="dialog"
            aria-labelledby="rencanaBelajarModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="rencanaBelajarModal">Rencana Belajar Baru</h5>
                        <button type="button" class="btn-close" wire:click="closeModal" aria-label="Close">
                            <span aria-hidden="true"></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="createRencanaBelajar">
                            <div class="mb-3">
                                <label for="kelas" class="col-form-label">Kelas</label>
                                <input type="text" class="form-control @error('kelas') is-invalid @enderror"
                                    id="kelas" wire:model="kelas" placeholder="Masukkan nama kelas">
                                @error('kelas')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="program" class="col-form-label">Program</label>
                                <input type="text" class="form-control @error('program') is-invalid @enderror"
                                    id="program" wire:model="program" placeholder="Masukkan nama program">
                                @error('program')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="tanggal" class="col-form-label">Tanggal Target</label>
                                <input type="date" class="form-control @error('tanggal') is-invalid @enderror"
                                    id="tanggal" wire:model="tanggal">
                                @error('tanggal')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="target" class="form-label">Target Progres</label>
                                <div class="input-group">
                                    <input wire:model="target" type="number" max="100" class="form-control"
                                        aria-describedby="inputGroupAppend" placeholder="0" required>
                                    <span class="input-group-text" id="inputGroupAppend">%</span>
                                </div>
                                @error('target')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer justify-content-between ">
                        @if ($action === 'update')
                            <button type="button" class="btn btn-outline-danger"
                                wire:click="confirmation">Hapus</button>
                        @endif

                        <div class="d-flex gap-2 flex-grow-1 justify-content-end">
                            <button type="button" class="btn btn-outline-secondary"
                                wire:click="closeModal">Batal</button>
                            @if ($action === 'update')
                                <button type="button" class="btn btn-primary" wire:click="update">Simpan</button>
                            @else
                                <button type="button" class="btn btn-primary" wire:click="store">Buat</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif
</div>

@assets
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
@endassets
