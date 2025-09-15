<main>
    <section class="py-8 bg-light">
        <div class="container">
            <div class="row">
                <div class="offset-md-2 col-md-8 col-12">
                    <!-- caption-->
                    <h1 class="fw-bold mb-0 display-4 lh-1">Bantuan</h1>
                </div>
            </div>
        </div>
    </section>
    <!-- container  -->
    <div class="pt-3">
        <div class="container">
            <div class="row">
                <div class="offset-md-2 col-md-8 col-12">
                    <div>
                        <!-- breadcrumb  -->
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="help-center.html">Help Center</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Bantuan</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- container  -->
    <section class="py-8">
        <div class="container my-lg-4">
            <div class="row">
                <div class="offset-md-2 col-md-8 col-12">
                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex flex-column gap-8">
                            <!-- lead  -->
                            <p class="lead mb-0">Tidak dapat menemukan jawaban yang Anda cari? Jangan khawatir! Hubungi
                                tim Dukungan, kami akan dengan senang hati membantu Anda.</p>
                            <div class="d-flex justify-content-between">
                                <span>Informasi Kontak</span>
                                <div class="text-end">
                                    <span>(123) 456 789</span>
                                    <a href="#">contact@geeks.com</a>
                                </div>
                            </div>
                        </div>
                        <div>

                            <!-- card -->
                            <div class="card border">
                                <!-- card body  -->
                                <div class="card-body p-5 d-flex flex-column gap-4">
                                    <h2 class="mb-0 fw-semibold">Kirim Permintaan</h2>
                                    <!-- form  -->
                                    <form wire:submit="submit" class="needs-validation" novalidate>
                                        <!-- input  -->
                                        <div class="mb-3">
                                            <label class="form-label" for="name">Nama Anda</label>
                                            <input wire:model="full_name" class="form-control" type="text"
                                                name="name" placeholder="Nama Anda" id="name" required />
                                            @error('full_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <!-- input  -->
                                        <div class="mb-3">
                                            <label class="form-label" for="email">
                                                Alamat Email
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input wire:model="email" class="form-control" type="text" name="email"
                                                placeholder="Alamat Email" id="email" required />
                                            @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <!-- input  -->
                                        <div class="mb-3">
                                            <label class="form-label" for="title">Judul</label>
                                            <input wire:model="title" class="form-control" type="text" name="title"
                                                placeholder="Judul di sini" id="title" required />
                                            @error('title')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <!-- select options  -->
                                        <div class="mb-3">
                                            <label class="form-label" for="selectSubject">Subjek</label>
                                            <select wire:model="subject" class="form-select" id="selectSubject"
                                                required>
                                                <option selected value="">Pilih</option>
                                                <option value="General">Umum</option>
                                                <option value="Technical">Teknis</option>
                                                <option value="Accounts">Akun</option>
                                                <option value="Payment">Pembayaran</option>
                                                <option value="Other">Lainnya</option>
                                            </select>
                                            @error('subject')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <!-- input  -->
                                            <label class="form-label" for="description">Deskripsi</label>
                                            <textarea wire:model="description" placeholder="Tulis di sini" id="description" rows="2" class="form-control"
                                                required></textarea>
                                            @error('description')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <!-- button  -->
                                        <button wire:loading.attr="disabled" class="btn btn-primary"
                                            type="submit">Kirim</button>
                                    </form>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@script
    <script src={{ asset('assets/js/vendors/validation.js') }}></script>
    <script src={{ asset('assets/libs/choices.js/public/assets/scripts/choices.min.js') }}></script>
    <script src={{ asset('assets/js/vendors/choice.js') }}></script>
@endscript
