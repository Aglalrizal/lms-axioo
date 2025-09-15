<div>
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid px-0 justify-content-start" style="padding: 3.5px 0">
            <a class="navbar-brand" href="{{ route('user.dashboard.courses') }}"><i
                    class="bi bi-arrow-left fw-bold text-dark"></i></a>
            <h2 class="mb-0">{{ $content->title }}</h2>
        </div>
    </nav>
    <main>
        <section class="course-container position-relative">
            <div class="container-fluid pt-6">
                <div class="row pt-6">
                    <div class="col-12">
                        <div class="content d-flex flex-column min-vh-100" id="course-tabContent">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center mb-2">
                                    <div>
                                        <h3 class="mb-0">{{ $content->title }}</h3>
                                    </div>
                                </div>
                                <!-- Video -->
                                @if ($content->video)
                                    <div class="embed-responsive position-relative w-100 d-block overflow-hidden p-0"
                                        style="height: 600px">
                                        <iframe class="position-absolute top-0 start-0 end-0 bottom-0 h-100 w-100"
                                            width="560" height="315" src="{{ $content->video->video_url }}"
                                            title="{{ $content->title }}" frameborder="0"></iframe>
                                    </div>
                                @elseif($content->article)
                                    {!! $content->article->body !!}
                                @elseif($content->quiz)
                                    <div>
                                        <p>
                                            Saatnya untuk menguji pengetahuan Anda tentang materi yang telah
                                            dipelajari. Terdapat {{ $content->quiz->number_of_questions }} pertanyaan
                                            yang
                                            harus dikerjakan dalam ujian ini.
                                            Beberapa ketentuan dari ujian ini adalah:
                                        </p>
                                        <ul>
                                            <li>
                                                Syarat nilai kelulusan : 75%
                                            </li>
                                            <li>
                                                Durasi ujian : {{ $content->quiz->duration }} menit
                                            </li>
                                        </ul>
                                        <p>
                                            Apabila tidak memenuhi syarat kelulusan, maka Anda harus menunggu selama 1
                                            menit
                                            untuk mengulang pengerjaan ujian kembali.
                                            Selamat Mengerjakan!
                                        </p>
                                    </div>
                                    @if ($data->count() > 0)
                                        <div>
                                            <h4>Riwayat Pengerjaan</h4>
                                            <table class="table table-responsive align-middle text-center">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Waktu dan Tanggal Pengerjaan</th>
                                                    <th>Persentase</th>
                                                    <th>Keterangan</th>
                                                    <th>Aksi</th>
                                                </tr>
                                                @foreach ($data as $a)
                                                    <tr>
                                                        <th>{{ $loop->iteration }}</th>
                                                        <th>{{ $a->end_time->format('d M Y H:i') }}</th>
                                                        <th>{{ $a->percentage }}%</th>
                                                        @if ($a->percentage >= 75)
                                                            <th>
                                                                <span class="alert alert-success py-2 px-3">Lulus</span>
                                                            </th>
                                                        @else
                                                            <th><span class="alert alert-danger py-2 px-3">Tidak
                                                                    Lulus</span>
                                                            </th>
                                                        @endif
                                                        <th><a class="btn btn-info">Detail</a></th>
                                                    </tr>
                                                @endforeach
                                            </table>
                                            {{ $data->links() }}
                                        </div>
                                    @endif
                                    <div class="d-flex justify-content-end">
                                        <a wire:click="playQuiz" class="btn btn-info">Mulai</a>
                                    </div>
                                @else
                                    <div>
                                        <ul class="nav nav-line-bottom mb-3" id="pills-tab-accordion-flush"
                                            role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link active" id="pills-accordion-flush-instruction-tab"
                                                    data-bs-toggle="pill" href="#pills-accordion-flush-instruction"
                                                    role="tab" aria-controls="pills-accordion-flush-instruction"
                                                    aria-selected="false" tabindex="-1">
                                                    Intruksi
                                                </a>
                                            </li>
                                            @if (!$submission)
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link" id="pills-accordion-flush-submission-form-tab"
                                                        data-bs-toggle="pill"
                                                        href="#pills-accordion-flush-submission-form" role="tab"
                                                        aria-controls="pills-accordion-flush-submission-form"
                                                        aria-selected="true">
                                                        Pengumpulan
                                                    </a>
                                                </li>
                                            @else
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link" id="pills-accordion-flush-submission-tab"
                                                        data-bs-toggle="pill" href="#pills-accordion-flush-submission"
                                                        role="tab" aria-controls="pills-accordion-flush-submission"
                                                        aria-selected="true">
                                                        Tugas Dikumpulkan
                                                    </a>
                                                </li>
                                            @endif
                                        </ul>
                                        <!-- Tab content -->
                                        <div class="tab-content" id="pills-tabContent-accordion-flush">
                                            <div class="tab-pane fade active show"
                                                id="pills-accordion-flush-instruction" role="tabpanel"
                                                aria-labelledby="pills-accordion-flush-instruction-tab">
                                                <div class="py-2">
                                                    <div class="container">
                                                        @if ($content->assignment->url)
                                                            <div class="my-2">
                                                                Tautan Dokumen: <a
                                                                    href="{{ $content->assignment->url }}"
                                                                    target="_blank" rel="noopener noreferrer">Tautan</a>
                                                            </div>
                                                        @endif
                                                        @if ($content->assignment->file_path)
                                                            <div class="my-2">Dokumen: <a
                                                                    class="btn btn-info py-1 px-2"
                                                                    wire:click="downloadFile">Unduh</a>
                                                            </div>
                                                        @endif
                                                        {!! $content->assignment->instruction !!}
                                                    </div>
                                                </div>
                                            </div>
                                            @if (!$submission)
                                                <div class="tab-pane fade" id="pills-accordion-flush-submission-form"
                                                    role="tabpanel"
                                                    aria-labelledby="pills-accordion-flush-submission-form-tab">
                                                    <div class="py-2">
                                                        <form wire:submit='save'>
                                                            <div class="card">
                                                                <div class="card-header text-center">
                                                                    <h4 class="m-0">Pengumpulan Tugas</h4>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="mb-3">
                                                                        <label for="file"
                                                                            class="form-label">Dokumen</label>
                                                                        <input type="file" class="form-control"
                                                                            wire:model="file">
                                                                        @error('file')
                                                                            <small
                                                                                class="d-block mt-2 text-danger">{{ $message }}</small>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="url" class="form-label">Tautan
                                                                        </label>
                                                                        <input id="url" wire:model="url"
                                                                            class="form-control @error('url') is-invalid @enderror"
                                                                            type="text" />
                                                                        @error('url')
                                                                            <small
                                                                                class="d-block mt-2 text-danger">{{ $message }}</small>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="form-label"
                                                                            for="textAnswer">Jawaban
                                                                        </label>
                                                                        <textarea wire:model="textAnswer" id="textAnswer" class="form-control" rows="5"></textarea>
                                                                        @error('textAnswer')
                                                                            <small
                                                                                class="d-block mt-2 text-danger">{{ $message }}</small>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="card-footer text-end">
                                                                    <button type="submit"
                                                                        class="btn btn-success">Kirim</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="tab-pane fade" id="pills-accordion-flush-submission"
                                                    role="tabpanel"
                                                    aria-labelledby="pills-accordion-flush-submission-tab">
                                                    <div class="py-2">
                                                        <div class="container">
                                                            <div class="card">
                                                                <div class="card-header text-center">
                                                                    <h4 class="m-0">Tugas Dikumpulkan</h4>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="mb-3">
                                                                        <p>Dikumpulkan pada:
                                                                            {{ $submission->created_at->format('d M Y H:i') }}
                                                                        </p>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <p>Dokumen:
                                                                            @if ($submission->file_path)
                                                                                <a wire:click="downloadMyFile"
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
                                                                <div class="card-footer text-end">
                                                                    <button type="button"
                                                                        wire:click="confirmDeleteSubmission"
                                                                        class="btn btn-danger">Hapus</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="py-3 text-center mt-3 d-flex justify-content-end border-top">
                                @if ($prevContent)
                                    <a href="{{ route('course.show.content', [$course->slug, $prevContent->courseSyllabus->id, $prevContent->id]) }}"
                                        class="btn btn-secondary me-2">
                                        Sebelumnya
                                    </a>
                                @endif
                                @if (in_array($content->type, ['article', 'video']) &&
                                        !$content->progresses()->where('student_id', Auth::id())->where('is_completed', true)->exists())
                                    <a wire:click="markComplete" class="btn btn-success mx-2">
                                        Tandai selesai
                                    </a>
                                @endif

                                @if ($nextContent)
                                    <a @if ($nextContent->is_unlocked) href="{{ route('course.show.content', [$course->slug, $nextContent->courseSyllabus->id, $nextContent->id]) }}" @endif
                                        class="ms-2 btn btn-secondary {{ !$nextContent->is_unlocked ? 'disabled' : '' }}">
                                        Selanjutnya
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Card -->
        <section class="card course-sidebar" id="courseAccordion">
            <!-- List group -->
            <ul class="list-group list-group-flush overflow-hidden" style="height: 850px" data-simplebar="init">
                <div class="simplebar-wrapper" style="margin: 0px;">
                    <div class="simplebar-height-auto-observer-wrapper">
                        <div class="simplebar-height-auto-observer"></div>
                    </div>
                    <div class="simplebar-mask">
                        <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                            <div class="simplebar-content-wrapper" tabindex="0" role="region"
                                aria-label="scrollable content" style="height: 100%; overflow: hidden;">
                                <div class="simplebar-content" style="padding: 0px;">
                                    <li class="list-group-item">
                                        <h4 class="mb-0">Daftar Isi</h4>
                                    </li>
                                    <!-- List group item -->
                                    @foreach ($course->syllabus as $syllabus)
                                        <li class="list-group-item">
                                            <!-- Toggle -->
                                            <a class="d-flex align-items-center h4 mb-0" data-bs-toggle="collapse"
                                                href="#syllabus-{{ $syllabus->id }}" role="button"
                                                aria-expanded="false" aria-controls="syllabus-{{ $syllabus->id }}">
                                                <div class="me-auto">{{ $syllabus->title }}</div>
                                                <!-- Chevron -->
                                                <span class="chevron-arrow ms-4">
                                                    <i class="fe fe-chevron-down fs-4"></i>
                                                </span>
                                            </a>
                                            <!-- Row -->
                                            <!-- Collapse -->
                                            <div class="collapse @if ($content->courseSyllabus->id == $syllabus->id) show @endif"
                                                id="syllabus-{{ $syllabus->id }}" data-bs-parent="#courseAccordion">
                                                <div class="pt-4 nav" role="tablist" aria-orientation="vertical">
                                                    @foreach ($syllabus->courseContents as $c)
                                                        <a @if ($c->is_unlocked) href="{{ route('course.show.content', ['slug' => $course->slug, 'syllabusId' => $syllabus->id, 'courseContentId' => $c->id]) }}"
                                                            wire:navigate @endif
                                                            class="mb-2 d-flex align-items-center border-bottom w-100 pb-2 
                                                            @if (!$c->is_unlocked) text-dark @endif">
                                                            <div class="d-flex">
                                                                <div class="d-flex align-items-center">
                                                                    <span
                                                                        class="icon-shape bg-light text-primary icon-md rounded-circle me-2"
                                                                        data-bs-toggle="tooltip"
                                                                        data-bs-placement="top"
                                                                        data-bs-title="{{ Str::title($c->type) }}">
                                                                        <i
                                                                            class="bi
                                                                {{ $c->is_unlocked ? $c->icon : 'bi-lock-fill' }}">
                                                                        </i>
                                                                    </span>
                                                                </div>
                                                                <div
                                                                    class="text-wrap m-auto @if ($content->id == $c->id) fw-bold @endif">
                                                                    {{ $c->title }}
                                                                </div>
                                                            </div>
                                                        </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="simplebar-placeholder" style="width: 378px; height: 691px;"></div>
                </div>
                <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                    <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
                </div>
                <div class="simplebar-track simplebar-vertical" style="visibility: hidden;">
                    <div class="simplebar-scrollbar" style="height: 0px; display: none;"></div>
                </div>
            </ul>
        </section>
    </main>
</div>
