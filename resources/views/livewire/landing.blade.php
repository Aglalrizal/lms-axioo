<main>
    <div class="container">
        <!-- Carousel With Captions -->

        <div class="d-flex justify-content-center align-items-center" style="padding: 4rem 0;">
            <div id="carouselExampleCaptions" class="carousel slide overflow-hidden w-100"
                style="border-radius: 50px; aspect-ratio: 21/9;" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                        aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                        aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                        aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner h-100">
                    <div class="carousel-item active h-100 position-relative">
                        <img src="{{ asset('assets/images/landing_slide1.jpg') }}"
                            class="d-block w-100 h-100 object-fit-cover" alt="">
                        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-75"></div>
                        <div class="carousel-caption d-flex align-items-center justify-content-center h-100 bottom-0">
                            <div class="text-center">
                                <h3 class="text-white fs-2">Keep Learning</h3>
                                <p>Tetap unggul dalam karier dengan mempelajari keterampilan terbaru, kapan pun dan
                                    di
                                    mana pun. Bersama UpMySkill, pembelajaran jadi fleksibel dan memberdayakan kamu
                                    untuk tumbuh sesuai ritmemu sendiri.</p>
                                <div class="d-flex gap-3 justify-content-center">
                                    <button class="btn btn-outline-warning">Uji Coba Gratis 7 Hari</button>
                                    <button class="btn btn-warning">Mulai Belajar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item h-100 position-relative">
                        <img src="{{ asset('assets/images/landing_slide2.jpg') }}"
                            class="d-block w-100 h-100 object-fit-cover" alt="...">
                        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-75"></div>
                        <div class="carousel-caption d-flex align-items-center justify-content-center h-100 bottom-0">
                            <div class="text-center">
                                <h3 class="text-white fs-2">Practice with Purpose</h3>
                                <p>Ubah pengetahuan jadi dampak nyata. Kursus praktik langsung dan jalur
                                    pembelajaran
                                    terarah kami membantumu membangun kepercayaan diri dan kompetensi menghadapi
                                    tantangan industri.</p>
                                <div class="d-flex gap-3 justify-content-center mt-3">
                                    <button class="btn btn-outline-warning">Uji Coba Gratis 7 Hari</button>
                                    <button class="btn btn-warning">Mulai Belajar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item h-100 position-relative">
                        <img src="{{ asset('assets/images/landing_slide3.jpg') }}"
                            class="d-block w-100 h-100 object-fit-cover" alt="...">
                        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-75"></div>
                        <div class="carousel-caption d-flex align-items-center justify-content-center h-100 bottom-0">
                            <div class="text-center">
                                <h3 class="text-white fs-2">Grow with Passion</h3>
                                <p>Maksimalkan potensimu lewat pengalaman belajar yang menarik dan dipandu oleh para
                                    ahli. UpMySkill membantumu menjelajahi apa yang kamu suka—dan menjadikannya
                                    keahlian
                                    yang kamu kuasai.</p>
                                <div class="d-flex gap-3 justify-content-center mt-3">
                                    <button class="btn btn-outline-warning">Uji Coba Gratis 7 Hari</button>
                                    <button class="btn btn-warning">Mulai Belajar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </a>
            </div>
        </div>

        <div style="padding: 4rem 0;">
            <p class="text-center text-dark">Mitra Industri Kami</p>
            <div class="infiniteScrollWrapper">
                <div class="infiniteScroll">
                    <!-- Set pertama logo -->
                    <div class="infiniteScrollitem logo-inverse">
                        <img src="{{ asset('assets/images/axioo_logo.png') }}" alt="axioo logo" />
                    </div>
                    <div class="infiniteScrollitem logo-inverse">
                        <img src="{{ asset('assets/images/ls_logo.png') }}" alt="ls logo" />
                    </div>
                    <div class="infiniteScrollitem logo-inverse">
                        <img src="{{ asset('assets/images/makeblock_logo.png') }}" alt="makeblock logo" />
                    </div>
                    <div class="infiniteScrollitem logo-inverse">
                        <img src="{{ asset('assets/images/telview_logo.png') }}" alt="telview logo" />
                    </div>
                    <div class="infiniteScrollitem logo-inverse">
                        <img src="{{ asset('assets/images/it_smart_logo.png') }}" alt="it smart logo" />
                    </div>
                </div>

                <div class="infiniteScroll">
                    <!-- Duplikasi untuk efek seamless -->
                    <div class="infiniteScrollitem logo-inverse">
                        <img src="{{ asset('assets/images/axioo_logo.png') }}" alt="axioo logo" />
                    </div>
                    <div class="infiniteScrollitem logo-inverse">
                        <img src="{{ asset('assets/images/ls_logo.png') }}" alt="ls logo" />
                    </div>
                    <div class="infiniteScrollitem logo-inverse">
                        <img src="{{ asset('assets/images/makeblock_logo.png') }}" alt="makeblock logo" />
                    </div>
                    <div class="infiniteScrollitem logo-inverse">
                        <img src="{{ asset('assets/images/telview_logo.png') }}" alt="telview logo" />
                    </div>
                    <div class="infiniteScrollitem logo-inverse">
                        <img src="{{ asset('assets/images/it_smart_logo.png') }}" alt="it smart logo" />
                    </div>
                </div>
            </div>
        </div>

        <section style="padding: 4rem 0;">
            <!--flex container-->
            <div class="d-flex align-items-center gap-5 flex-column flex-lg-row">
                <div class="d-none d-lg-block " style="flex-basis: 40%;">
                    <!--img-->
                    <img src="../assets/images/mentor/become-mentor.jpg" alt="mentor img"
                        class="img-fluid object-fit-cover w-100 rounded-5">
                </div>

                <div class="" style="flex-basis: 60%;">
                    <div class="d-flex flex-column gap-6">
                        <div class="d-flex flex-column gap-2">
                            <p class="text-dark opacity-75 mb-0">Tentang Kami</p>
                            <!--heading-->
                            <h2 class="text-dark mb-0 display-4">Mengapa UpMySkill berbeda?</h2>
                            <!--para-->
                            <p class="text-dark">UpMySkill hadir untuk mempercepat proses belajar dan membuka peluang
                                karier bagi
                                generasi muda Indonesia melalui Axioo Class Program, kursus online, dan kolaborasi
                                industri.</p>

                            <!-- List of benefits -->
                            <div class="d-flex flex-column gap-3 mb-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center"
                                        style="width: 1.5rem; height: 1.5rem;">
                                        <i class="fe fe-check text-white fs-4 fw-bold"></i>
                                    </div>
                                    <span class="text-dark">Dipercaya oleh Ribuan Pengguna</span>
                                </div>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center"
                                        style="width: 1.5rem; height: 1.5rem;">
                                        <i class="fe fe-check text-white fs-4 fw-bold"></i>
                                    </div>
                                    <span class="text-dark">Akses Premium Memberships</span>
                                </div>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center"
                                        style="width: 1.5rem; height: 1.5rem;">
                                        <i class="fe fe-check text-white fs-4 fw-bold"></i>
                                    </div>
                                    <span class="text-dark">Instruktur Berkualitas</span>
                                </div>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center"
                                        style="width: 1.5rem; height: 1.5rem;">
                                        <i class="fe fe-check text-white fs-4 fw-bold"></i>
                                    </div>
                                    <span class="text-dark">Kurikulum Berbasis Industri</span>
                                </div>
                            </div>

                            <div>
                                <a href="#!" class="btn btn-warning">Lihat Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div style="padding: 4rem 0;">
            <div class="row text-center">
                <div class="col-lg-3 col-md-6">
                    <div class="d-flex flex-column align-items-center">
                        <i class="bi bi-people-fill text-warning mb-n3" style="font-size: 6.5rem;"></i>
                        <h3 class="text-dark fs-1 fw-bold mb-1">1.000 +</h3>
                        <p class="text-muted">Siswa Aktif</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="d-flex flex-column align-items-center">
                        <i class="bi bi-mortarboard-fill text-warning mb-n3" style="font-size: 6.5rem;"></i>
                        <h3 class="text-dark fs-1 fw-bold mb-1">12.000 +</h3>
                        <p class="text-muted">Lulusan</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="d-flex flex-column align-items-center">
                        <i class="bi bi-collection-play-fill text-warning mb-n3" style="font-size: 6.5rem;"></i>
                        <h3 class="text-dark fs-1 fw-bold mb-1">90 +</h3>
                        <p class="text-muted">Kursus Gratis</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="d-flex flex-column align-items-center">
                        <i class="bi bi-award-fill text-warning mb-n3" style="font-size: 6.5rem;"></i>
                        <h3 class="text-dark fs-1 fw-bold mb-1">150 +</h3>
                        <p class="text-muted">Kursus Aktif</p>
                    </div>
                </div>
            </div>
        </div>

        <div style="padding: 4rem 0 1rem 0;">
            <div class="">
                <p class="text-dark opacity-75 mb-0">Kursus</p>
                <h2 class="text-dark fs-2 mb-0">Temukan kursus sesuai minat dan tujuanmu</h2>
                <p class="text-dark mb-0">Pelajari keterampilan baru yang relevan dengan dunia kerja bersama mentor
                    ahli
                    dan
                    materi yang terstruktur. Akses kapan saja, di mana saja.</p>
            </div>

            <div>
                <div class="text-end mb-2">
                    <a href="#" class="link-dark"><u>Lihat Lebih Banyak</u></a>
                </div>
                <div class="row">
                    @forelse ($courses as $course)
                        <div class="col-md-6 col-lg-4 col-xl-3 col-12 mb-3 d-flex justify-content-center">
                            <x-course-card :key="$course->id" :course="$course" />
                        </div>
                    @empty
                        <p class="text-center">Tidak ada kursus yang ditemukan.</p>
                    @endforelse

                    {{-- <!-- card -->
                            <div class="card mb-2 h-100">
                                <!-- card body -->
                                <a href="{{ route('course.show', $course->slug) }}">
                                    @if (str_contains($course->thumbnail, 'samples'))
                                        <img src="{{ asset($course->thumbnail) }}" alt="{{ $course->slug }}-image"
                                            class="img-fluid w-100 object-fit-cover" style="height: 150px">
                                    @else
                                        <img src="{{ asset('storage/' . $course->thumbnail) }}"
                                            alt="{{ $course->slug }}-image" class="img-fluid w-100"
                                            style="height: 150px">
                                    @endif
                                </a>
                                <div class="card-body">
                                    <h3 class="mb-2 text-truncate">
                                        <a href="{{ route('course.show', $course->slug) }}"
                                            class="text-inherit">{{ $course->title }}</a>
                                    </h3>
                                    <div class="">
                                        <p class="text-secondary">
                                            {{ $course->short_desc }}
                                        </p>
                                    </div>
                                    <div class="text-center mb-0">
                                        <a href="{{ route('course.show', $course->slug) }}"
                                            class="btn btn-dark-primary text-primary">Lihat Kursus</a>
                                    </div>
                                </div>
                            </div> --}}

                </div>

            </div>
        </div>

        @php
            $testimoni = collect([
                (object) [
                    // <-- Tambahkan (object) untuk mengubah array menjadi objek
                    'id' => 1,
                    'nama' => 'John Doe',
                    'deskripsi' =>
                        'Kursus ini membuka wawasan saya tentang bagaimana menjadi fasilitator yang baik. Saya jadi lebih percaya diri untuk memandu kelas!',
                    'jabatan' => 'Software Engineer',
                    'linkedin' => '#',
                ],
                (object) [
                    'id' => 2,
                    'nama' => 'Jane Smith',
                    'deskripsi' =>
                        'Saya kira fasilitator itu cuma pembicara biasa. Setelah ikut kursus ini, ternyata banyak teknik komunikasi dan manajemen kelas yang harus dikuasai.',
                    'jabatan' => 'Data Scientist',
                    'linkedin' => '#',
                ],
                (object) [
                    'id' => 3,
                    'nama' => 'Alice Johnson',
                    'deskripsi' =>
                        'Buat yang belum pernah rakit PC, wajib ikut kursus ini! Materinya mudah dipahami dan sangat praktikal.',
                    'jabatan' => 'Product Manager',
                    'linkedin' => '#',
                ],
                (object) [
                    'id' => 4,
                    'nama' => 'Bob Brown',
                    'deskripsi' =>
                        'Akhirnya paham juga cara kerja hardware komputer. Dulu cuma tahu CPU itu kotak hitam doang, sekarang ngerti semua deskripsinya apa dan fungsinya.',
                    'jabatan' => 'UX Designer',
                    'linkedin' => '#',
                ],
            ]);
        @endphp

        <div style="padding: 4rem 0;">
            <div class="mb-5">
                <p class=" text-dark opacity-75 mb-0">Tentang Kami</p>
                <h2 class="text-dark fs-2 mb-0">Apa Kata Mereka?</h2>
                <p class=" text-dark mb-0">Dengarkan cerita sukses dan pengalaman para alumni yang telah merasakan
                    manfaat
                    nyata
                    dari pembelajaran bersama UpMySkill.</p>
            </div>

            <div class="row">
                @forelse ($testimoni as $item)
                    <div class="col-md-6 col-lg-4 col-xl-3 col-12 mb-3 d-flex justify-content-center ">
                        <x-flip-card :key="$item->id" :item="$item" />
                    </div>
                @empty
                    <p class="text-center">Tidak ada anggota tim yang ditemukan.</p>
                @endforelse
            </div>
        </div>
    </div>

    </div>
</main>

@assets
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <style>
        .carousel-indicators [data-bs-target] {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            border: 0;
        }
    </style>
@endassets
