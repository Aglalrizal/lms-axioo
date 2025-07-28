<div>
    <form wire:submit="saveImage">
        <!-- Card -->
        <div class="card mb-3">
            <div class="card-header border-bottom px-4 py-3">
                <h4 class="mb-0">Gambar Sampul Kursus</h4>
            </div>
            <!-- Card body -->
            <div class="card-body">
                <div class="mb-4">
                    <input type="file" id="courseImage" wire:model="courseImage" class="form-control" accept="image/*">
                    @error('courseImage')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Preview --}}
                @if ($currentImage)
                    <label class="form-label">Gambar saat ini:</label>
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $currentImage) }}" alt="Current"
                            class="img-fluid rounded border img-thumbnail">
                    </div>
                @endif
                @if ($courseImage)
                    <label class="form-label">Pratinjau:</label>
                    <div class="mb-3">
                        <img src="{{ $courseImage->temporaryUrl() }}" alt="Preview"
                            class="img-fluid rounded border img-thumbnail">
                    </div>
                @endif
            </div>
            <!-- Button -->
            <div class="card-footer">
                <x-course-multi-step-nav :step="$step" :slug="$slug" />
            </div>
        </div>
    </form>
</div>
