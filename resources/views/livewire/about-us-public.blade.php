<div class="container mb-4">
    <div class="py-6 text-center">
        <h1 class="fs-2">Tentang Kami</h1>

        @if ($about_us->about_description)
            <p>{{ $about_us->about_description }}</p>
        @else
            <p class="text-secondary">Belum ada deskripsi tentang kami yang ditambahkan</p>
        @endif

    </div>
    <div class="py-6 text-center d-flex flex-column gap-6">
        <div>
            <h2 class="fs-2">Visi Kami</h2>

            @if ($about_us->vision_description)
                <p>{{ $about_us->vision_description }}</p>
            @else
                <p class="text-secondary">Belum ada visi yang ditambahkan</p>
            @endif

        </div>
        <div>
            <h2 class="fs-2">Misi Kami</h2>

            @forelse ($about_us->missions as $mission)
                <div>
                    <p class="fw-bold">{{ $mission->title }}</p>
                    <p class="text-secondary">{{ $mission->description }}</p>
                </div>
            @empty
                <p class="text-secondary">Belum ada misi yang ditambahkan</p>
            @endforelse

        </div>
    </div>

    <!-- Statistics Section -->
    <div class="p-6">
        <div class="row text-center">
            <div class="col-md-3">
                <div class="d-flex flex-column align-items-center">
                    <i class="bi bi-people-fill text-warning" style="font-size: 7rem;"></i>
                    <h3 class="fs-1 fw-bold mb-1">100 +</h3>
                    <p class="text-muted">Siswa Aktif</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="d-flex flex-column align-items-center">
                    <i class="bi bi-mortarboard-fill text-warning" style="font-size: 7rem;"></i>
                    <h3 class="fs-1 fw-bold mb-1">100 +</h3>
                    <p class="text-muted">Lulusan</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="d-flex flex-column align-items-center">
                    <i class="bi bi-collection-play-fill text-warning" style="font-size: 7rem;"></i>
                    <h3 class="fs-1 fw-bold mb-1">20 +</h3>
                    <p class="text-muted">Kursus Gratis</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="d-flex flex-column align-items-center">
                    <i class="bi bi-award-fill text-warning" style="font-size: 7rem;"></i>
                    <h3 class="fs-1 fw-bold mb-1">50 +</h3>
                    <p class="text-muted">Kursus Aktif</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Values Section -->
    <div class="py-6">
        <h2 class="fs-2">Values Kami</h2>
        <p class="mb-5">Kami percaya bahwa pendidikan bukan hanya soal pengetahuan, tapi juga pembentukan karakter.
            Nilai-nilai kami mencerminkan komitmen terhadap integritas, rasa ingin tahu, dan semangat untuk belajar.</p>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 bg-dark text-white border-0">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12" r="10" stroke="#FFC107" stroke-width="2" />
                                <path d="M8 12L10.5 14.5L16 9" stroke="#FFC107" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </div>
                        <h5 class="card-title text-warning mb-3">Make Education Accessible</h5>
                        <p class="card-text text-light">Kami percaya bahwa setiap orang berhak mendapatkan kesempatan
                            untuk belajar, tanpa batasan lokasi, latar belakang atau kondisi ekonomi. Dengan
                            memanfaatkan teknologi, kami menghadirkan pembelajaran yang dapat diakses oleh siapa saja
                            dan kapan saja.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 bg-dark text-white border-0">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M3 3L21 21M9 9V21M15 15V21M9 3V9M15 3V15" stroke="#FFC107" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <h5 class="card-title text-warning mb-3">Learn and Grow</h5>
                        <p class="card-text text-light">Kami menghadirkan ruang belajar yang tidak hanya menambah
                            pengetahuan, tapi juga mendorong perubahan diri, membuka cara pandang baru, dan membentuk
                            karakter yang tangguh.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 bg-dark text-white border-0">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2L2 7V10C2 16 6 20.5 12 22C18 20.5 22 16 22 10V7L12 2Z" stroke="#FFC107"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <h5 class="card-title text-warning mb-3">Empower Through Innovation</h5>
                        <p class="card-text text-light">Melalui pendekatan inovatif dalam pembelajaran, kami
                            menghadirkan pengalaman belajar yang adaptif, interaktif, dan relevan dengan tantangan
                            zaman.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Team Section -->
    <div class="py-6">
        <h2 class="fs-2 text-center mb-5">Tim Kami</h2>
        <div class="row g-4">

            @forelse ($teamMembers as $member)
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="flip-card">
                        <div class="flip-card-inner">
                            <div class="flip-card-front p-3">
                                <img src="{{ $member->photo_path }}" alt="foto {{ $member->nama }}"
                                    class="object-fit-cover w-100 rounded-4" style="aspect-ratio: 1/1;">
                                <div class="team-info p-2 text-center">
                                    <p class="text-white fw-bold mb-0">{{ $member->nama }}</p>
                                    <p class="fw-light text-light mb-0">{{ $member->jabatan }}</p>
                                </div>
                            </div>
                            <div
                                class="flip-card-back p-3 d-flex flex-column justify-content-center align-items-center">
                                <p class="text-center">{{ $member->deskripsi }}</p>
                                <a href="{{ $member->linkedin }}">
                                    <i class="bi bi-linkedin    " style="font-size: 2rem;"></i>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center">Tidak ada anggota tim yang ditemukan.</p>
            @endforelse

        </div>
    </div>

    <div class="py-6">
        <h2 class="mb-5 fw-bold fs-2">Hubungi Kami</h2>
        <!-- form  -->
        <form wire:submit="submitContactUs">
            <!-- input  -->
            <div class="mb-5">
                <label class="form-label fw-bold fs-3" for="name">Nama</label>
                <input wire:model="full_name" class="form-control p-3 rounded-4" type="text" name="name"
                    placeholder="masukkan nama anda" id="name" required />
                @error('full_name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <!-- input  -->
            <div class="mb-5">
                <label class="form-label fw-bold fs-3" for="email">Email </label>
                <input wire:model="email" class="form-control p-3 rounded-4" type="text" name="email"
                    placeholder="masukkan email anda" id="email" required />
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-5">
                <!-- input  -->
                <label class="form-label fw-bold fs-3" for="description">Pesan</label>
                <textarea wire:model="message" placeholder="masukkan pesan anda" id="description" rows="4"
                    class="form-control p-3 rounded-4" required></textarea>
                @error('description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <!-- button  -->
            <div class="text-center">
                <button wire:loading.attr="disabled" class="btn btn-primary mx-auto" type="submit">Kirim
                    pesan</button>
            </div>
        </form>


    </div>
</div>
