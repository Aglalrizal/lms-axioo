@extends('layouts.app')
@section('content')
    <section class="container d-flex flex-column vh-75 justify-content-center my-6">
        <div class="row align-items-center justify-content-center g-0 h-lg-100">
            <div class="col-lg-5 col-md-8 py-xl-0">
                <!-- Card -->
                <div class="card shadow">
                    <!-- Card body -->
                    <div class="card-body p-6 d-flex flex-column gap-4">
                        <x-auth-session-status class="mb-4" :status="session('status')" />
                        <div>
                            {{-- <a href="../index.html"><img src="../assets/images/brand/logo/logo-icon.svg" class="mb-4"
                                    alt="logo-icon" /></a> --}}
                            <div class="d-flex flex-column gap-1">
                                <h1 class="mb-0 fw-bold">Sign in</h1>
                                <span>
                                    Don’t have an account?
                                    <a href="{{ route('register') }}" class="ms-1">Sign up</a>
                                </span>
                            </div>
                        </div>
                        <!-- Form -->
                        <form class="needs-validation" method="POST" action="{{ route('login') }}">
                            @csrf
                            <!-- Username -->
                            <div class="mb-3">
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" type="email" name="email" :value="old('email')" required
                                    autofocus autocomplete="username" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                            <!-- Password -->
                            <div class="mb-3">
                                <x-input-label for="password" :value="__('Password')" />

                                <x-password-input></x-password-input>

                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                            <!-- Checkbox -->
                            <div class="d-lg-flex justify-content-between align-items-center mb-4">
                                {{-- <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="rememberme" required />
                                    <label class="form-check-label" for="rememberme">Remember me</label>
                                    <div class="invalid-feedback">You must agree before submitting.</div>
                                </div> --}}
                                <div>
                                    <a href="{{ route('password.email') }}">Forgot your password?</a>
                                </div>
                            </div>
                            <div>
                                <!-- Button -->
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Sign in</button>
                                </div>
                            </div>
                        </form>
                        <div class="d-flex align-items-center">
                            <hr class="flex-grow-1">
                            <span class="mx-2 text-muted">or</span>
                            <hr class="flex-grow-1">
                        </div>
                        <x-google-button title="Login"></x-google-button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script>
        setUpPasswordToggle()
    </script>
@endsection
