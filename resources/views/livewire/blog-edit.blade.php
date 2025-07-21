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
        <div class="col-xl-9 col-lg-8 col-md-12 col-12">
            <!-- Card -->
            <div class="card border-0">
                <!-- Card header -->
                <div class="card-header">
                    <h4 class="mb-0">Create Post</h4>
                </div>
                <form wire:submit="submit" class="needs-validation" novalidate>
                    <!-- Card body -->
                    <div class="card-body">

                        <div id="my-dropzone" class="dropzone border-dashed rounded-2 min-h-0"></div>
                        <!-- Add the "Upload" button -->
                        <div class="mt-4">
                            <!-- Form -->
                            <div class="row">
                                <!-- Date -->
                                {{-- <div class="mb-3 col-md-4">
                                    <label for="selectDate" class="form-label">Date</label>
                                    <input wire:model="date" type="text" id="selectDate"
                                        class="form-control text-dark flatpickr" placeholder="Select Date" required />
                                    <div class="invalid-feedback">Please enter valid date.</div>
                                </div> --}}
                                <div class="mb-3 col-md-9">
                                    <!-- Title -->
                                    <label for="postTitle" class="form-label">Title</label>
                                    <input wire:model="title" type="text" id="postTitle"
                                        class="form-control text-dark" placeholder="Post Title" required />
                                    <small>Keep your post titles under 60 characters. Write heading that describe the
                                        topic content.
                                        Contextualize for Your Audience.</small>
                                    <div class="invalid-feedback">Please enter title.</div>
                                </div>
                                <!-- Slug -->
                                <div class="mb-3 col-md-9">
                                    <label for="basic-url" class="form-label">Slug</label>
                                    <div class="input-group mb-1">
                                        <span class="input-group-text"
                                            id="basic-addon3">http://lms-axioo.com/blogs/</span>
                                        <input wire:model="slug" type="text" class="form-control" id="basic-url"
                                            aria-describedby="basic-addon3" />
                                    </div>
                                    <small>Field must contain an unique value</small>
                                </div>
                                {{-- <!-- Excerpt -->
                                <div class="mb-3 col-md-9">
                                    <label for="Excerpt" class="form-label">Excerpt</label>
                                    <textarea rows="3" id="Excerpt" class="form-control text-dark" placeholder="Excerpt"></textarea>
                                    <small>A short extract from writing.</small>
                                </div> --}}
                                <!-- Category -->
                                <div class="mb-3 col-md-9">
                                    <label class="form-label" for="category">Category</label>
                                    <select wire:model="blog_category_id" class="form-select" id="category" required>
                                        <option selected value="">Select</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ str($category->name)->ucfirst() }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Please choose category.</div>
                                </div>
                            </div>
                        </div>
                        <!-- Editor -->
                        <div class="mt-2 mb-4">
                            <div id="editor" data-blog-content="{{ json_encode($blog) }}">

                            </div>
                        </div>
                        <!-- button -->
                        <button type="submit" id="publish-btn" class="btn btn-primary">Publish</button>
                        <button type="submit" class="btn btn-outline-secondary">Save to Draft</button>
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
                                <span class="badge-dot bg-success d-inline-block me-1"></span>
                                {{ $blog->status }}
                            </h5>
                        </li>
                        <li class="list-group-item d-flex flex-column gap-2">
                            <span class="text-body">Created by</span>
                            <div class="d-flex flex-row gap-2">
                                <img src="../../assets/images/avatar/avatar-1.jpg" alt=""
                                    class="avatar-sm rounded-circle" />
                                <div class="">
                                    <h5 class="mb-n1">Geeks Courses</h5>
                                    <small>{{ $blog->author->username }}</small>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <span class="text-body">Created at</span>
                            <h5 class="mb-0">{{ $blog->created_at->format('H:i, d M Y') }}</h5>
                        </li>
                        <li class="list-group-item">
                            <span class="text-body">First published at</span>
                            <h5 class="mb-0">-</h5>
                        </li>
                        <li class="list-group-item">
                            <span class="text-body">Last update</span>
                            <h5 class="mb-0">
                                @if ($blog->updated_at == $blog->created_at)
                                    -
                                @else
                                    {{ $blog->updated_at->format('H:i, d M Y') }}
                                @endif

                            </h5>
                        </li>
                        <li class="list-group-item">
                            <span class="text-body">Last Published</span>
                            <h5 class="mb-0">-</h5>
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
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="text-body">Unpublish</span>
                            <a href="#" class="text-inherit"><i class="fe fe-x-circle fs-4"></i></a>
                        </li>
                        {{-- <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="text-body">Duplicate</span>
                            <a href="#" class="text-inherit"><i class="fe fe-copy fs-4"></i></a>
                        </li> --}}
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="text-body">Delete</span>
                            <a href="#"><i class="fe fe-trash text-danger fs-4"></i></a>
                        </li>
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
        document.addEventListener('DOMContentLoaded', function() {
            const blog = @json($blog);
            quill.setContents(blog['content']);
        });

        document.getElementById('publish-btn').addEventListener('click', function() {
            // @this.set('content', quill.getContents());
            const delta = quill.getContents();
            JSON.stringify(delta)

            @this.set('content', delta);
        });
    </script>
</section>
