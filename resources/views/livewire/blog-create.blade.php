<section class="container-fluid p-4 ">
    <div class="row d-flex">
        <!-- Page header -->
        <div class="col-lg-12 col-md-12 col-12">
            <div
                class="border-bottom pb-3 mb-3 d-flex flex-column flex-md-row gap-3 align-items-md-center justify-content-between">
                <div class="d-flex flex-column gap-1">
                    <h1 class="mb-0 h2 fw-bold">Add New Post</h1>
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item"><a href="#">CMS</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add New Post</li>
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
        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
            <!-- Card -->
            <div class="card border-0">
                <!-- Card header -->
                <div class="card-header">
                    <h4 class="mb-0">Create Post</h4>
                </div>
                <form wire:submit="save()">
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

                        <p class="mb-2 text-secondary">Gambar thumbnail sebaiknya memiliki rasio 21:9 dan berukuran
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
                                    @error('form.category')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!-- Editor -->
                        <label class="form-label">Content</label>
                        <div class="mt-2 mb-4" wire:ignore>
                            <livewire:jodit-text-editor wire:model.live="form.content" />
                        </div>
                        <!-- button -->
                        <button wire:click="$dispatch('status', { status: 'published' })" type="submit"
                            id="publish-btn" class="btn btn-primary">Publish</button>
                        <button wire:click="$dispatch('status', { status: 'drafted' })" type="submit" id="draft-btn"
                            class="btn btn-outline-secondary">Save to Draft</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</section>

@assets
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/jodit.css') }}">
    <script src="{{ asset('assets/js/jodit.js') }}"></script>
    <style>
        .jodit-wysiwyg pre {
            background-color: #1f2937;
            color: #ffffff;
            padding: 1rem;
            border-radius: 0.5rem;
            max-width: 100%;
            overflow-wrap: break-word;
            white-space: pre-wrap;
            word-break: break-word;
        }

        .jodit-wysiwyg code {
            font-size: 0.875rem;
        }

        .jodit-wysiwyg blockquote {
            border-left: 4px solid #9ca3af;
            padding-left: 1rem;
            font-style: italic;
            color: #4b5563;
        }
    </style>
@endassets
