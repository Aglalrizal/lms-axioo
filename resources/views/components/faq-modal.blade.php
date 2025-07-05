<div class="modal fade" id="addFaqModal" tabindex="-1" role="dialog" aria-labelledby="addFaqModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="addFaqModalLabel">Add FAQ</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="faqForm" method="POST" action="{{ route('admin.faq.store') }}">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <input type="hidden" name="faq_id" id="faq_id">

                <div class="modal-body">
                    <!-- Dropdown Kategori -->
                    <div class="mb-3">
                        <label for="faq_category_id" class="form-label">Category</label>
                        <select class="form-select text-dark" id="faq_category_id" name="faq_category_id" required>
                            <option value="" disabled selected>-- Select Category --</option>
                            @foreach ($categories as $category)
                                <option class="text-dark" value="{{ $category->id }}">
                                    {{ Str::title($category->name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Question -->
                    <div class="mb-3">
                        <label for="question" class="form-label">Question</label>
                        <input class="form-control text-dark" type="text" id="question" name="question"
                            placeholder="Enter the question" required>
                    </div>

                    <!-- Answer -->
                    <div class="mb-3">
                        <label for="answer" class="form-label">Answer</label>
                        <textarea class="form-control text-dark" id="answer" name="answer" rows="4" placeholder="Enter the answer"
                            required></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="save-btn" type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
