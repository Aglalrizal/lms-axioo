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
                                <a href="admin-dashboard.html">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item"><a href="#">CMS</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add New Post</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="/admin/blogs" class="btn btn-outline-secondary">Back to All Post</a>
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
                        <label class="form-label">Thumbnail</label>
                        <div wire:ignore id="my-dropzone" class="dropzone border-dashed rounded-2 min-h-0"></div>
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
                                    @error('form.category')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!-- Editor -->
                        <label class="form-label">Content</label>
                        <div class="mt-2 mb-4" wire:ignore>
                            <div id="editor">
                            </div>
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
    <script>
        function setContent() {
            const content = quill.getSemanticHTML();
            console.log(content)
            @this.set('form.content', content);
        }
        document.getElementById('publish-btn').addEventListener('click', setContent);
        document.getElementById('draft-btn').addEventListener('click', setContent);
    </script>
</section>
