<div wire:ignore.self class="modal fade" id="courseSyllabusModal" tabindex="-1" aria-labelledby="courseSyllabusModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="courseSyllabusModalLabel">{{ $formtitle }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form wire:submit="{{ $editform ? 'update' : 'save' }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Syllabus</label>
                        <input wire:model="title" type="text"
                            class="form-control @error('title') is-invalid @enderror">
                        @error('title')
                            <small class="d-block mt-2 text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
