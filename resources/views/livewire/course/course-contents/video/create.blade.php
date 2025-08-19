<div>
    <form wire:submit="save">
        <!-- Card -->
        <div class="card mb-3">
            <div class="card-header border-bottom px-4 py-3">
                <h4 class="mb-0">Tambah Video Pembelajaran</h4>
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
                    <label for="video_url" class="form-label">Tautan Video
                    </label>
                    <input id="video_url" wire:model="video_url"
                        class="form-control @error('video_url') is-invalid @enderror" type="text" />
                    @error('video_url')
                        <small class="d-block mt-2 text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="short_description">Deskripsi Singkat
                        <small class="fst-normal">
                            (opsional dan tidak boleh lebih dari 150 karakter) </small>
                    </label>
                    <textarea wire:model="short_description" id="short_description" class="form-control" rows="3"></textarea>
                    @error('short_description')
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

@if (session('success'))
    <script>
        document.addEventListener('livewire:initialized', () => {
            flasher.success('{{ session('success') }}');
        });
    </script>
@endif
