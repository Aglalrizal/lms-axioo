<section class="py-8">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <!-- Page Header -->
                <div
                    class="border-bottom pb-3 mb-3 d-flex flex-column flex-md-row gap-3 align-items-md-center justify-content-between">
                    <div class="d-flex flex-column gap-1">
                        <h1 class="mb-0 h2 fw-bold">Create Course</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="bs-stepper">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12">
                    <!-- Stepper Button -->
                    <div class="bs-stepper-header shadow-sm">
                        <div class="step {{ $currentStep == 1 ? 'active' : '' }} ">
                            <button wire:click="$dispatch('go-to', {step: 1})" x-on:click="$wire.$refresh()"
                                type="button" class="step-trigger">
                                <span class="bs-stepper-circle">1</span>
                                <span class="bs-stepper-label">Basic Information</span>
                            </button>
                        </div>
                        <div class="bs-stepper-line"></div>
                        <div class="step {{ $currentStep == 2 ? 'active' : '' }}">
                            <button wire:click="$dispatch('go-to', {step: 2})" type="button" class="step-trigger">
                                <span class="bs-stepper-circle">2</span>
                                <span class="bs-stepper-label">Courses Media</span>
                            </button>
                        </div>
                        <div class="bs-stepper-line"></div>
                        <div class="step {{ $currentStep == 3 ? 'active' : '' }}">
                            <button wire:click="$dispatch('go-to', {step: 3})" type="button" class="step-trigger">
                                <span class="bs-stepper-circle">3</span>
                                <span class="bs-stepper-label">Curriculum</span>
                            </button>
                        </div>
                        <div class="bs-stepper-line"></div>
                        <div class="step {{ $currentStep == 4 ? 'active' : '' }}">
                            <button wire:click="$dispatch('go-to', {step: 4})" type="button" class="step-trigger">
                                <span class="bs-stepper-circle">4</span>
                                <span class="bs-stepper-label">Settings</span>
                            </button>
                        </div>
                    </div>
                    <!-- Stepper content -->
                    <div class="bs-stepper-content mt-5">
                        @if ($currentStep == 1)
                            <!-- Content one -->
                            <form wire:submit="stepOne" wire:ignore>
                                <!-- Card -->
                                <div class="card mb-3">
                                    <div class="card-header border-bottom px-4 py-3">
                                        <h4 class="mb-0">Basic Information</h4>
                                    </div>
                                    <!-- Card body -->
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="addCourseTitle" class="form-label">Course Title</label>
                                            <input id="addCourseTitle" wire:model="title"
                                                class="form-control @error('title') is-invalid @enderror" type="text"
                                                placeholder="Course Title " />
                                            <small>Write a 60 character course title.</small>
                                            @error('title')
                                                <small class="d-block mt-2 text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="mb-3" wire:ignore>
                                            <label class="form-label" for="select-category">Courses
                                                Category</label>
                                            <select class="form-select" id="select-category"
                                                wire:model="selectedCategory" required>
                                                <option value="">Select Category
                                                </option>
                                                @foreach ($categories as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                            <small>Help people find your courses by choosing categories that
                                                represent your
                                                course.</small>
                                        </div>
                                        <div class="mb-3" wire:ignore>
                                            <label class="form-label" for="select-instructor">Select
                                                Instructor</label>
                                            <select class="form-select" id="select-instructor"
                                                wire:model="selectedInstructor" required>
                                                <option value="">Select Instructor
                                                </option>
                                                @foreach ($instructors as $item)
                                                    <option value="{{ $item->id }}">
                                                        {{ $item->first_name . ' ' . $item->surname }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="addCourseLevel">Courses level</label>
                                            <select class="form-select text-dark" id="addCourseLevel"
                                                wire:model="courseLevel" required>
                                                <option value="">Select level</option>
                                                <option value="beginner">Beginner</option>
                                                <option value="intermediate">Intermediate</option>
                                                <option value="advance">Advance</option>
                                            </select>
                                        </div>
                                        <div class="mb-3" wire:ignore>
                                            <label class="form-label">Course Description</label>
                                            <div id="editor">
                                                <p>Insert course description</p>
                                                <p><br /></p>
                                            </div>
                                            <small>A brief summary of your courses.</small>
                                            <trix-toolbar id="my_toolbar"></trix-toolbar>
                                            <div class="more-stuff-inbetween"></div>
                                            <trix-editor toolbar="my_toolbar" input="my_input"></trix-editor>
                                        </div>
                                    </div>
                                </div>
                                <!-- Button -->
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary" id="save-button">Simpan</button>
                                    @if ($currentStep > 1)
                                        <button class="btn btn-primary " wire:click="next">Next</button>
                                    @endif
                                </div>
                            </form>
                            <button wire:click="$refresh">Refresh this component</button>
                        @endif
                        @if ($currentStep == 2)
                            <!-- Content two -->
                            <form wire:submit="saveImage">
                                <!-- Card -->
                                <div class="card mb-3 border-0">
                                    <div class="card-header border-bottom px-4 py-3">
                                        <h4 class="mb-0">Course Media</h4>
                                    </div>
                                    <!-- Card body -->
                                    <div class="card-body">
                                        <div class="mb-4">
                                            <label for="courseImage" class="form-label">Course Image</label>
                                            <input type="file" id="courseImage" wire:model="courseImage"
                                                class="form-control" accept="image/*">

                                            @error('courseImage')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        {{-- Preview --}}
                                        @if ($courseImage)
                                            <label class="form-label">Preview:</label>
                                            <div class="mb-3">
                                                <img src="{{ $courseImage->temporaryUrl() }}" alt="Preview"
                                                    class="img-fluid rounded border img-thumbnail">
                                            </div>
                                        @endif
                                    </div>
                                    <!-- Button -->
                                    <div class="card-footer text-end">
                                        <button type="submit" class="btn btn-primary">Upload and continue</button>
                                    </div>
                                </div>
                            </form>
                        @endif
                        @if ($currentStep == 3)
                            <!-- Content three -->
                            <div id="test-l-3" role="tabpanel" class="bs-stepper-pane fade"
                                aria-labelledby="courseFormtrigger3">
                                <!-- Card -->
                                <div class="card mb-3 border-0">
                                    <div class="card-header border-bottom px-4 py-3">
                                        <h4 class="mb-0">Curriculum</h4>
                                    </div>
                                    <!-- Card body -->
                                    <div class="card-body">
                                        <div class="bg-light rounded p-2 mb-4">
                                            <h4>Introduction to JavaScript</h4>
                                            <!-- List group -->
                                            <div class="list-group list-group-flush border-top-0" id="courseList">
                                                <div id="courseOne">
                                                    <div class="list-group-item rounded px-3 text-nowrap mb-1"
                                                        id="introduction">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <h5 class="mb-0 text-truncate">
                                                                <a href="#" class="text-inherit">
                                                                    <i class="fe fe-menu me-1 align-middle"></i>
                                                                    <span class="align-middle">Introduction</span>
                                                                </a>
                                                            </h5>
                                                            <div>
                                                                <a href="#" class="me-1 text-inherit"
                                                                    data-bs-toggle="tooltip" data-placement="top"
                                                                    title="Edit">
                                                                    <i class="fe fe-edit fs-6"></i>
                                                                </a>
                                                                <a href="#" class="me-1 text-inherit"
                                                                    data-bs-toggle="tooltip" data-placement="top"
                                                                    title="Delete">
                                                                    <i class="fe fe-trash-2 fs-6"></i>
                                                                </a>
                                                                <a href="#" class="text-inherit"
                                                                    aria-expanded="true" data-bs-toggle="collapse"
                                                                    data-bs-target="#collapselistOne"
                                                                    aria-controls="collapselistOne">
                                                                    <span class="chevron-arrow"><i
                                                                            class="fe fe-chevron-down"></i></span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div id="collapselistOne" class="collapse show"
                                                            aria-labelledby="introduction"
                                                            data-bs-parent="#courseList">
                                                            <div class="p-md-4 p-2">
                                                                <a href="#" class="btn btn-secondary btn-sm">Add
                                                                    Article
                                                                    +</a>
                                                                <a href="#" class="btn btn-secondary btn-sm">Add
                                                                    Description +</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="list-group-item rounded px-3 text-nowrap mb-1"
                                                        id="development">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <h5 class="mb-0 text-truncate">
                                                                <a href="#" class="text-inherit">
                                                                    <i class="fe fe-menu me-1 align-middle"></i>
                                                                    <span class="align-middle">Installing
                                                                        Development Software</span>
                                                                </a>
                                                            </h5>
                                                            <div>
                                                                <a href="#" class="me-1 text-inherit"
                                                                    data-bs-toggle="tooltip" data-placement="top"
                                                                    title="Edit">
                                                                    <i class="fe fe-edit fs-6"></i>
                                                                </a>
                                                                <a href="#" class="me-1 text-inherit"
                                                                    data-bs-toggle="tooltip" data-placement="top"
                                                                    title="Delete">
                                                                    <i class="fe fe-trash-2 fs-6"></i>
                                                                </a>
                                                                <a href="#" class="text-inherit"
                                                                    data-bs-toggle="collapse"
                                                                    data-bs-target="#collapselistTwo"
                                                                    aria-expanded="false"
                                                                    aria-controls="collapselistTwo">
                                                                    <span class="chevron-arrow"><i
                                                                            class="fe fe-chevron-down"></i></span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div id="collapselistTwo" class="collapse"
                                                            aria-labelledby="development"
                                                            data-bs-parent="#courseList">
                                                            <div class="p-md-4 p-2">
                                                                <a href="#" class="btn btn-secondary btn-sm">Add
                                                                    Article
                                                                    +</a>
                                                                <a href="#" class="btn btn-secondary btn-sm">Add
                                                                    Description +</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="list-group-item rounded px-3 text-nowrap mb-1"
                                                        id="project">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <h5 class="mb-0 text-truncate">
                                                                <a href="#" class="text-inherit">
                                                                    <i class="fe fe-menu me-1 align-middle"></i>
                                                                    <span class="align-middle">Hello World Project
                                                                        from GitHub</span>
                                                                </a>
                                                            </h5>
                                                            <div>
                                                                <a href="#" class="me-1 text-inherit"
                                                                    data-bs-toggle="tooltip" data-placement="top"
                                                                    title="Edit">
                                                                    <i class="fe fe-edit fs-6"></i>
                                                                </a>
                                                                <a href="#" class="me-1 text-inherit"
                                                                    data-bs-toggle="tooltip" data-placement="top"
                                                                    title="Delete">
                                                                    <i class="fe fe-trash-2 fs-6"></i>
                                                                </a>
                                                                <a href="#" class="text-inherit"
                                                                    data-bs-toggle="collapse"
                                                                    data-bs-target="#collapselistThree"
                                                                    aria-expanded="false"
                                                                    aria-controls="collapselistThree">
                                                                    <span class="chevron-arrow"><i
                                                                            class="fe fe-chevron-down"></i></span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div id="collapselistThree" class="collapse"
                                                            aria-labelledby="project" data-bs-parent="#courseList">
                                                            <div class="p-md-4 p-2">
                                                                <a href="#" class="btn btn-secondary btn-sm">Add
                                                                    Article
                                                                    +</a>
                                                                <a href="#" class="btn btn-secondary btn-sm">Add
                                                                    Description +</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="list-group-item rounded px-3 text-nowrap mb-1"
                                                        id="sample">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <h5 class="mb-0 text-truncate">
                                                                <a href="#" class="text-inherit">
                                                                    <i class="fe fe-menu me-1 align-middle"></i>
                                                                    <span class="align-middle">Our Sample
                                                                        Website</span>
                                                                </a>
                                                            </h5>
                                                            <div>
                                                                <a href="#" class="me-1 text-inherit"
                                                                    data-bs-toggle="tooltip" data-placement="top"
                                                                    title="Edit">
                                                                    <i class="fe fe-edit fs-6"></i>
                                                                </a>
                                                                <a href="#" class="me-1 text-inherit"
                                                                    data-bs-toggle="tooltip" data-placement="top"
                                                                    title="Delete">
                                                                    <i class="fe fe-trash-2 fs-6"></i>
                                                                </a>
                                                                <a href="#" class="text-inherit"
                                                                    data-bs-toggle="collapse"
                                                                    data-bs-target="#collapselistFour"
                                                                    aria-expanded="false"
                                                                    aria-controls="collapselistFour">
                                                                    <span class="chevron-arrow"><i
                                                                            class="fe fe-chevron-down"></i></span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div id="collapselistFour" class="collapse"
                                                            aria-labelledby="sample" data-bs-parent="#courseList">
                                                            <div class="p-md-4 p-2">
                                                                <a href="#" class="btn btn-secondary btn-sm">Add
                                                                    Article
                                                                    +</a>
                                                                <a href="#" class="btn btn-secondary btn-sm">Add
                                                                    Description +</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="#" class="btn btn-outline-primary btn-sm mt-3"
                                                data-bs-toggle="modal" data-bs-target="#addLectureModal">Add
                                                Lecture +</a>
                                        </div>
                                        <div class="bg-light rounded p-2 mb-4">
                                            <h4>JavaScript Beginnings</h4>

                                            <!-- List group -->
                                            <div class="list-group list-group-flush border-top-0"
                                                id="courseListSecond">
                                                <div id="courseTwo">
                                                    <div class="list-group-item rounded px-3 text-nowrap mb-1"
                                                        id="introductionSecond">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <h5 class="mb-0 text-truncate">
                                                                <a href="#" class="text-inherit">
                                                                    <i class="fe fe-menu me-1 align-middle"></i>
                                                                    <span class="align-middle">Introduction</span>
                                                                </a>
                                                            </h5>
                                                            <div>
                                                                <a href="#" class="me-1 text-inherit"
                                                                    data-bs-toggle="tooltip" data-placement="top"
                                                                    title="Edit">
                                                                    <i class="fe fe-edit fs-6"></i>
                                                                </a>
                                                                <a href="#" class="me-1 text-inherit"
                                                                    data-bs-toggle="tooltip" data-placement="top"
                                                                    title="Delete">
                                                                    <i class="fe fe-trash-2 fs-6"></i>
                                                                </a>
                                                                <a href="#" class="text-inherit"
                                                                    data-bs-toggle="collapse"
                                                                    data-bs-target="#collapselistFive"
                                                                    aria-expanded="false"
                                                                    aria-controls="collapselistFive">
                                                                    <span class="chevron-arrow"><i
                                                                            class="fe fe-chevron-down"></i></span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div id="collapselistFive" class="collapse"
                                                            aria-labelledby="introductionSecond"
                                                            data-bs-parent="#courseListSecond">
                                                            <div class="p-md-4 p-2">
                                                                <a href="#" class="btn btn-secondary btn-sm">Add
                                                                    Article
                                                                    +</a>
                                                                <a href="#" class="btn btn-secondary btn-sm">Add
                                                                    Description +</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="list-group-item rounded px-3 text-nowrap mb-1"
                                                        id="developmentSecond">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <h5 class="mb-0 text-truncate">
                                                                <a href="#" class="text-inherit">
                                                                    <i class="fe fe-menu me-1 align-middle"></i>
                                                                    <span class="align-middle">Installing
                                                                        Development Software</span>
                                                                </a>
                                                            </h5>
                                                            <div>
                                                                <a href="#" class="me-1 text-inherit"
                                                                    data-bs-toggle="tooltip" data-placement="top"
                                                                    title="Edit">
                                                                    <i class="fe fe-edit fs-6"></i>
                                                                </a>
                                                                <a href="#" class="me-1 text-inherit"
                                                                    data-bs-toggle="tooltip" data-placement="top"
                                                                    title="Delete">
                                                                    <i class="fe fe-trash-2 fs-6"></i>
                                                                </a>
                                                                <a href="#" class="text-inherit"
                                                                    data-bs-toggle="collapse"
                                                                    data-bs-target="#collapselistSix"
                                                                    aria-expanded="false"
                                                                    aria-controls="collapselistSix">
                                                                    <span class="chevron-arrow"><i
                                                                            class="fe fe-chevron-down"></i></span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div id="collapselistSix" class="collapse"
                                                            aria-labelledby="developmentSecond"
                                                            data-bs-parent="#courseListSecond">
                                                            <div class="p-md-4 p-2">
                                                                <a href="#" class="btn btn-secondary btn-sm">Add
                                                                    Article
                                                                    +</a>
                                                                <a href="#" class="btn btn-secondary btn-sm">Add
                                                                    Description +</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="list-group-item rounded px-3 text-nowrap mb-1"
                                                        id="projectSecond">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <h5 class="mb-0 text-truncate">
                                                                <a href="#" class="text-inherit">
                                                                    <i class="fe fe-menu me-1 align-middle"></i>
                                                                    <span class="align-middle">Hello World Project
                                                                        from GitHub</span>
                                                                </a>
                                                            </h5>
                                                            <div>
                                                                <a href="#" class="me-1 text-inherit"
                                                                    data-bs-toggle="tooltip" data-placement="top"
                                                                    title="Edit">
                                                                    <i class="fe fe-edit fs-6"></i>
                                                                </a>
                                                                <a href="#" class="me-1 text-inherit"
                                                                    data-bs-toggle="tooltip" data-placement="top"
                                                                    title="Delete">
                                                                    <i class="fe fe-trash-2 fs-6"></i>
                                                                </a>
                                                                <a href="#" class="text-inherit"
                                                                    data-bs-toggle="collapse"
                                                                    data-bs-target="#collapselistSeven"
                                                                    aria-expanded="false"
                                                                    aria-controls="collapselistSeven">
                                                                    <span class="chevron-arrow"><i
                                                                            class="fe fe-chevron-down"></i></span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div id="collapselistSeven" class="collapse"
                                                            aria-labelledby="projectSecond"
                                                            data-bs-parent="#courseListSecond">
                                                            <div class="p-md-4 p-2">
                                                                <a href="#" class="btn btn-secondary btn-sm">Add
                                                                    Article
                                                                    +</a>
                                                                <a href="#" class="btn btn-secondary btn-sm">Add
                                                                    Description +</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="list-group-item rounded px-3 text-nowrap mb-1"
                                                        id="sampleSecond">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <h5 class="mb-0 text-truncate">
                                                                <a href="#" class="text-inherit">
                                                                    <i class="fe fe-menu me-1 align-middle"></i>
                                                                    <span class="align-middle">Our Sample
                                                                        Website</span>
                                                                </a>
                                                            </h5>
                                                            <div>
                                                                <a href="#" class="me-1 text-inherit"
                                                                    data-bs-toggle="tooltip" data-placement="top"
                                                                    title="Edit">
                                                                    <i class="fe fe-edit fs-6"></i>
                                                                </a>
                                                                <a href="#" class="me-1 text-inherit"
                                                                    data-bs-toggle="tooltip" data-placement="top"
                                                                    title="Delete">
                                                                    <i class="fe fe-trash-2 fs-6"></i>
                                                                </a>
                                                                <a href="#" class="text-inherit"
                                                                    data-bs-toggle="collapse"
                                                                    data-bs-target="#collapselistEight"
                                                                    aria-expanded="false"
                                                                    aria-controls="collapselistEight">
                                                                    <span class="chevron-arrow"><i
                                                                            class="fe fe-chevron-down"></i></span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div id="collapselistEight" class="collapse"
                                                            aria-labelledby="sampleSecond"
                                                            data-bs-parent="#courseListSecond">
                                                            <div class="p-md-4 p-2">
                                                                <a href="#" class="btn btn-secondary btn-sm">Add
                                                                    Article
                                                                    +</a>
                                                                <a href="#" class="btn btn-secondary btn-sm">Add
                                                                    Description +</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="#" class="btn btn-outline-primary btn-sm mt-3"
                                                data-bs-toggle="modal" data-bs-target="#addLectureModal">Add
                                                Lecture +</a>
                                        </div>
                                        <a href="#" class="btn btn-outline-primary btn-sm"
                                            data-bs-toggle="modal" data-bs-target="#addSectionModal">Add
                                            Section</a>
                                    </div>
                                </div>
                                <!-- Button -->
                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-secondary"
                                        onclick="courseForm.previous()">Previous</button>
                                    <button class="btn btn-primary" onclick="courseForm.next()">Next</button>
                                </div>
                            </div>
                        @endif
                        @if ($currentStep == 4)
                            <!-- Content four -->
                            <div id="test-l-4" role="tabpanel" class="bs-stepper-pane fade"
                                aria-labelledby="courseFormtrigger4">
                                <!-- Card -->
                                <div class="card mb-3 border-0">
                                    <div class="card-header border-bottom px-4 py-3">
                                        <h4 class="mb-0">Requirements</h4>
                                    </div>
                                    <!-- Card body -->
                                    <div class="card-body">
                                        <input name="tags" class="w-100" value="jquery, bootstrap" />
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between mb-8">
                                    <!-- Button -->
                                    <button class="btn btn-secondary"
                                        onclick="courseForm.previous()">Previous</button>
                                    <button type="submit" class="btn btn-danger">Submit For Review</button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/libs/glightbox/dist/css/glightbox.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/libs/bs-stepper/dist/css/bs-stepper.min.css') }}" />
@endsection

@assets
    <link rel="stylesheet" href="{{ asset('assets/libs/quill/dist/quill.snow.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('assets/libs/quill/dist/quill.js') }}"></script>
    <script src="{{ asset('assets/libs/dragula/dist/dragula.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/customDragula.js') }}"></script>
    <script src="{{ asset('assets/libs/glightbox/dist/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/glight.js') }}"></script>
    <script src="{{ asset('assets/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/choice.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
@endassets

@script
    <script>
        document.getElementById('save-button').addEventListener('click', function() {
            let description = quill.root.innerHTML;
            @this.set('description', description);

            const instructor = $('#select-instructor').val();
            const category = $('#select-category').val();
            @this.set('selectedCategory', category);
            @this.set('selectedInstructor', instructor);
        });
    </script>
@endscript
