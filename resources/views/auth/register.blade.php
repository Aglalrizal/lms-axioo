@extends('layouts.app')
@section('content')
    <section class="container d-flex flex-column vh-75 my-8 justify-content-center">
        <div class="row align-items-center justify-content-center g-0 h-lg-100">
            <div class="col-lg-5 col-md-8 py-xl-0">
                <!-- Card -->
                <div class="card shadow">
                    <!-- Card body -->
                    <div class="card-body p-6 d-flex flex-column gap-4">
                        <div>
                            {{-- <a href="../index.html"><img src="../assets/images/brand/logo/logo-icon.svg" class="mb-4"
                                    alt="logo" /></a> --}}
                            <div class="d-flex flex-column gap-1">
                                <h1 class="mb-0 fw-bold">Sign up</h1>
                                <span>
                                    Already have an account?
                                    <a href="{{ route('login') }}" class="ms-1">Sign in</a>
                                </span>
                            </div>
                        </div>
                        <!-- Form -->
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <!-- Username -->
                            <div class="mb-3">
                                <x-input-label for="username" :value="__('Username')"></x-input-label>
                                <x-text-input id="username" type="username" name="username" :value="old('username')" required
                                    autocomplete="username" />
                                <x-input-error :messages="$errors->get('username')" class="mt-2" />
                            </div>
                            <!-- Email -->
                            <div class="mb-3">
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" type="email" name="email" :value="old('email')" required
                                    autocomplete="email" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                            <!-- Password -->
                            <div class="mb-3">
                                <x-input-label for="password" :value="__('Password')" />

                                <x-text-input id="password" type="password" name="password" required
                                    autocomplete="new-password" />

                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                            {{-- Password Confirmation --}}
                            <div class="mb-3">
                                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                                <x-text-input id="password_confirmation" type="password" name="password_confirmation"
                                    required autocomplete="new-password" />
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>
                            <!-- Checkbox -->
                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="agreeCheck" required />
                                    <label class="form-check-label" for="agreeCheck">
                                        <span>
                                            I agree to the
                                            <a href="terms-condition-page.html">Terms of Service</a>
                                            and
                                            <a href="terms-condition-page.html">Privacy Policy.</a>
                                        </span>
                                    </label>
                                    <div class="invalid-feedback">You must agree before submitting.</div>
                                </div>
                            </div>
                            <div>
                                <!-- Button -->
                                <div class="d-grid">
                                    <x-primary-button type="submit">Create Account</x-primary-button>
                                </div>
                            </div>
                        </form>
                        <div class="d-flex align-items-center">
                            <hr class="flex-grow-1">
                            <span class="mx-2 text-muted">or</span>
                            <hr class="flex-grow-1">
                        </div>
                        {{-- Login with Google Button --}}
                        <x-google-button title="Sign Up"></x-google-button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
