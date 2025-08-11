<div>
    <form wire:submit="save">
        <!-- Card -->
        <div class="card mb-3">
            <div class="card-header border-bottom px-4 py-3">
                <h4 class="mb-0">Lain-Lain</h4>
            </div>
            <!-- Card body -->
            <div class="card-body">
                <div class="mb-3">
                    <label for="extra_description" class="form-label">Deskripsi Tambahan:</label>
                    <livewire:jodit-text-editor wire:model="extra_description" />
                    <small> Deskripsi tambahan berguna untuk memberikan informasi penting seperti alat yang dibutuhkan,
                        prasyarat mengikuti kursus, atau hal-hal teknis lainnya yang perlu diketahui peserta sebelum
                        mulai belajar.</small>
                    @error('title')
                        <small class="d-block mt-2 text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <div class="d-flex align-items-center">
                        <label for="publish" class="form-label m-0">Publikasi</label>
                        <div class="form-check form-switch ms-2">
                            <input wire:model="is_published" class="form-check-input" type="checkbox" role="switch"
                                id="publish" disabled>
                        </div>
                    </div>
                    <small>Kursus hanya bisa dipublikasikan jika setiap silabus memiliki setidaknya satu kuis atau
                        tugas, serta terdapat kuis atau tugas final.</small>
                </div>
            </div>
        </div>
        <!-- Button -->
        <div class="card-footer">
            <x-course-multi-step-nav :step="$step" :slug="$slug" />
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
