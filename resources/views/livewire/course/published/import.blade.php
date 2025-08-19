<div class="container py-5">
    <h2 class="mb-3">Daftarkan Peserta dengan import data</h2>

    <div class="my-2">
        <button type="button" wire:click="downloadTemplate" class="btn btn-info"><i class="bi bi-download me-2"></i>Unduh
            Template</button>
    </div>

    <div class="mb-2">
        <input type="file" wire:model="file" class="form-control">
        @error('file')
            <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
    </div>

    @if (!$previewUsers)
        <a href="{{ route('admin.course.published.show', $slug) }}" class="btn btn-secondary">
            Kembali
        </a>
    @endif
    <button wire:click="previewEnrollUser" class="btn btn-primary">Pratinjau</button>

    @if ($previewUsers)
        <div class="mt-5">
            <h3 class="text-lg font-bold mb-2">Pratinjau Data</h3>
            <small>
                Baris dengan status <span class="badge bg-danger">User tidak terdaftar</span> tidak akan didaftarkan.
            </small>
            <div class="table-responsive mt-3">
                @if (count($previewUsers) > 0)
                    <table class="table table-bordered table-sm">
                        <thead class="table-light text-nowrap">
                            <tr class="text-capitalize text-nowrap text-center">
                                @foreach (array_keys($previewUsers[0]) as $key)
                                    <th class="text-capitalize text-nowrap">
                                        {{ str_replace('_', ' ', $key) }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($previewUsers as $user)
                                <tr>
                                    <td>{{ $user['username'] }}</td>
                                    <td class="text-center">
                                        @switch($user['status'])
                                            @case('not_found')
                                                <span class="badge bg-danger">User tidak terdaftar</span>
                                            @break

                                            @case('duplicate')
                                                <span class="badge bg-warning">Duplikat di file</span>
                                            @break

                                            @case('already_enrolled')
                                                <span class="badge bg-danger">User sudah terdaftar</span>
                                            @break

                                            @case('ok')
                                                <span class="badge bg-success">OK</span>
                                            @break
                                        @endswitch
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                @else
                    <div class="alert alert-info">Tidak ada data untuk ditampilkan.</div>
                @endif
            </div>
            <a href="{{ route('admin.course.published.show', $slug) }}" class="mt-2 btn btn-secondary">
                Kembali
            </a>
            @php
                $validCount = collect($previewUsers)->where('status', 'ok')->count();
            @endphp

            <button wire:click="import" class="mt-2 btn btn-success" @if ($validCount === 0) disabled @endif>
                Daftarkan {{ $validCount }} Users
            </button>

        </div>
    @endif
</div>
