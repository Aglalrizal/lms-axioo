<section class="container-fluid p-4">
    <!-- Card -->
    <div class="card mb-3 border-0">
        <div class="card-header border-bottom px-4 py-3 d-flex justify-content-between align-items-center">
            <h4 class="mb-0 py-2">FAQs</h4>
            <div>
                <!-- Tambah Faq Kategori -->
                {{-- <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addFaqCategoryModal">
                        Add Faq Category
                    </button> --}}
                <!-- Tambah Faq item -->
                <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#faqItemModal">Add
                    FAQ</button>
            </div>
        </div>
        <!-- Card body -->
        <div class="card-body">
            @foreach ($categories as $category)
                <div class="bg-light rounded p-2 mb-4">
                    <!-- Kategori Header -->
                    <div class="d-flex align-items-center justify-content-between">
                        <a href="javascript:void(0)" class="text-dark text-decoration-none flex-grow-1"
                            data-bs-toggle="collapse" data-bs-target="#faq-category-{{ $category->id }}"
                            aria-expanded="false" aria-controls="faq-category-{{ $category->id }}">
                            <h4 class="mb-0 text-truncate text-wrap">
                                {{ Str::title($category->name) }}
                            </h4>
                        </a>

                        <div class="ms-2">
                            <button class="me-1 text-inherit btn btn-sm p-1" data-faq='@json($category)'
                                onclick="openEditModal(this)" title="Edit">
                                <i class="fe fe-edit fs-6"></i>
                            </button>
                            <form action="#" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm text-danger p-1"
                                    onclick="return confirm('Are you sure?')">
                                    <i class="fe fe-trash-2 fs-6"></i>
                                </button>
                            </form>
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
                            @foreach ($category->faqs->sortBy('order') as $faq)
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
                                            {{-- <button class="me-1 text-inherit btn btn-sm p-1"
                                                data-faq='@json($category)' onclick="openEditModal(this)"
                                                title="Edit">
                                                <i class="fe fe-edit fs-6"></i>
                                            </button> --}}
                                            <button @click="$dispatch('edit-mode',{id:{{ $faq->id }}})"
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
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <livewire:admin.faqs.create-faqs />

</section>

<script>
    document.addEventListener('livewire:initialized', () => {
        @this.on('refresh-faqs', (event) => {
            var myModalEl = document.querySelector('#faqItemModal')
            var modal = bootstrap.Modal.getOrCreateInstance(myModalEl)


            modal.hide();
            @this.dispatch('reset-modal');
        })

        var mymodal = document.getElementById('faqItemModal')
        mymodal.addEventListener('hidden.bs.modal', (event) => {
            @this.dispatch('reset-modal');
        })
    })
</script>
