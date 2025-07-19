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
            <table class="table table-bordered table-responsive mt-2">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($previewUsers as $user)
                        <tr class="{{ $user['duplicate'] ? 'bg-red-100' : '' }}">
                            <td>{{ $user['username'] }}</td>
                            <td>{{ $user['email'] }}</td>
                            <td>
                                @if ($user['duplicate'])
                                    <span class="badge bg-danger p-1 ">Duplicate</span>
                                @else
                                    <span class="badge bg-success">OK</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <a href="{{ route('admin.user', ['role' => 'student']) }}" class="mt-2 btn btn-success">
                Back
            </a>
            <button wire:click="import" class="mt-2 btn btn-success" @if (count($previewUsers) == count($duplicates)) disabled @endif>
                Import {{ count($previewUsers) - count($duplicates) }} Users
            </button>

        </div>
    @endif
</div>
