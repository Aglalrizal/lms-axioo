<section class="container-fluid p-4">
    <!-- Card -->
    <div class="card mb-3 border-0">
        <div class="card-header border-bottom px-4 py-3 d-flex justify-content-between align-items-center">
            <h4 class="mb-0 py-2">FAQs</h4>
            <div>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#faqCategoryModal">
                    Tambah Kategori
                </button>
                <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#faqItemModal">
                    Tambah FAQ
                </button>
            </div>
        </div>

        <!-- Card body -->
        <div class="card-body" wire:sortable="updateCategoryFaqOrder" wire:sortable-group="updateFaqOrder"
            wire:sortable-group.options="{ animation: 150 }" wire.sortable.options="{ animation:150 }">
            @forelse ($categories as $category)
                <!-- CATEGORY ITEM -->
                <div class="bg-light rounded p-2 mb-4" wire:sortable.item="{{ $category->id }}"
                    wire:key="category-{{ $category->id }}">

                    <!-- CATEGORY HEADER -->
                    <div class="d-flex align-items-center justify-content-between" wire:sortable-group.handle>
                        <button class="btn btn-sm p-1 me-2">
                            <i class="bi bi-list"></i>
                        </button>

                        <span class="{{ $category->is_active ? 'bg-success' : 'bg-secondary' }} rounded-circle me-2"
                            style="width:12px;height:12px;"></span>

                        <a class="text-dark text-decoration-none flex-grow-1" data-bs-toggle="collapse"
                            data-bs-target="#faq-category-{{ $category->id }}" aria-expanded="false"
                            aria-controls="faq-category-{{ $category->id }}">
                            <h4 class="mb-0 text-truncate">{{ $category->name }}</h4>
                        </a>

                        <div class="ms-2">
                            <button wire:click="$dispatch('edit-category-mode',{id:{{ $category->id }}})" type="button"
                                class="me-1 btn btn-sm p-1" data-bs-toggle="modal" data-bs-target="#faqCategoryModal">
                                <i class="fe fe-edit fs-6"></i>
                            </button>
                            <button wire:click="$dispatch('delete-faq-category',{id: {{ $category->id }}})"
                                class="btn btn-sm text-danger p-1">
                                <i class="fe fe-trash-2 fs-6"></i>
                            </button>
                        </div>
                    </div>

                    <!-- FAQ ITEMS -->
                    <div id="faq-category-{{ $category->id }}" class="collapse mt-3 show">
                        <div wire:sortable-group.item-group="{{ $category->id }}"
                            wire:sortable-group.options="{ animation: 150 }">
                            @forelse ($category->faqs->sortBy('order') as $faq)
                                <div class="list-group-item rounded px-3 py-2 mb-1"
                                    wire:sortable-group.item="{{ $faq->id }}" wire:key="faq-{{ $faq->id }}">

                                    <div class="d-flex align-items-center justify-content-between"
                                        wire:sortable-group.handle>
                                        <button class="btn btn-sm p-1 me-2">
                                            <i class="bi bi-list"></i>
                                        </button>

                                        <span
                                            class="{{ $faq->is_active ? 'bg-success' : 'bg-secondary' }} rounded-circle me-2"
                                            style="width:12px;height:12px;"></span>

                                        <a class="text-dark text-decoration-none flex-grow-1" data-bs-toggle="collapse"
                                            data-bs-target="#faq-{{ $faq->id }}" aria-expanded="false"
                                            aria-controls="faq-{{ $faq->id }}">
                                            <h5 class="mb-0 text-truncate">{{ $faq->question }}</h5>
                                        </a>

                                        <div class="ms-2">
                                            <button
                                                wire:click="$dispatch('edit-faq-item-mode',{id:{{ $faq->id }}})"
                                                type="button" class="me-1 btn btn-sm p-1" data-bs-toggle="modal"
                                                data-bs-target="#faqItemModal">
                                                <i class="fe fe-edit fs-6"></i>
                                            </button>
                                            <button wire:click="$dispatch('delete-faq',{id: {{ $faq->id }}})"
                                                class="btn btn-sm text-danger p-1">
                                                <i class="fe fe-trash-2 fs-6"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div id="faq-{{ $faq->id }}" class="collapse mt-2">
                                        <div class="p-2 text-wrap">
                                            <p class="mb-0">{!! nl2br(e($faq->answer)) !!}</p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="list-group-item rounded px-3 py-2 mb-1">
                                    <h5 class="mb-0 text-truncate">No FAQs found.</h5>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            @empty
                <h4 class="mb-0 text-wrap">No FAQs found.</h4>
            @endforelse
        </div>
    </div>

    <livewire:admin.faqs.create-faq-category />
    <livewire:admin.faqs.create-faqs :key="'faq-form-' . now()->timestamp" />
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
