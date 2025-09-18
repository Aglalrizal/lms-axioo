<section class="p-lg-5 py-7">
    <div class="container">
        <!-- Content -->
        <div class="row">
            <div class="col-12">
                <!-- Navigation Back to Course -->
                <div class="mb-4">
                    <a href="{{ route('admin.course.published.submission.index', ['slug' => $course->slug, 'assignmentId' => $assignment->id]) }}"
                        class="btn btn-light">
                        <i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar Tugas
                    </a>
                </div>

                <!-- Card -->
                <div class="card mb-5">
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h1 class="fw-semibold p-0 m-0">
                                <small class="text-muted">{{ $assignment->courseContent->title }}</small>
                            </h1>
                        </div>
                    </div>

                    <ul class="nav nav-lt-tab" id="tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link @if ($activeTab === 'instructions') active @endif"
                                wire:click.prevent="setActiveTab('instructions')" id="instructions-tab"
                                data-bs-toggle="pill" href="#instructions" role="tab" aria-controls="instructions"
                                aria-selected="false">Instruksi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if ($activeTab === 'submission') active @endif"
                                wire:click.prevent="setActiveTab('submission')" id="submission-tab"
                                data-bs-toggle="pill" href="#submission" role="tab" aria-controls="submission"
                                aria-selected="false">Tugas yang dikumpulkan</a>
                        </li>
                    </ul>
                </div>
                <!-- Card -->
                <div class="card rounded-3">
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="tab-content" id="tabContent">
                            <!-- Peserta Tab -->
                            <div class="tab-pane fade @if ($activeTab === 'instructions') show active @endif"
                                id="instructions" role="tabpanel" aria-labelledby="instructions-tab">
                                <div class="row mb-5">
                                    <div class="col-12">
                                        <div>
                                            <h1 class="h2 mb-0">
                                                Instruksi
                                            </h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="py-1">
                                    <div class="container">
                                        @if ($assignment->courseContent->assignment->url)
                                            <div class="my-2">
                                                Tautan Dokumen: <a
                                                    href="{{ $assignment->courseContent->assignment->url }}"
                                                    target="_blank" rel="noopener noreferrer">Tautan</a>
                                            </div>
                                        @endif
                                        @if ($assignment->courseContent->assignment->file_path)
                                            <div class="my-2">Dokumen: <a class="btn btn-info py-1 px-2"
                                                    href="{{ Storage::url($assignment->courseContent->assignment->file_path) }}">Unduh</a>
                                            </div>
                                        @endif
                                        {!! $assignment->courseContent->assignment->instruction !!}
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade @if ($activeTab === 'submission') show active @endif"
                                id="submission" role="tabpanel" aria-labelledby="submission-tab">
                                <div class="row mb-5">
                                    <div class="col-12">
                                        <div class="card mt-2">
                                            <div class="card-header">
                                                <h3 class="mb-0">Tugas yang dikumpulkan</h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <p>Dikumpulkan pada:
                                                        {{ $submission->created_at->format('d M Y H:i') }}
                                                    </p>
                                                </div>
                                                <div class="mb-3">
                                                    <p>Url:
                                                        @if ($submission->url)
                                                            <a href="{{ $submission->url }}" target="_blank"
                                                                rel="noopener noreferrer"> tautan</a>
                                                        @else
                                                            -
                                                        @endif
                                                    </p>
                                                </div>
                                                <div class="mb-3">
                                                    <p>Dokumen:
                                                        @if ($submission->file_path)
                                                            <a href="{{ Storage::url($submission->file_path) }}"
                                                                class="link-underline-primary">Dokumen</a>
                                                        @else
                                                            Tidak ada dokumen yang diunggah
                                                        @endif
                                                    </p>
                                                </div>
                                                <div class="mb-3">
                                                    <p>Jawaban:
                                                        {{ $submission->text_answer ?? '-' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <form wire:submit="save">
                                            <div class="card mt-2">
                                                <div class="card-header">
                                                    <h3 class="mb-0">Penilaian</h3>
                                                </div>
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <label for="feedback" class="form-label">Umpanbalik: </label>
                                                        <textarea wire:model="feedback" id="feedback" class="form-control" rows="4"></textarea>
                                                        @error('feedback')
                                                            <small
                                                                class="d-block mt-2 text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <select wire:model="grade" id="grade"
                                                            class="form-select text-dark">
                                                            <option value="" disabled>Pilih</option>
                                                            <option value="accept">Lulus</option>
                                                            <option value="reject">Tidak Lulus</option>
                                                        </select>
                                                        <small class="form-text">Bila tidak lulus maka peserta tidak
                                                            akan
                                                            bisa lanjut ke materi berikutnya dan harus mengunggah
                                                            kembali
                                                            jawabannya.</small>
                                                        @error('grade')
                                                            <small
                                                                class="d-block mt-2 text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="card-footer text-end">
                                                    <button type="submit" class="btn btn-success ">Simpan</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
