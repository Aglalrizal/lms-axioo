<div>
    <form wire:submit="save">
        <!-- Card -->
        <div class="card mb-3">
            <div class="card-header border-bottom px-4 py-3">
                <h4 class="mb-0">Tambah Assignment</h4>
            </div>
            <!-- Card body -->
            <div class="card-body">
                <div class="mb-3">
                    <label for="title" class="form-label">Judul</label>
                    <input id="title" wire:model="title" class="form-control @error('title') is-invalid @enderror"
                        type="text" autocomplete="off" />
                    @error('title')
                        <small class="d-block mt-2 text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Instruksi</label>
                    <livewire:jodit-text-editor wire:model="instruction" />
                    @error('instruction')
                        <small class="d-block mt-2 text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <!-- Card footer -->
            <div class="card-footer text-end">
                <button type="button" wire:click='close' class="btn btn-outline-dark">Kembali</button>
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
        </div>
    </form>
</div>

@assets
    <link rel="stylesheet" href="{{ asset('assets/css/jodit.css') }}">
    <script src="{{ asset('assets/js/jodit.js') }}"></script>
    <style>
        .jodit-wysiwyg pre {
            background-color: #1f2937;
            color: #ffffff;
            padding: 1rem;
            border-radius: 0.5rem;
            max-width: 100%;
            overflow-wrap: break-word;
            white-space: pre-wrap;
            word-break: break-word;
        }

        .jodit-wysiwyg code {
            font-size: 0.875rem;
        }

        .jodit-wysiwyg blockquote {
            border-left: 4px solid #9ca3af;
            padding-left: 1rem;
            font-style: italic;
            color: #4b5563;
        }
    </style>
@endassets

@if (session('succes'))
    <script>
        document.addEventListener('livewire:initialized', () => {
            flasher.success('{{ session('success') }}');
        });
    </script>
@endif
