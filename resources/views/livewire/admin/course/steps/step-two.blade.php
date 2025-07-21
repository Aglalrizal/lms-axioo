<div>
    <form wire:submit="saveImage">
        <!-- Card -->
        <div class="card mb-3">
            <div class="card-header border-bottom px-4 py-3">
                <h4 class="mb-0">Course Media</h4>
            </div>
            <!-- Card body -->
            <div class="card-body">
                <div class="mb-4">
                    <label for="courseImage" class="form-label">Course Image</label>
                    <input type="file" id="courseImage" wire:model="courseImage" class="form-control" accept="image/*">

                    @error('courseImage')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Preview --}}
                @if ($currentImage)
                    <label class="form-label">Current:</label>
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $currentImage) }}" alt="Current"
                            class="img-fluid rounded border img-thumbnail">
                    </div>
                @endif
                @if ($courseImage)
                    <label class="form-label">Preview:</label>
                    <div class="mb-3">
                        <img src="{{ $courseImage->temporaryUrl() }}" alt="Preview"
                            class="img-fluid rounded border img-thumbnail">
                    </div>
                @endif
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
                            <button type="button" class="btn btn-primary"
                                wire:click="$dispatch('back')">Previous</button>
                        @endif
                        <button type="submit" class="btn btn-success" id="save-button">Simpan</button>
                        @if ($slug && $step < 4)
                            <button type="button" class="btn btn-primary" wire:click="$dispatch('next')">Next</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
