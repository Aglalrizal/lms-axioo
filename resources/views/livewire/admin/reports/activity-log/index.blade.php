<section class="container-fluid p-4">
    <div class="row">
        <!-- Page Header -->
        <div class="col-lg-12 col-md-12 col-12">
            <div class="border-bottom pb-3 mb-3 d-flex justify-content-between align-items-center">
                <div class="d-flex flex-column gap-1">
                    <h1 class="mb-0 h2 fw-bold">
                        Log Activity
                    </h1>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- card -->
            <div class="card">
                <!-- card header -->
                <div class="card-header">
                    <input wire:model.live="search" class="form-control" placeholder="Search Activity" />
                    <div class="d-flex justify-content-between align-items-center my-3">
                        <div class="d-flex align-items-center gap-2">
                            <div class="col-md-4">
                                <input type="date" id="startDate" class="form-control" wire:model.defer="startDate"
                                    wire:change="$refresh">
                            </div>
                            <div class="col-md-4">
                                <input type="date" id="endDate" class="form-control" wire:model.defer="endDate"
                                    wire:change="$refresh">
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-secondary" wire:click="resetDate">Reset</button>
                            </div>
                        </div>
                        {{-- <div class="d-flex align-items-center gap-2">
                            <select wire:model.lazy="sortBy" class="form-select">
                                <option value="created_at">Waktu</option>
                            </select>

                            <select wire:model.lazy="sortDirection" class="form-select">
                                <option value="asc">Terlama</option>
                                <option value="desc">Terbaru</option>
                            </select>
                        </div> --}}
                    </div>
                </div>
                <!-- table -->
                <div class="table-responsive">
                    <table class="table mb-0 text-nowrap table-hover table-centered">
                        <thead class="table-light">
                            <tr>
                                <th>Waktu</th>
                                <th>User</th>
                                <th>Event</th>
                                <th>Model</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($activities as $log)
                                <tr>
                                    <td>{{ $log->created_at->format('d M Y H:i') }}</td>
                                    <td>{{ $log->causer?->username ?? 'Sistem' }}</td>
                                    <td>
                                        <span
                                            class="badge text-bg-{{ [
                                                'created' => 'success',
                                                'updated' => 'warning',
                                                'deleted' => 'danger',
                                            ][$log->event] ?? 'secondary' }}">
                                            {{ ucfirst($log->event) }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ class_basename($log->subject_type) }} <br>
                                        <small class="text-muted">ID: {{ $log->subject_id }}</small>
                                    </td>
                                    <td>
                                        {{ $log->description }}
                                    </td>
                                    <td>
                                        <button type="button"
                                            wire:click="$dispatch('show-log-detail',{id: {{ $log->id }}})"
                                            class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#detailLogItemModal">
                                            Detail
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Tidak ada aktivitas.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <!-- Pagination -->
                    <div class="card-footer">
                        {{ $activities->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <livewire:admin.reports.activity-log.show-detail />
</section>

<script>
    document.getElementById('detailLogItemModal')
        .addEventListener('hidden.bs.modal', () => Livewire.dispatch('reset-log-detail'));
</script>
