<div>
    <form wire:submit="save">
        <!-- Card -->
        <div class="card mb-3">
            <div class="card-header border-bottom px-4 py-3">
                <h4 class="mb-0">Extras</h4>
            </div>
            <!-- Card body -->
            <div class="card-body">
                <div class="mb-3">
                    <label for="extra_description" class="form-label">Extra Description:</label>
                    <livewire:jodit-text-editor wire:model="extra_description" />
                    <small>Extra description is used to describe tool for course, requirement, etc.</small>
                    @error('title')
                        <small class="d-block mt-2 text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="publish" class="form-label">Publish</label>
                    <div class="form-check form-switch">
                        <input wire:model="is_published" class="form-check-input" type="checkbox" role="switch"
                            id="publish" disabled>
                    </div>
                    <small>Only can be activated when course have assignment.</small>
                </div>
            </div>
        </div>
        <!-- Button -->
        <div class="card-footer">
            <div class="d-flex justify-content-between">
                <div>
                    <a href="{{ route('admin.course.all') }}" type="button" class="btn btn-secondary">Back to all
                        courses</a>
                </div>
                <div>
                    @if ($step > 1)
                        <button type="button" class="btn btn-primary" wire:click="$dispatch('back')">Previous</button>
                    @endif
                    <button type="submit" class="btn btn-success" id="save-button">Simpan</button>
                    @if ($slug && $step < 4)
                        <button type="button" class="btn btn-primary" wire:click="$dispatch('next')">Next</button>
                    @endif
                </div>
            </div>
        </div>
    </form>
</div>

@assets
    <link rel="stylesheet" href="//unpkg.com/jodit@4.1.16/es2021/jodit.min.css">
    <script src="//unpkg.com/jodit@4.1.16/es2021/jodit.min.js"></script>
@endassets
