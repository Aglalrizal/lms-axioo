@extends('layouts.courseContent')

@section('content')
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid px-0">
            <a class="navbar-brand" href="../index.html"><img src="../assets/images/brand/logo/logo.svg" alt="Geeks"></a>
            <div>
                <!-- Button -->
                <button class="navbar-toggler collapsed ms-2" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbar-default" aria-controls="navbar-default" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="icon-bar top-bar mt-0"></span>
                    <span class="icon-bar middle-bar"></span>
                    <span class="icon-bar bottom-bar"></span>
                </button>
            </div>
            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="navbar-default">
            </div>
        </div>
    </nav>
    <main>
        <section class="mt-6 course-container">
            <div class="container-fluid pt-6">
                <div class="row">
                    <div class="col-12">
                        <div class="content" id="course-tabContent">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div>
                                    <h3 class="mb-0 text-truncate-line-2">Introduction</h3>
                                </div>
                            </div>
                            <!-- Video -->
                            <div class="embed-responsive position-relative w-100 d-block overflow-hidden p-0"
                                style="height: 600px">
                                <iframe class="position-absolute top-0 start-0 end-0 bottom-0 h-100 w-100" width="560"
                                    height="315" src="https://www.youtube.com/embed/Nfzi7034Kbg?si=C2_CU7iIZJA5VWcS"
                                    title="Geeks - Academy and LMS Template" frameborder="0"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Card -->
        <section class="card course-sidebar" id="courseAccordion">
            <!-- List group -->
            <ul class="list-group list-group-flush overflow-hidden" style="height: 850px" data-simplebar="init">
                <div class="simplebar-wrapper" style="margin: 0px;">
                    <div class="simplebar-height-auto-observer-wrapper">
                        <div class="simplebar-height-auto-observer"></div>
                    </div>
                    <div class="simplebar-mask">
                        <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                            <div class="simplebar-content-wrapper" tabindex="0" role="region"
                                aria-label="scrollable content" style="height: 30%; overflow: hidden;">
                                <div class="simplebar-content" style="padding: 0px;">
                                    <li class="list-group-item">
                                        <h4 class="mb-0">Table of Content</h4>
                                    </li>
                                    <!-- List group item -->
                                    <li class="list-group-item">
                                        <!-- Toggle -->
                                        <a class="d-flex align-items-center h4 mb-0" data-bs-toggle="collapse"
                                            href="#courseTwo" role="button" aria-expanded="false"
                                            aria-controls="courseTwo">
                                            <div class="me-auto">Introduction to JavaScript</div>
                                            <!-- Chevron -->
                                            <span class="chevron-arrow ms-4">
                                                <i class="fe fe-chevron-down fs-4"></i>
                                            </span>
                                        </a>
                                        <!-- Row -->
                                        <!-- Collapse -->
                                        <div class="collapse show" id="courseTwo" data-bs-parent="#courseAccordion">
                                            <div class="py-4 nav" id="course-tabOne" role="tablist"
                                                aria-orientation="vertical" style="display: inherit">
                                                <a class="mb-2 d-flex justify-content-between align-items-center"
                                                    id="course-intro-tab" data-bs-toggle="pill" href="#course-intro"
                                                    role="tab" aria-controls="course-intro" aria-selected="true">
                                                    <div class="text-truncate">
                                                        <span
                                                            class="icon-shape bg-light text-primary icon-sm rounded-circle me-2"><i
                                                                class="fe fe-play fs-6"></i></span>
                                                        <span>Introduction</span>
                                                    </div>
                                                    <div class="text-truncate">
                                                        <span>1m 7s</span>
                                                    </div>
                                                </a>
                                                <a class="mb-2 d-flex justify-content-between align-items-center text-inherit"
                                                    id="course-development-tab" data-bs-toggle="pill"
                                                    href="#course-development" role="tab"
                                                    aria-controls="course-development" aria-selected="false">
                                                    <div class="text-truncate">
                                                        <span
                                                            class="icon-shape bg-light text-primary icon-sm rounded-circle me-2"><i
                                                                class="fe fe-play fs-6"></i></span>
                                                        <span>Installing Development Software</span>
                                                    </div>
                                                    <div class="text-truncate">
                                                        <span>3m 11s</span>
                                                    </div>
                                                </a>
                                                <a class="mb-2 d-flex justify-content-between align-items-center text-inherit"
                                                    id="course-project-tab" data-bs-toggle="pill" href="#course-project"
                                                    role="tab" aria-controls="course-project" aria-selected="false">
                                                    <div class="text-truncate">
                                                        <span
                                                            class="icon-shape bg-light text-primary icon-sm rounded-circle me-2"><i
                                                                class="fe fe-play fs-6"></i></span>
                                                        <span>Hello World Project from GitHub</span>
                                                    </div>
                                                    <div class="text-truncate">
                                                        <span>2m 33s</span>
                                                    </div>
                                                </a>
                                                <a class="d-flex justify-content-between align-items-center text-inherit"
                                                    id="course-website-tab" data-bs-toggle="pill" href="#course-website"
                                                    role="tab" aria-controls="course-website" aria-selected="false">
                                                    <div class="text-truncate">
                                                        <span
                                                            class="icon-shape bg-light text-primary icon-sm rounded-circle me-2"><i
                                                                class="fe fe-play fs-6"></i></span>
                                                        <span>Our Sample Website</span>
                                                    </div>
                                                    <div class="text-truncate">
                                                        <span>2m 15s</span>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                    <!-- List group item -->
                                    <li class="list-group-item">
                                        <!-- Toggle -->
                                        <a class="d-flex align-items-center h4 mb-0" data-bs-toggle="collapse"
                                            href="#courseThree" role="button" aria-expanded="false"
                                            aria-controls="courseThree">
                                            <div class="me-auto">
                                                <!-- Title -->
                                                JavaScript Beginning
                                            </div>
                                            <!-- Chevron -->
                                            <span class="chevron-arrow ms-4">
                                                <i class="fe fe-chevron-down fs-4"></i>
                                            </span>
                                        </a>
                                        <!-- Row -->
                                        <!-- Collapse -->
                                        <div class="collapse" id="courseThree" data-bs-parent="#courseAccordion">
                                            <div class="py-4 nav" id="course-tabTwo" role="tablist"
                                                aria-orientation="vertical" style="display: inherit">
                                                <a class="mb-2 d-flex justify-content-between align-items-center text-inherit disableClick"
                                                    id="course-intro-tab2" data-bs-toggle="pill" href="#"
                                                    role="tab" aria-controls="course-intro" aria-selected="true">
                                                    <div class="text-truncate">
                                                        <span
                                                            class="icon-shape bg-light text-secondary icon-sm rounded-circle me-2"><i
                                                                class="fe fe-lock fs-6"></i></span>
                                                        <span>Introduction</span>
                                                    </div>
                                                    <div class="text-truncate">
                                                        <span>1m 41s</span>
                                                    </div>
                                                </a>
                                                <a class="mb-2 d-flex justify-content-between align-items-center text-inherit disableClick"
                                                    id="course-development-tab2" data-bs-toggle="pill" href="#"
                                                    role="tab" aria-controls="course-development"
                                                    aria-selected="false">
                                                    <div class="text-truncate">
                                                        <span
                                                            class="icon-shape bg-light text-secondary icon-sm rounded-circle me-2"><i
                                                                class="fe fe-lock fs-6"></i></span>
                                                        <span>Adding JavaScript Code to a Web Page</span>
                                                    </div>
                                                    <div class="text-truncate">
                                                        <span>3m 39s</span>
                                                    </div>
                                                </a>
                                                <a class="mb-2 d-flex justify-content-between align-items-center text-inherit disableClick"
                                                    id="course-project-tab2" data-bs-toggle="pill" href="#"
                                                    role="tab" aria-controls="course-project" aria-selected="false">
                                                    <div class="text-truncate">
                                                        <span
                                                            class="icon-shape bg-light text-secondary icon-sm rounded-circle me-2"><i
                                                                class="fe fe-lock fs-6"></i></span>
                                                        <span>Working with JavaScript Files</span>
                                                    </div>
                                                    <div class="text-truncate">
                                                        <span>6m 18s</span>
                                                    </div>
                                                </a>
                                                <a class="mb-2 d-flex justify-content-between align-items-center text-inherit disableClick"
                                                    id="course-website-tab2" data-bs-toggle="pill" href="#"
                                                    role="tab" aria-controls="course-website" aria-selected="false">
                                                    <div class="text-truncate">
                                                        <span
                                                            class="icon-shape bg-light text-secondary icon-sm rounded-circle me-2"><i
                                                                class="fe fe-lock fs-6"></i></span>
                                                        <span>Formatting Code</span>
                                                    </div>
                                                    <div class="text-truncate">
                                                        <span>2m 18s</span>
                                                    </div>
                                                </a>
                                                <a class="mb-2 d-flex justify-content-between align-items-center text-inherit disableClick"
                                                    id="course-project-tab3" data-bs-toggle="pill" href="#"
                                                    role="tab" aria-controls="course-project" aria-selected="false">
                                                    <div class="text-truncate">
                                                        <span
                                                            class="icon-shape bg-light text-secondary icon-sm rounded-circle me-2"><i
                                                                class="fe fe-lock fs-6"></i></span>
                                                        <span>Detecting and Fixing Errors</span>
                                                    </div>
                                                    <div class="text-truncate">
                                                        <span>3m 14s</span>
                                                    </div>
                                                </a>
                                                <a class="mb-2 d-flex justify-content-between align-items-center text-inherit disableClick"
                                                    id="course-website-tab3" data-bs-toggle="pill" href="#"
                                                    role="tab" aria-controls="course-website" aria-selected="false">
                                                    <div class="text-truncate">
                                                        <span
                                                            class="icon-shape bg-light text-secondary icon-sm rounded-circle me-2"><i
                                                                class="fe fe-lock fs-6"></i></span>
                                                        <span>Case Sensitivity</span>
                                                    </div>
                                                    <div class="text-truncate">
                                                        <span>1m 48s</span>
                                                    </div>
                                                </a>
                                                <a class="mb-2 d-flex justify-content-between align-items-center text-inherit disableClick"
                                                    id="course-development-tab3" data-bs-toggle="pill" href="#"
                                                    role="tab" aria-controls="course-development"
                                                    aria-selected="false">
                                                    <div class="text-truncate">
                                                        <span
                                                            class="icon-shape bg-light text-secondary icon-sm rounded-circle me-2"><i
                                                                class="fe fe-lock fs-6"></i></span>
                                                        <span>Commenting Code</span>
                                                    </div>
                                                    <div class="text-truncate">
                                                        <span>2m 24s</span>
                                                    </div>
                                                </a>
                                                <a class="mb-0 d-flex justify-content-between align-items-center text-inherit disableClick"
                                                    id="course-intro-tab3" data-bs-toggle="pill" href="#"
                                                    role="tab" aria-controls="course-intro" aria-selected="false">
                                                    <div class="text-truncate">
                                                        <span
                                                            class="icon-shape bg-light text-secondary icon-sm rounded-circle me-2"><i
                                                                class="fe fe-lock fs-6"></i></span>
                                                        <span>Summary</span>
                                                    </div>
                                                    <div class="text-truncate">
                                                        <span>2m 14s</span>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="simplebar-placeholder" style="width: 378px; height: 691px;"></div>
                </div>
                <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                    <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
                </div>
                <div class="simplebar-track simplebar-vertical" style="visibility: hidden;">
                    <div class="simplebar-scrollbar" style="height: 0px; display: none;"></div>
                </div>
            </ul>
        </section>
    </main>
@endsection
