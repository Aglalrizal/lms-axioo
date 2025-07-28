<div>
    <form wire:submit="save">
        <!-- Card -->
        <div class="card mb-3">
            <div class="card-header border-bottom px-4 py-3">
                <h4 class="mb-0">Tambah Konten</h4>
            </div>
            <!-- Card body -->
            <div class="card-body">
                <div class="mb-3">
                    <label for="addCourseTitle" class="form-label">Judul</label>
                    <input id="addCourseTitle" wire:model="title"
                        class="form-control @error('title') is-invalid @enderror" type="text" autocomplete="off" />
                    @error('title')
                        <small class="d-block mt-2 text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="duration" class="form-label">Durasi <small
                            class="text-muted text-sm">(menit)</small></label>
                    <input id="duration" wire:model="duration"
                        class="form-control @error('duration') is-invalid @enderror" type="number" min="0" />
                    @error('duration')
                        <small class="d-block mt-2 text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <div class="d-flex align-items-center">
                        <label for="is_assessment" class="form-label m-0">Kuis</label>
                        <div class="form-check form-switch ms-2">
                            <input wire:model.live="is_assessment" class="form-check-input" type="checkbox"
                                role="switch" id="is_assessment">
                        </div>
                    </div>
                </div>
                @if (!$is_assessment)
                    <div class="mb-3">
                        <label for="video_url" class="form-label">Tautan Video</label>
                        <input id="video_url" wire:model="video_url"
                            class="form-control @error('video_url') is-invalid @enderror" type="text" />
                        @error('video_url')
                            <small class="d-block mt-2 text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <div class="d-flex align-items-center">
                            <label for="is_free_preview" class="form-label m-0">Gratis Pratinjau</label>
                            <div class="form-check form-switch ms-2">
                                <input wire:model="is_free_preview" class="form-check-input" type="checkbox"
                                    role="switch" id="is_free_preview">
                            </div>
                        </div>
                    </div>
                @endif
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <livewire:jodit-text-editor wire:model="content" />
                    @error('content')
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
    <link rel="stylesheet" href="//unpkg.com/jodit@4.1.16/es2021/jodit.min.css">
    <script src="//unpkg.com/jodit@4.1.16/es2021/jodit.min.js"></script>
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
