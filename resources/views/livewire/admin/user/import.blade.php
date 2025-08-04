<div class="container py-5">
    <h2 class="mb-3">Import Students</h2>

    <div class="my-2">
        <button type="button" wire:click="downloadTemplate" class="btn btn-info"><i
                class="bi bi-download me-2"></i>Download
            Template</button>
    </div>

    <div class="mb-2">
        <input type="file" wire:model="file" class="form-control">
        @error('file')
            <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
    </div>

    <button wire:click="previewImport" class="btn btn-primary">Preview</button>

    @if ($previewUsers)
        <div class="mt-5">
            <h3 class="text-lg font-bold mb-2">Preview Data</h3>
            <small>
                Rows with <span class="badge bg-danger">Duplicated</span> status won't be imported.
            </small>
            <div class="table-responsive mt-3">
                @if (count($previewUsers) > 0)
                    <table class="table table-bordered table-sm">
                        <thead class="table-light text-nowrap">
                            <tr class="text-capitalize text-nowrap">
                                @foreach (array_keys($previewUsers[0]) as $key)
                                    @if ($key === 'duplicate')
                                        @continue
                                    @else
                                        <th class="text-capitalize text-nowrap"">
                                            {{ str_replace('_', ' ', $key) }}</th>
                                    @endif
                                @endforeach
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($previewUsers as $user)
                                <tr class="{{ $user['duplicate'] ?? false ? 'table-danger' : '' }}">
                                    @foreach ($user as $key => $value)
                                        @if ($key === 'duplicate')
                                            @continue
                                        @else
                                            <td>{{ $value }}</td>
                                        @endif
                                    @endforeach
                                    <td>
                                        @if ($user['duplicate'] ?? false)
                                            <span class="badge bg-danger">Duplicate</span>
                                        @else
                                            <span class="badge bg-success">OK</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-info">Tidak ada data untuk ditampilkan.</div>
                @endif
            </div>
            <a href="{{ route('admin.user', ['role' => 'student']) }}" class="mt-2 btn btn-secondary">
                Back
            </a>
            <button wire:click="import" class="mt-2 btn btn-success" @if (count($previewUsers) == count($duplicates)) disabled @endif>
                Import {{ count($previewUsers) - count($duplicates) }} Users
            </button>

        </div>
    @endif
</div>
