<section class="p-lg-5 py-7">
    <div class="container">
        <!-- Content -->
        <div class="row">
            <div class="col-12">
                <!-- Navigation Back to Course -->
                <div class="mb-4">
                    <a href="{{ route('admin.course.published.show', $course->slug) }}" class="btn btn-light">
                        <i class="bi bi-arrow-left me-2"></i>Kembali ke Detail Kursus
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
                            <a class="nav-link @if ($activeTab === 'students') active @endif"
                                wire:click.prevent="setActiveTab('students')" id="students-tab" data-bs-toggle="pill"
                                href="#students" role="tab" aria-controls="students"
                                aria-selected="true">Peserta</a>
                        </li>
                    </ul>
                </div>
                <!-- Card -->
                <div class="card rounded-3">
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="tab-content" id="tabContent">
                            <!-- Peserta Tab -->
                            <div class="tab-pane fade @if ($activeTab === 'students') show active @endif"
                                id="students" role="tabpanel" aria-labelledby="students-tab">
                                <div class="row mb-5">
                                    <div class="col-12">
                                        <div>
                                            <h1 class="h2 mb-0">
                                                Peserta
                                            </h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-5">
                                    <div class="col-md-6 col-12">
                                        <input type="search" class="form-control" placeholder="Cari berdasarkan nama"
                                            wire:model.live="search" />
                                    </div>
                                </div>

                                <div class="card">
                                    <!-- Table -->
                                    <div class="table-responsive">
                                        <table class="table table-hover table-centered">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Nama</th>
                                                    <th>Status</th>
                                                    <th class="text-center">Tanggal Mengumpulkan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($submissions as $submission)
                                                    <tr>
                                                        <td>
                                                            <a
                                                                href="{{ route('admin.course.published.submission.show', ['slug' => $course->slug, 'assignmentId' => $submission->assignment->id, 'submissionId' => $submission->id]) }}">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="avatar avatar-xs me-2">
                                                                        <img src="{{ $submission->student->profile_picture
                                                                            ? asset('storage/' . $submission->student->profile_picture)
                                                                            : 'https://ui-avatars.com/api/?background=random&name=' . urlencode($submission->student->full_name) }}"
                                                                            alt="{{ $submission->student->username }}-avatar"
                                                                            class="rounded-circle">
                                                                    </div>
                                                                    <div>
                                                                        <h6 class="mb-0">
                                                                            {{ $submission->student->full_name }}
                                                                        </h6>
                                                                        <small
                                                                            class="text-muted">{{ '@' . $submission->student->username }}</small>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            {{ $submission->status_formatted }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $submission->submitted_at->format('d M Y H:i') }}
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center">
                                                            <i class="bi bi-exclamation-triangle"></i>
                                                            @if ($this->search)
                                                                Tidak ada peserta yang sesuai dengan pencarian
                                                            @else
                                                                Belum ada peserta yang mengumpulkan tugas ini
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                    @if ($submissions->hasPages())
                                        <div class="p-3">
                                            {{ $submissions->links() }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
