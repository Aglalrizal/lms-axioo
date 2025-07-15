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
                                <th>Perubahan</th>
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
                                        @php
                                            $old = $log->properties['old'] ?? [];
                                            $new = $log->properties['attributes'] ?? [];
                                        @endphp

                                        @if ($old && $new)
                                            <ul class="list-unstyled small">
                                                @foreach ($new as $key => $value)
                                                    @if (!in_array($key, ['updated_at', 'created_at']) && $old[$key] ?? null !== $value)
                                                        <li>
                                                            <strong>{{ ucfirst(str_replace('_', ' ', $key)) }}</strong>:
                                                            <span class="text-danger">{{ $old[$key] ?? '-' }}</span>
                                                            →
                                                            <span class="text-success">{{ $value }}</span>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        @else
                                            <em class="text-muted">-</em>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Tidak ada aktivitas.</td>
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
</section>
