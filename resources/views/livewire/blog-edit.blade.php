@assets
    <link rel="stylesheet" href={{ asset('assets/libs/flatpickr/dist/flatpickr.min.css') }} />
    <link rel="stylesheet" href={{ asset('assets/libs/quill/dist/quill.snow.css') }} />
    <link rel="stylesheet" href={{ asset('assets/libs/dropzone/dist/dropzone.css') }} />
@endassets

<section class="container-fluid p-4">
    <div class="row">
        <!-- Page header -->
        <div class="col-lg-12 col-md-12 col-12">
            <div
                class="border-bottom pb-3 mb-3 d-flex flex-column flex-md-row gap-3 align-items-md-center justify-content-between">
                <div class="d-flex flex-column gap-1">

                    <h1 class="mb-0 h2 fw-bold">Edit Blog "{{ $blog->title }}"</h1>
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item"><a href="#">CMS</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Post</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('admin.cms.blog.index') }}" class="btn btn-outline-secondary">Back to All Post</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row gy-4">
        <div class="col-xl-9 col-lg-8 col-md-12 col-12">
            <!-- Card -->
            <div class="card border-0">
                <!-- Card header -->
                <div class="card-header">
                    <h4 class="mb-0">Edit Post</h4>
                </div>
                <form wire:submit="save" class="needs-validation" novalidate>
                    <!-- Card body -->
                    <div class="card-body">

                        <label class="form-label ">Thumbnail</label>
                        <div class="d-block ratio ratio-21x9 w-100 w-md-75 w-lg-50 mb-3 border rounded overflow-hidden">
                            @if ($form->photo_path)
                                <img src="{{ asset($form->photo_path) }}" alt="Thumbnail"
                                    class="w-100 h-100 object-fit-cover object-position-center">
                            @else
                                <div class="d-flex justify-content-center align-items-center h-100">
                                    <p class="text-center text-muted m-0 px-2">
                                        <i class="fe fe-image mb-2 d-block fs-2"></i>
                                        Pratinjau akan muncul di sini setelah Anda mengunggah foto.
                                    </p>
                                </div>
                            @endif
                        </div>

                        <p class="mb-2 text-secondary   ">Gambar thumbnail sebaiknya memiliki rasio 21:9 dan berukuran
                            tidak lebih dari 2MB.</p>
                        <input type="file" wire:model="form.photo" id="photo" class="form-control mb-3 d-none">
                        <button type="button" class="btn btn-outline-primary mb-2 d-block"
                            onclick="document.querySelector('#photo').click()">
                            <i class="fe fe-upload me-2"></i>
                            Upload Foto</button>
                        {{-- <div wire:ignore id="my-dropzone" class="dropzone border-dashed rounded-2 min-h-0"></div> --}}
                        @error('form.photo')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                        <!-- Add the "Upload" button -->
                        <div class="mt-4">
                            <!-- Form -->
                            <div class="row">
                                <div class="mb-3 ">
                                    <!-- Title -->
                                    <label for="postTitle" class="form-label">Title</label>
                                    <input wire:model="form.title" type="text" id="postTitle"
                                        class="form-control text-dark" placeholder="Post Title" required />
                                    @error('form.title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- Slug -->
                                <div class="mb-3 ">
                                    <label for="basic-url" class="form-label">Slug</label>
                                    <div class="input-group mb-1">
                                        <span class="input-group-text"
                                            id="basic-addon3">http://lms-axioo.com/blogs/</span>
                                        <input wire:model="form.slug" type="text" class="form-control" id="basic-url"
                                            aria-describedby="basic-addon3" />
                                    </div>
                                    @error('form.slug')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- Category -->
                                <div class="mb-3 ">
                                    <label class="form-label" for="category">Category</label>
                                    <select wire:model="form.blog_category_id" class="form-select" id="category"
                                        required>
                                        <option selected value="">Select</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ str($category->name)->ucfirst() }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('form.blog_category_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!-- Editor -->
                        <div class="mt-2 mb-4" wire:ignore>
                            <div id="editor" data-blog-content="{{ json_encode($blog) }}">

                            </div>
                        </div>
                        <!-- button -->
                        <button type="submit" wire:click.debounce="$refresh" id="publish-btn"
                            class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-md-12 col-12">
            <div class="d-flex flex-column gap-4">
                <!-- Card -->
                <div class="card">
                    <!-- Card Header -->
                    <div class="card-header d-lg-flex">
                        <h4 class="mb-0">Post Info</h4>
                    </div>
                    <!-- List Group -->
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <span class="text-body">Post ID</span>
                            <h5 class="mb-0">{{ $blog->id }}</h5>
                        </li>
                        <li class="list-group-item">
                            <span class="text-body">Status</span>
                            <h5 class="mb-0">
                                <span
                                    class="badge-dot @if ($blog->status == 'published') bg-success @else bg-warning @endif d-inline-block me-1"></span>
                                {{ $blog->status }}
                            </h5>
                        </li>
                        <li class="list-group-item d-flex flex-column gap-2">
                            <span class="text-body">Dibuat Oleh</span>
                            <div class="d-flex flex-row gap-2">
                                <img src="../../assets/images/avatar/avatar-1.jpg" alt=""
                                    class="avatar-sm rounded-circle" />
                                <div>
                                    <h5 class="mb-n1">{{ $blog->author->username }}</h5>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <span class="text-body">Dibuat</span>
                            <h5 class="mb-0">{{ $blog->created_at->format('H:i, d M Y') }}</h5>
                        </li>
                        <li class="list-group-item">
                            <span class="text-body">Terakhir Di Publish</span>
                            <h5 class="mb-0">
                                {{ $blog->published_at ? $blog->published_at->format('H:i, d M Y') : '-' }}
                                <span>{{ $blog->status === 'drafted' ? '(Drafted)' : '' }}</span>
                            </h5>
                        </li>
                        <li class="list-group-item">
                            <span class="text-body">Terakhir Diperbarui</span>
                            <h5 class="mb-0">
                                @if ($blog->updated_at == $blog->created_at)
                                    -
                                @else
                                    {{ $blog->updated_at->format('H:i, d M Y') }}
                                @endif

                            </h5>
                        </li>
                    </ul>
                    <!-- Card -->
                </div>
                <div class="card">
                    <!-- Card Header -->
                    <div class="card-header d-lg-flex">
                        <h4 class="mb-0">Actions</h4>
                    </div>
                    <!-- List group -->
                    <ul class="list-group list-group-flush">
                        @if ($blog->status == 'drafted')
                            <button wire:click="publish"
                                class="btn btn-light list-group-item d-flex justify-content-between align-items-center">
                                <span class="text-secondary">Publish</span>
                                <i class="fe fe-arrow-up-circle fs-4"></i>
                            </button>
                        @else
                            <button wire:click="unpublish"
                                class="btn btn-light list-group-item d-flex justify-content-between align-items-center">
                                <span class="text-secondary">Unpublish</span>
                                <i class="fe fe-x-circle fs-4"></i>
                            </button>
                        @endif
                        <button wire:click="confirmation"
                            class="btn btn-light list-group-item d-flex justify-content-between align-items-center">
                            <span class="text-danger">Delete</span>
                            <i class="fe fe-trash text-danger fs-4"></i>
                        </button>
                    </ul>
                </div>
                <!-- Card  -->
                {{-- <div class="card">
                    <!-- Card header -->
                    <div class="card-header d-lg-flex">
                        <h4 class="mb-0">Revision History</h4>
                    </div>
                    <!-- List group -->
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-0">Aug 31, 12:21 PM</h5>
                                <span class="text-body">Geeks Coures</span>
                            </div>
                            <div>
                                <span class="badge bg-success badge-pill">Published</span>
                            </div>
                        </li>
                    </ul>
                </div> --}}
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:init', function() {
            const blog = @json($blog);
            console.log(blog)
            quill.clipboard.dangerouslyPasteHTML(blog['content']);
        });

        document.getElementById('publish-btn').addEventListener('click', function() {
            const content = quill.getSemanticHTML();
            console.log(content)
            @this.set('form.content', content);
            myDropzone.processQueue();
        });
    </script>

    <script src={{ asset('assets/libs/dropzone/dist/min/dropzone.min.js') }}></script>
    <script src={{ asset('assets/libs/flatpickr/dist/flatpickr.min.js') }}></script>
    <script src={{ asset('assets/js/vendors/flatpickr.js') }}></script>
    <script src={{ asset('assets/libs/quill/dist/quill.js') }}></script>
    <script src={{ asset('assets/js/vendors/editor.js') }}></script>
    <script src={{ asset('assets/js/vendors/validation.js') }}></script>
    <script src={{ asset('assets/js/vendors/dropzone.js') }}></script>
    <script src={{ asset('assets/libs/choices.js/public/assets/scripts/choices.min.js') }}></script>

    <script src={{ asset('assets/js/vendors/choice.js') }}></script>
</section>
