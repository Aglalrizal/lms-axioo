<div wire:ignore.self class="modal fade" id="faqItemModal" tabindex="-1" aria-labelledby="faqItemModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="faqItemModalLabel">{{ $formtitle }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3" wire:ignore>
                        <label for="faq_category_id" class="form-label">Category</label>
                        <select class="form-select text-dark" id="faq_category_id" wire:model="faq_category_id"
                            required>
                            <option value="" disabled>-- Select Category --</option>
                            @foreach (\App\Models\FaqCategory::all() as $category)
                                <option class="text-dark" value="{{ $category->id }}">
                                    {{ Str::title($category->name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="question" class="form-label">Title</label>
                        <input wire:model="question" type="text"
                            class="form-control @error('question') is-invalid @enderror">
                        @error('question')
                            <small class="d-block mt-2 text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="answer" class="form-label">Answer</label>
                        <input wire:model="answer" type="text"
                            class="form-control @error('answer') is-invalid @enderror">
                        @error('answer')
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button wire:click="update" type="button" class="btn btn-primary">Update</button>
                @else
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button wire:click="save" type="button" class="btn btn-primary">Save changes</button>
                @endif
            </div>
        </div>
    </div>
</div>
