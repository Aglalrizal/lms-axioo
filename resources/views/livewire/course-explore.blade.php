<main>
    <!--Hero Section-->
    <section class="my-5 mx-3">
        <div class="container bg-light rounded-4 pe-lg-0 overflow-hidden">
            <div class="row align-items-center gy-5 gy-xl-0">
                <div class="col-lg-6 col-12">
                    <div class="d-flex flex-column gap-4 px-lg-6 p-3">
                        <div class="d-flex flex-column gap-3">
                            <h1 class="mb-0 display-4 fw-bold">Empower Your Learning Journey Today</h1>
                            <p class="mb-0 pe-xxl-8 me-xxl-5">Take the first step towards achieving your goals with our
                                comprehensive and engaging online courses.</p>
                        </div>
                        <form>
                            <div class="input-group shadow">
                                <label for="courseCategoryCourse" class="form-label visually-hidden">Find Mentor</label>
                                <input type="text" class="form-control rounded-start-3" id="courseCategoryCourse"
                                    name="courseCategoryCourse" placeholder="What do you want to learn?"
                                    aria-label="What do you want to learn?" aria-describedby="basic-addon2"
                                    required="">
                                <button class="btn btn-primary" id="basic-addon2" type="submit">Explore
                                    Courses</button>
                            </div>
                        </form>
                        <div class="d-flex flex-row gap-1 flex-wrap">
                            <a href="#!" class="btn btn-tag">Frontend</a>
                            <a href="#!" class="btn btn-tag">Devops</a>
                            <a href="#!" class="btn btn-tag">UI/UX designer</a>
                            <a href="#!" class="btn btn-tag">Data Science</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-12 d-none d-lg-block">
                    <div class="text-center position-relative">
                        <img src="../assets/images/course/woman-hero.png" alt="hero" class="position-relative z-3">
                        <div class="position-absolute top-0 end-0 bottom-0">
                            <img src="../assets/images/course/side-shape.svg" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Hero Section-->

    <!--explore Programs-->
    <section class="py-xl-8 py-6">
        <div class="container">
            <div class="row">
                <div class="col-xl-10 col-md-10 col-12 mx-auto">
                    <div class="d-flex flex-column gap-2 text-center mb-xl-7 mb-5">
                        <h2 class="h1 mb-0 text-dark">Program</h2>
                        <p class="mb-0 px-xl-5 text-dark">Temukan berbagai program yang dirancang untuk memperluas
                            pengetahuan
                            Anda.</p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">

                @forelse ($programs as $program)
                    <div class="col-xl-3 col-md-4 col-12 mb-4">
                        <a href="{{ route('public.course.search', ['program' => $program->slug]) }}"
                            class="text-decoration-none">
                            <div class="card h-100 overflow-hidden hover-lift"
                                style="max-height: 10rem; transition: transform 0.2s ease-in-out;">
                                <img src={{ asset($program->image_path ?? 'assets/images/samples/course_thumbnail_sample_4.png') }}
                                    class="card-img object-fit-cover h-100" alt="...">
                                <div class="card-img-overlay text-white text-center d-flex flex-column justify-content-center"
                                    style="background-color: rgba(0, 0, 0, 0.60);">
                                    <h5 class="card-title fs-3" style="color: white;">{{ $program->name }}</h5>
                                    <p class="card-text" style="color: white;"><strong>
                                            {{ $program->courses_count }}</strong> Kursus</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <p>No programs found.</p>
                @endforelse

            </div>
        </div>
    </section>
    <!--explore Programs-->

    <!--explore categories-->
    {{-- <section class="py-xl-8 py-6">
        <div class="container">
            <div class="row">
                <div class="col-xl-10 col-md-10 col-12 mx-auto">
                    <div class="d-flex flex-column gap-2 text-center mb-xl-7 mb-5">
                        <h2 class="h1 mb-0">Kategori Kursus</h2>
                        <p class="mb-0 px-xl-5">Temukan berbagai kategori kursus yang sesuai dengan minat dan kebutuhan
                            Anda.</p>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <!--explore categories-->

    <!--Now Courses-->
    <section class="py-xl-8 py-6">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-8 col-12 mx-auto">
                    <div class="d-flex flex-column gap-2 text-center mb-xl-7 mb-5">
                        <h2 class="mb-0 h1 text-dark">Kursus Trending</h2>
                        <p class="mb-0 text-dark">Apakah Anda ingin mengembangkan karir Anda, mempelajari keterampilan
                            baru,
                            atau mengeksplorasi
                            minat, kami memiliki kursus yang tepat untuk Anda.</p>
                    </div>
                </div>
            </div>

            <div class="row g-5">

                @forelse ($courses as $course)
                    <div class="col-md-6 col-lg-4 col-xl-3 col-12 mb-3 d-flex justify-content-center">
                        <x-course-card :key="$course->id" :course="$course" />
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="fe fe-book-open fs-1 text-muted mb-3"></i>
                            <h4 class="text-muted">Tidak Ada Kursus Ditemukan</h4>
                            <p class="text-muted">Coba ubah filter pencarian atau kata kunci yang Anda gunakan.</p>
                        </div>
                    </div>
                @endforelse

                <div class="row">
                    <div class="col-12">
                        <div class="text-center mt-8">
                            <a href="{{ route('public.course.search') }}" class="btn btn-outline-primary">
                                <span>Show All Courses</span>

                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                    fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8">
                                    </path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
    </section>

    <!--Now Courses-->
</main>

@assets
    <style>
        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .card-img-overlay:hover {
            background-color: rgba(0, 0, 0, 0.70) !important;
        }
    </style>
@endassets
