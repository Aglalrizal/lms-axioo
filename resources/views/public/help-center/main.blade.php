@extends('layouts.app')
@section('content')
    <main>
        <!-- Page Content -->
        <section class="py-8 bg-light">
            <div class="container my-lg-8">
                <div class="row align-items-center justify-content-center gy-2">
                    <div class="col-md-6 col-12">
                        <!-- caption-->
                        <div class="d-flex flex-column gap-5">
                            <div class="d-flex flex-column gap-1">
                                <h1 class="fw-bold mb-0 display-3">How can we help you?</h1>
                                <!-- para -->
                                <p class="mb-0 text-dark">Have questions? Search through our Help Center</p>
                            </div>
                            <div class="d-flex flex-column gap-2">
                                <div class="pe-md-6">
                                    <!-- input  -->
                                    <form class="d-flex align-items-center">
                                        <span class="position-absolute ps-3">
                                            <i class="fe fe-search"></i>
                                        </span>
                                        <label for="SearchHelp" class="visually-hidden">Search Help</label>
                                        <!-- input  -->
                                        <input type="search" id="SearchHelp"
                                            class="form-control ps-6 border-0 py-3 smooth-shadow-md"
                                            placeholder="Enter a question, topic or keyword" />
                                    </form>
                                </div>
                                <span class="d-block">... or choose a category to quickly find the help you need</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="d-flex align-items-center justify-content-end">
                            <!-- img  -->
                            <img src="../assets/images/png/3d-girl.png" alt="girlsetting" class="text-center img-fluid" />
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="mt-n8">
            <!-- container  -->
            <div class="container">
                <div class="card rounded-3 shadow-sm">
                    <div class="row">
                        <div class="col-md-4 col-12 border-end-md">
                            <!-- features  -->
                            <div class="border-bottom border-bottom-md-0 mb-3 mb-lg-0">
                                <div class="p-5">
                                    <div class="mb-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-help-circle text-primary">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                                            <line x1="12" y1="17" x2="12.01" y2="17">
                                            </line>
                                        </svg>
                                    </div>
                                    <!-- heading  -->
                                    <h3 class="fw-semibold"><a href="{{ route('public.help-center.faqs') }}"
                                            class="text-inherit">FAQs</a>
                                    </h3>
                                    <!-- para  -->
                                    <p>FAQ, short for frequently asked questions, is a list of commonly asked questions
                                        and answers about a specific topic.</p>
                                    <!-- button  -->
                                    <a href="{{ route('public.help-center.faqs') }}" class="link-primary fw-semibold">
                                        View FAQ
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-12 border-end-md">
                            <!-- features  -->
                            <div class="border-bottom border-bottom-md-0 mb-3 mb-lg-0">
                                <div class="p-5">
                                    <div class="mb-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-book text-primary">
                                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <!-- heading  -->
                                    <h3 class="fw-semibold"><a href="{{ route('public.help-center.guide') }}"
                                            class="text-inherit">Guides
                                            & Resources</a></h3>
                                    <!-- para  -->
                                    <p>UI Style Guides are a design & development tool that brings cohesion to a digital
                                        product user interface & experience</p>
                                    <!-- button  -->
                                    <a href="{{ route('public.help-center.guide') }}" class="link-primary fw-semibold">
                                        Browse Guides
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div>
                                <div class="p-5">
                                    <div class="mb-4">
                                        <!-- features  -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40"
                                            viewBox="0 0 24 24" fill="none" stroke="#754ffe" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-life-buoy text-primary">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <circle cx="12" cy="12" r="4"></circle>
                                            <line x1="4.93" y1="4.93" x2="9.17" y2="9.17">
                                            </line>
                                            <line x1="14.83" y1="14.83" x2="19.07" y2="19.07">
                                            </line>
                                            <line x1="14.83" y1="9.17" x2="19.07" y2="4.93">
                                            </line>
                                            <line x1="14.83" y1="9.17" x2="18.36" y2="5.64">
                                            </line>
                                            <line x1="4.93" y1="19.07" x2="9.17" y2="14.83">
                                            </line>
                                        </svg>
                                    </div>
                                    <!-- heading  -->
                                    <h3 class="fw-semibold"><a href="{{ route('public.help-center.support') }}"
                                            class="text-inherit">Support</a></h3>
                                    <!-- para  -->
                                    <p>The good news is that youre not alone, and youre in the right place. Contact us
                                        for more detailed support.</p>
                                    <!-- button  -->
                                    <a href="{{ route('public.help-center.support') }}" class="link-primary fw-semibold">
                                        Submit a Request
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- container  -->
        <section class="py-8">
            <div class="container my-lg-8">
                <div class="row">
                    <div class="offset-lg-2 col-lg-6 col-12">
                        <div class="mb-8 pe-lg-8">
                            <!-- heading  -->
                            <h2 class="mb-4 h1 fw-semibold">Most frequently asked questions</h2>
                            <p class="lead">Here are the most frequently asked questions you may check before getting
                                started</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="offset-lg-2 col-lg-8 col-12">
                        <!-- accordions  -->
                        <div class="accordion accordion-flush" id="accordionExample">
                            @foreach ($faqs as $faq)
                                <div class="border p-3 rounded-3 mb-2" id="heading{{ $faq->id }}">
                                    <h3 class="mb-0 fs-4">
                                        <a href="#" class="d-flex align-items-center text-inherit"
                                            data-bs-toggle="collapse" data-bs-target="#collapse{{ $faq->id }}"
                                            @if ($loop->first) aria-expanded="true" @else aria-expanded="false" @endif
                                            aria-controls="collapse{{ $faq->id }}">
                                            <span class="me-auto">{{ $faq->question }}</span>
                                            <span class="collapse-toggle ms-4">
                                                <i class="fe fe-chevron-down"></i>
                                            </span>
                                        </a>
                                    </h3>
                                    <!-- collapse  -->
                                    <div id="collapse{{ $faq->id }}"
                                        class="collapse @if ($loop->first) show @endif"
                                        aria-labelledby="heading{{ $faq->id }}" data-bs-parent="#accordionExample">
                                        <div class="pt-2">
                                            {{ $faq->answer }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- container  -->
        <section class="py-8">
            <div class="container">
                <div class="row">
                    <div class="offset-lg-2 col-lg-4 col-12">
                        <div class="mb-8">
                            <h2 class="mb-0 h1 fw-semibold">Can't find what you're looking for?</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="offset-lg-2 col-lg-8 col-12">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <!-- card  -->
                                <div class="card border mb-md-0 mb-4">
                                    <!-- card body  -->
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-help-circle text-primary">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                                                <line x1="12" y1="17" x2="12.01" y2="17">
                                                </line>
                                            </svg>
                                        </div>
                                        <!-- para  -->
                                        <h3 class="mb-2 fw-semibold">Contact us</h3>
                                        <p>Geeks is here to help. We can provide you with the support you need. Just
                                            contact us and our team will reply quick to you.</p>
                                        <!-- btn  -->
                                        <a href="#" class="btn btn-primary btn-sm">Contact us</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <!-- card  -->
                                <div class="card border">
                                    <!-- card body  -->
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40"
                                                viewBox="0 0 24 24" fill="none" stroke="#754ffe" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-life-buoy text-primary">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <circle cx="12" cy="12" r="4"></circle>
                                                <line x1="4.93" y1="4.93" x2="9.17" y2="9.17">
                                                </line>
                                                <line x1="14.83" y1="14.83" x2="19.07" y2="19.07">
                                                </line>
                                                <line x1="14.83" y1="9.17" x2="19.07" y2="4.93">
                                                </line>
                                                <line x1="14.83" y1="9.17" x2="18.36" y2="5.64">
                                                </line>
                                                <line x1="4.93" y1="19.07" x2="9.17" y2="14.83">
                                                </line>
                                            </svg>
                                        </div>
                                        <!-- para  -->
                                        <h3 class="mb-2 fw-semibold">Support</h3>
                                        <p>The good news is that you’re not alone, and you’re in the right place.
                                            Contact us for more detailed support.</p>
                                        <!-- btn  -->
                                        <a href="help-center-support.html" class="btn btn-outline-secondary btn-sm">Submit
                                            a Ticket</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
