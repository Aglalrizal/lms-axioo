<div class="p-4">
    <p class="display-4 text-dark">Sertifikat</p>
    <p class="text-dark">Berikut adalah kumpulan sertifikat yang sudah terkumpul dari hasil belajarmu.</p>

    <div class="row pt-6">
        <div class="col-8 mb-3">
            <div class="row mb-4">
                <p class="display-6 mb-0 text-dark">Sertifikat Yang Didapat</p>
            </div>

            @forelse ($completedCourses as $certificate)
                <div class="card mb-3">
                    <div class="card-body d-flex flex-row justify-content-between align-items-center">
                        <div class="d-flex gap-3 align-items-center">
                            {{-- <img src="{{ asset('../assets/images/education/edu-webinar-1.jpg') }}" alt="Certificate"
                                class="img-fluid mb-2" style="width: 5rem; height: 5rem;"> --}}
                            <div>
                                <p class="mb-0 fw-semibold fs-4 text-dark">{{ $certificate->title }}</p>
                                <p class="mb-0 text-secondary text-dark">Waktu penyelesaian:
                                    {{ $certificate->last_progress->translatedFormat('l, jS F Y') }}</p>
                                {{-- <p class="mb-0 text-secondary text-dark">Issued on: 12 Dec, 2022</p> --}}
                            </div>
                        </div>

                        <a href="#" class="btn btn-primary">Unduh Sertifikat</a>

                    </div>
                </div>
            @empty
                <div class="card">
                    <div class="card-body text-center">
                        <p class="mb-0">Kamu belum memiliki sertifikat apapun.</p>
                        <p class="mb-0">Mulailah belajar untuk mendapatkan sertifikat.</p>
                    </div>
                </div>
            @endforelse

            {{ $completedCourses->links() }}
        </div>

        <div class="col-4 mb-3">
            <div class="row mb-4">
                <p class="display-6 mb-0 text-dark">Keterampilanmu</p>
            </div>

            <div class="card ">
                <div class="card-body">
                    <ul class="list-unstyled mb-0 d-inline-flex flex-wrap gap-2 ">
                        @forelse ($completedCourses as $skill)
                            <li class="fs-5 p-2 badge bg-primary">{{ $skill->courseCategory->name }}</li>
                        @empty
                            <li class="fs-5 badge rounded-pill bg-primary">Belum ada keterampilan</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <div class="row pt-4">
            <p class="display-6 mb-4 text-dark">Dapatkan Sertifikat Lainnya</p>
        </div>

        <div class="row">
            @for ($i = 0; $i < 3; $i++)
                <div class="col-md-4 col-12 mb-4">
                    <!-- card -->
                    <div class="card mb-2 mb-lg-0">
                        <!-- card body -->
                        <a href="#!" class="d-flex justify-content-center align-items-center pt-6  logo-inverse">
                            <img src="{{ asset('../assets/images/upmyskill_logo_light.png') }}" alt="upmyskill_logo"
                                class="img-fluid w-50 rounded-top-3">
                        </a>
                        <div class="card-body">
                            <h3 class="my-2 text-center">
                                <a href="#!" class="text-secondary fw-normal text-dark">Basic Computer
                                    Maintenance</a>
                            </h3>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</div>
