<div>
    <p class="display-4">Progres Belajar</p>
    <p>Periksa dan terus tingkatkan progres belajarmu setiap harinya!</p>

    <div class="card mt-4">
        <div class="card-body" style="padding: 3rem;">

            <div x-data="{ selected: 'onGoing' }" class="btn-group w-100">
                <button wire:click="setShow('onGoing')" :class="selected === 'onGoing' ? 'active' : ''"
                    @click=" selected = 'onGoing' " class="btn btn-outline-primary">Kelas yang sedang dipelajarai</button>
                <button wire:click="setShow('completed')" :class="selected === 'completed' ? 'active' : ''"
                    @click=" selected = 'completed' " class="btn btn-outline-primary">Kelas yang telah
                    diselesaikan</button>
            </div>

            <div class="mt-6">
                <div class="row">
                    @for ($i = 0; $i < 3; $i++)
                        {{-- @forelse ($courses as $course) --}}
                        <div class="col-md-4 col-12 mb-4">
                            <!-- card -->
                            <div class="card mb-2 mb-lg-0">
                                <!-- card body -->
                                <a href="#!">
                                    <img src="{{ asset('../assets/images/education/edu-webinar-1.jpg') }}"
                                        alt="webinar-1" class="img-fluid w-100 rounded-top-3">
                                </a>
                                <div class="card-body">
                                    <h3 class="mb-2 text-truncate">
                                        <a href="#!" class="text-inherit">Education Edition Deployment And Set
                                            Up</a>
                                    </h3>
                                    <div class="mb-4">
                                        <div>
                                            <div class="progress" style="height: 6px;">
                                                <div class="progress-bar bg-success" role="progressbar"
                                                    style="width: 10%;" aria-valuenow="10" aria-valuemin="0"
                                                    aria-valuemax="100"></div>
                                            </div>
                                            <small>5% Completed</small>
                                        </div>
                                    </div>
                                    <a href="#!" class="btn btn-light-primary text-primary">Lanjut Belajar</a>
                                </div>
                            </div>
                        </div>
                        {{-- @empty
                            <div class="card">
                                <div class="card-body text-center">
                                    <p class="text-muted mb-0">Belum ada kelas yang sedang dipelajari.</p>
                                    <a href="#" class="btn btn-primary mt-2">Ikuti Kelas</a>
                                </div>
                            </div>
                        @endforelse --}}
                    @endfor
                </div>
            </div>
        </div>
    </div>
</div>
