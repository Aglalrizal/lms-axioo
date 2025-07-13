@extends('layouts.app')
@section('content')
    <main>
        <section class="py-8 bg-light">
            <div class="container">
                <div class="row">
                    <div class="offset-md-2 col-md-8 col-12">
                        <!-- caption-->
                        <h1 class="fw-bold mb-0 display-4 lh-1">Support</h1>
                    </div>
                </div>
            </div>
        </section>
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
                                    <li class="breadcrumb-item active" aria-current="page">Support</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- container  -->
        <section class="py-8">
            <div class="container my-lg-4">
                <div class="row">
                    <div class="offset-md-2 col-md-8 col-12">
                        <div class="d-flex flex-column gap-3">
                            <div class="d-flex flex-column gap-8">
                                <!-- lead  -->
                                <p class="lead mb-0">Can’t find the answer you’re looking for? Don't worry! Get in touch
                                    with the Docs Support team, we will be glad to assist you.</p>
                                <div class="d-flex justify-content-between">
                                    <span>Contact Information</span>
                                    <div class="text-end">
                                        <span>(123) 456 789</span>
                                        <a href="#">contact@geeks.com</a>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <!-- card -->
                                <livewire:support-ticket-create />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
