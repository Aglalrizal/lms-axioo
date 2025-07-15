<section class="container-fluid p-4">
    <!-- Card -->
    <div class="card mb-3 border-0">
        <div class="card-header border-bottom px-4 py-3 d-flex justify-content-between align-items-center">
            <h4 class="mb-0 py-2">FAQs</h4>
            <div>
                <!-- Tambah Faq Kategori -->
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#faqCategoryModal">
                    Tambah Kategori
                </button>
                <!-- Tambah Faq item -->
                <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#faqItemModal">Tambah
                    FAQ</button>
            </div>
        </div>
        <!-- Card body -->
        <div class="card-body">
            @forelse ($categories as $category)
                <div class="bg-light rounded p-2 mb-4">
                    <!-- Kategori Header -->
                    <div class="d-flex align-items-center justify-content-between">
                        @if ($category->is_active)
                            <span class="d-inline-block rounded-circle bg-success me-2"
                                style="width: 12px; height: 12px;"></span>
                        @else
                            <span class="d-inline-block rounded-circle bg-secondary me-2"
                                style="width: 12px; height: 12px;"></span>
                        @endif
                        <a href="javascript:void(0)" class="text-dark text-decoration-none flex-grow-1"
                            data-bs-toggle="collapse" data-bs-target="#faq-category-{{ $category->id }}"
                            aria-expanded="false" aria-controls="faq-category-{{ $category->id }}">
                            <h4 class="mb-0 text-truncate text-wrap">
                                {{ Str::title($category->name) }}
                            </h4>
                        </a>

                        <div class="ms-2">
                            <button @click="$dispatch('edit-category-mode',{id:{{ $category->id }}})" type="button"
                                class="me-1 text-inherit btn btn-sm p-1" data-bs-toggle="modal"
                                data-bs-target="#faqCategoryModal"><i class="fe fe-edit fs-6"></i></button>
                            <button wire:click="$dispatch('delete-faq-category',{id: {{ $category->id }}})"
                                class="btn btn-sm text-danger p-1">
                                <i class="fe fe-trash-2 fs-6"></i>
                            </button>
                            <button class="text-inherit btn btn-sm p-1" data-bs-toggle="collapse"
                                data-bs-target="#faq-category-{{ $category->id }}" aria-expanded="false"
                                aria-controls="faq-category-{{ $category->id }}">
                                <span class="chevron-arrow"><i class="fe fe-chevron-down"></i></span>
                            </button>
                        </div>
                    </div>

                    <!-- Daftar FAQ -->
                    <div id="faq-category-{{ $category->id }}" class="collapse mt-3">
                        <div class="list-group list-group-flush border-top-0 faq-sortable"
                            id="faqList-{{ $loop->index }}" data-category-id="{{ $category->id }}">
                            @forelse ($category->faqs->sortBy('order') as $faq)
                                <div class="list-group-item rounded px-3 py-2 mb-1 faq-item"
                                    data-faq-id="{{ $faq->id }}">
                                    <div class="d-flex align-items-center justify-content-between">
                                        @if ($faq->is_active)
                                            <span class="d-inline-block rounded-circle bg-success me-2"
                                                style="width: 12px; height: 12px;"></span>
                                        @else
                                            <span class="d-inline-block rounded-circle bg-secondary me-2"
                                                style="width: 12px; height: 12px;"></span>
                                        @endif
                                        <a href="javascript:void(0)" class="text-dark text-decoration-none flex-grow-1"
                                            data-bs-toggle="collapse" data-bs-target="#faq-{{ $faq->id }}"
                                            aria-expanded="false" aria-controls="faq-{{ $faq->id }}">
                                            <h5 class="mb-0 text-truncate text-wrap">
                                                {{ $faq->question }}
                                            </h5>
                                        </a>
                                        <div class="ms-2">
                                            <button @click="$dispatch('edit-faq-item-mode',{id:{{ $faq->id }}})"
                                                type="button" class="me-1 text-inherit btn btn-sm p-1"
                                                data-bs-toggle="modal" data-bs-target="#faqItemModal"><i
                                                    class="fe fe-edit fs-6"></i></button>
                                            <button wire:click="$dispatch('delete-faq',{id: {{ $faq->id }}})"
                                                class="btn btn-sm text-danger p-1">
                                                <i class="fe fe-trash-2 fs-6"></i>
                                            </button>
                                            <button class="text-inherit btn btn-sm p-1" data-bs-toggle="collapse"
                                                data-bs-target="#faq-{{ $faq->id }}" aria-expanded="false"
                                                aria-controls="faq-{{ $faq->id }}">
                                                <span class="chevron-arrow"><i class="fe fe-chevron-down"></i></span>
                                            </button>

                                        </div>
                                    </div>

                                    <div id="faq-{{ $faq->id }}" class="collapse mt-2"
                                        data-bs-parent="#faqList-{{ $loop->parent->index }}">
                                        <div class="p-2 text-wrap">
                                            <p class="mb-0">{!! nl2br(e($faq->answer)) !!}</p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="list-group-item rounded px-3 py-2 mb-1 faq-item">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h5 class="mb-0 text-truncate text-wrap">
                                            No FAQs found.
                                        </h5>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            @empty
                <div>
                    <h4 class="mb-0 text-wrap">
                        No FAQs found.
                    </h4>
                </div>
            @endforelse
        </div>
    </div>

    <livewire:admin.faqs.create-faq-category />
    <livewire:admin.faqs.create-faqs :key="'faq-form-' . now()->timestamp" lazy />

</section>

<script>
    document.addEventListener('livewire:initialized', () => {
        @this.on('refresh-faqs', (event) => {
            var myFaqItemModalEl = document.querySelector('#faqItemModal')
            var faqItemModal = bootstrap.Modal.getOrCreateInstance(myFaqItemModalEl)
            var myFaqCategoryModalEl = document.querySelector('#faqCategoryModal')
            var faqCategoryModal = bootstrap.Modal.getOrCreateInstance(myFaqCategoryModalEl)


            faqItemModal.hide();
            faqCategoryModal.hide();
            @this.dispatch('reset-faq-item-modal');
            @this.dispatch('reset-category-modal');
        })

        var myFaqItemModalEl = document.getElementById('faqItemModal')
        myFaqItemModalEl.addEventListener('hidden.bs.modal', (event) => {
            @this.dispatch('reset-faq-item-modal');
        })
        var myFaqCategoryModalEl = document.getElementById('faqCategoryModal')
        myFaqCategoryModalEl.addEventListener('hidden.bs.modal', (event) => {
            @this.dispatch('reset-category-modal');
            @this.dispatch('refresh-categories');
        })
    })
</script>
