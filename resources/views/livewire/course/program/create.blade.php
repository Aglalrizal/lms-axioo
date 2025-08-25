<div wire:ignore.self class="modal fade" id="createProgramModal" tabindex="-1" aria-labelledby="createProgramModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="createProgramModalLabel">{{ $formtitle }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form wire:submit="{{ $editform ? 'update' : 'save' }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Program</label>
                        <input wire:model="name" type="text"
                            class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                            <small class="d-block mt-2 text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <input type="file" id="programImage" wire:model="programImage" class="form-control"
                            accept="image/*">
                        @error('programImage')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    @if ($currentImage)
                        <label class="form-label">Gambar saat ini:</label>
                        <div class="mb-3"">
                            <img src="{{ asset('storage/' . $currentImage) }}" alt="Current"
                                class="img-fluid rounded border img-thumbnail">
                        </div>
                    @endif
                    @if ($programImage)
                        <label class="form-label">Pratinjau:</label>
                        <div class="mb-3">
                            <img src="{{ $programImage->temporaryUrl() }}" alt="Preview"
                                class="img-fluid rounded border img-thumbnail">
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
