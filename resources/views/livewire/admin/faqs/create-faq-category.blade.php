<div wire:ignore.self class="modal fade" id="faqCategoryModal" tabindex="-1" aria-labelledby="faqCategoryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="faqCategoryModalLabel">{{ $formtitle }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Kategori</label>
                        <input wire:model="name" type="text"
                            class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                            <small class="d-block mt-2 text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <div class="form-check form-switch">
                            <input wire:model="is_active" class="form-check-input" type="checkbox" role="switch"
                                id="status">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                @if ($editform)
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button wire:click="update" type="button" class="btn btn-primary">Perbarui</button>
                @else
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button wire:click="save" type="button" class="btn btn-primary">Simpan</button>
                @endif
            </div>
        </div>
    </div>
</div>
