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
                <form wire:submit="submit">
                    <!-- Card body -->
                    <div class="card-body">
                        <div id="my-dropzone" class="dropzone border-dashed rounded-2 min-h-0"></div>
                        <!-- Add the "Upload" button -->
                        <div class="mt-4">
                            <!-- Form -->
                            <div class="row">
                                {{-- <!-- Date -->
                                <div class="mb-3 col-md-4">
                                    <label for="selectDate" class="form-label">Date</label>
                                    <input wire:model="date" type="text" id="selectDate"
                                        class="form-control text-dark flatpickr" placeholder="Select Date" required />
                                    <div class="invalid-feedback">Please enter valid date.</div>
                                </div> --}}
                                <div class="mb-3 ">
                                    <!-- Title -->
                                    <label for="postTitle" class="form-label">Title</label>
                                    <input wire:model="title" type="text" id="postTitle"
                                        class="form-control text-dark" placeholder="Post Title" required />
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- Slug -->
                                <div class="mb-3 ">
                                    <label for="basic-url" class="form-label">Slug</label>
                                    <div class="input-group mb-1">
                                        <span class="input-group-text"
                                            id="basic-addon3">http://lms-axioo.com/blogs/</span>
                                        <input wire:model="slug" type="text" class="form-control" id="basic-url"
                                            aria-describedby="basic-addon3" />
                                    </div>
                                    @error('slug')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                {{-- <!-- Excerpt -->
                                <div class="mb-3 ">
                                    <label for="Excerpt" class="form-label">Excerpt</label>
                                    <textarea rows="3" id="Excerpt" class="form-control text-dark" placeholder="Excerpt"></textarea>
                                    <small>A short extract from writing.</small>
                                </div> --}}
                                <!-- Category -->
                                <div class="mb-3 ">
                                    <label class="form-label" for="category">Category</label>
                                    <select wire:model="blog_category_id" class="form-select" id="category" required>
                                        <option selected value="">Select</option>

                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ str($category->name)->ucfirst() }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!-- Editor -->
                        <div class="mt-2 mb-4">
                            <div id="editor">

                            </div>
                        </div>
                        <!-- button -->
                        <button type="submit" id="publish-btn" class="btn btn-primary">Publish</button>
                        <button type="submit" class="btn btn-outline-secondary">Save to Draft</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('publish-btn').addEventListener('click', function() {
            const content = quill.getSemanticHTML();
            console.log(content)
            @this.set('content', content);
        });
    </script>
</section>
