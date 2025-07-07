@extends('layouts.app')
@section('content')
    <main>
        <div class="py-8 bg-light">
            <div class="container">
                <div class="row">
                    <div class="offset-md-2 col-md-8 col-12">
                        <!-- caption-->
                        <h1 class="fw-bold mb-1 display-4">Frequently Asked Questions</h1>
                    </div>
                </div>
            </div>
        </div>
        <!-- container  -->
        <div class="pt-3">
            <div class="container">
                <div class="row">
                    <div class="offset-md-2 col-md-8 col-12">
                        <div>
                            <!-- breadcrumb  -->
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="help-center.html">Help Center</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Faq</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <section class="py-8">
            <div class="container">
                {{-- <div class="row mb-6">
                    <div class="offset-md-2 col-md-8 col-12">
                        <div class="d-flex flex-column gap-4">
                            <div>
                                <h2 class="mb-0 fw-semibold">Most asked</h2>
                            </div>
                            <div class="accordion accordion-flush" id="accordionExample">
                                @foreach ($most_asked as $faq)
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
                <div class="row mb-6">
                    <div class="offset-md-2 col-md-8 col-12">
                        <div class="d-flex flex-column gap-4">
                            <div class="">
                                <h2 class="mb-0 fw-semibold">General inquiries</h2>
                            </div>
                            <!-- accordion  -->
                            <div class="accordion accordion-flush" id="accordionExample2">
                                @foreach ($general as $faq)
                                    <div class="border p-3 rounded-3 mb-2" id="heading{{ $faq->id }}">
                                        <h3 class="mb-0 fs-4">
                                            <a href="#" class="d-flex align-items-center text-inherit"
                                                data-bs-toggle="collapse" data-bs-target="#collapse{{ $faq->id }}"
                                                aria-expanded="false" aria-controls="collapse{{ $faq->id }}">
                                                <span class="me-auto">{{ $faq->question }}</span>
                                                <span class="collapse-toggle ms-4">
                                                    <i class="fe fe-chevron-down"></i>
                                                </span>
                                            </a>
                                        </h3>
                                        <!-- collapse  -->
                                        <div id="collapse{{ $faq->id }}" class="collapse"
                                            aria-labelledby="heading{{ $faq->id }}"
                                            data-bs-parent="#accordionExample">
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
                <div class="row">
                    <div class="offset-md-2 col-md-8 col-12">
                        <div class="d-flex flex-column gap-4">
                            <div class="">
                                <h2 class="mb-0 fw-semibold">Support</h2>
                            </div>
                            <div class="accordion accordion-flush" id="accordionExample3">
                                @foreach ($support as $faq)
                                    <div class="border p-3 rounded-3 mb-2" id="heading{{ $faq->id }}">
                                        <h3 class="mb-0 fs-4">
                                            <a href="#" class="d-flex align-items-center text-inherit"
                                                data-bs-toggle="collapse" data-bs-target="#collapse{{ $faq->id }}"
                                                aria-expanded="false" aria-controls="collapse{{ $faq->id }}">
                                                <span class="me-auto">{{ $faq->question }}</span>
                                                <span class="collapse-toggle ms-4">
                                                    <i class="fe fe-chevron-down"></i>
                                                </span>
                                            </a>
                                        </h3>
                                        <!-- collapse  -->
                                        <div id="collapse{{ $faq->id }}" class="collapse"
                                            aria-labelledby="heading{{ $faq->id }}"
                                            data-bs-parent="#accordionExample">
                                            <div class="pt-2">
                                                {{ $faq->answer }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div> --}}
                @foreach ($categories as $category)
                    <div class="row mb-6">
                        <div class="offset-md-2 col-md-8 col-12">
                            <div class="d-flex flex-column gap-4">
                                <div>
                                    <h2 class="mb-0 fw-semibold">{{ Str::title($category->name) }}</h2>
                                </div>
                                <div class="accordion accordion-flush" id="accordionExample">
                                    @foreach ($category->faqs->sortBy('order') as $faq)
                                        <div class="border p-3 rounded-3 mb-2" id="heading{{ $faq->id }}">
                                            <h3 class="mb-0 fs-4">
                                                <a href="#" class="d-flex align-items-center text-inherit"
                                                    data-bs-toggle="collapse" data-bs-target="#collapse{{ $faq->id }}"
                                                    aria-expanded="false" aria-controls="collapse{{ $faq->id }}">
                                                    <span class="me-auto">{{ $faq->question }}</span>
                                                    <span class="collapse-toggle ms-4">
                                                        <i class="fe fe-chevron-down"></i>
                                                    </span>
                                                </a>
                                            </h3>
                                            <!-- collapse  -->
                                            <div id="collapse{{ $faq->id }}" class="collapse"
                                                aria-labelledby="heading{{ $faq->id }}"
                                                data-bs-parent="#accordionExample">
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
                @endforeach
            </div>
        </section>
    </main>
@endsection
