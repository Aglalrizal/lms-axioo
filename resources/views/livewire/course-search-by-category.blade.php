<main class="container">
    <section style="padding: 4rem 0" class="d-flex align-items-center">
        <div style="height: 450px; aspect-ratio: 21/9; border-radius: 50px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
            class="position-relative overflow-hidden mx-auto">
            <img src="{{ asset('assets/images/blog_hero.jpg') }}" class="object-fit-cover w-100 h-100" alt="blogpost" />
            <div class="position-absolute bottom-0 left-0 d-flex flex-column justify-content-end w-100 h-100 p-5 text-white"
                style=" background: linear-gradient(to top, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0) 50%);">
                <h2 class="text-white fs-2 mb-n2">BELAJAR KAPAN SAJA,</h2>
                <h2 class="text-white fs-2">DIMANA SAJA</h2>
                <p>Ratusan kursus online untuk upgrade skill-mu di bidang teknologi, desain, bisnis, dan banyak
                    lagi. Mulai perjalanan belajarmu sekarang!</p>
            </div>
        </div>
    </section>

    <!-- Form -->
    <form class="row" id="cardpayment">
        <div class="mb-3 mt-4 col-12">
            <div class="input-group">
                <span class="input-group-text rounded-start-4"><i class="fe fe-search"></i></span>
                <input type="text" class="form-control rounded-end-4" id="card-mask" placeholder="Cari sesuatu"
                    required />
            </div>
        </div>
        <!-- Month -->
        <div class="mb-3 col-12 col-md-3">
            <select class="form-select rounded-4">
                <option value="">Program Axioo</option>
                <option value="axioo">Axioo</option>
                <option value="intel">Intel</option>
                <option value="makeblock">Makeblock</option>
                <option value="telview">Telview Academy</option>
            </select>
        </div>
        <!-- Year -->
        <div class="mb-3 col-12 col-md-3">
            <select class="form-select rounded-4">
                <option value="">Tipe Kursus</option>
                <option value="gratis">Gratis</option>
                <option value="berbayar">Berbayar</option>
            </select>
        </div>
        {{--  --}}
        <div class="mb-3 col-12 col-md-3">
            <select class="form-select rounded-4">
                <option value="">Topik Kursus</option>
                <option value="robotic">Robotic</option>
                <option value="digital-development">Digital Development</option>
                <option value="artificial-intelligence">Artificial Intelligence</option>
                <option value="graphic-design">Graphic Design</option>
            </select>
        </div>
        {{--  --}}
        <div class="mb-3 col-12 col-md-3">
            <select class="form-select rounded-4">
                <option value="">Tingkat Kesulitan</option>
                <option value="dasar">Dasar</option>
                <option value="pemula">Pemula</option>
                <option value="menengah">Menengah</option>
                <option value="profesional">Profesional</option>
            </select>
        </div>
    </form>

    <div style="padding: 4rem 0;">
        <div class="mb-6">
            <h2 class="fs-2 mb-0">Mood Belajar Apa Hari Ini?</h2>
            <p class="">Pilih topik sesuai suasana hatimu dan mulai eksplorasi ilmu baru sekarang juga!</p>
        </div>

        <div class="mb-6">
            <div class="row g-5">
                @for ($i = 0; $i < 6; $i++)
                    <div class="col-md-4 col-12">
                        <!-- card -->
                        <div class="card mb-2 mb-lg-0">
                            <!-- card body -->
                            <a href="#!">
                                <img src="{{ asset('assets/images/education/edu-webinar-1.jpg') }}" alt="webinar-1"
                                    class="img-fluid w-100 rounded-top-3">
                            </a>
                            <div class="card-body">
                                <h3 class="mb-2 text-truncate">
                                    <a href="#!" class="text-inherit">Education Edition Deployment And
                                        Set
                                        Up</a>
                                </h3>
                                <div class="">
                                    <p class="text-secondary">
                                        Pelajari langkah-langkah dasar merawat dan menangani masalah umum komputer
                                        agar performa selalu optimal.
                                    </p>
                                </div>
                                <div class="text-center mb-0">
                                    <a href="#!" class="btn btn-light-primary text-primary">Lihat Kursus</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>

</main>
