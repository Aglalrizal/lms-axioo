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
                                <x-auth-session-status class="mb-4" :status="session('status')" />
                                <h1 class="mb-0 fw-bold">Reset Password</h1>
                            </div>
                        </div>
                        <!-- Form -->
                        <form method="POST" action="{{ route('password.store') }}">
                            @csrf
                            <!-- Password Reset Token -->
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">
                            <!-- Email -->
                            <div class="mb-3">
                                <x-input-label for="email" :value="__('Email')" />
                                {{-- <x-text-input id="email" type="email" name="email" :value="old('email')" required
                                    autocomplete="email" /> --}}
                                <input class="form-control disabled" type="email" id="email" name="email" readonly
                                    value="{{ $request->query('email') }}">
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                            <!-- Password -->
                            <div class="mb-3">
                                <x-input-label for="password" :value="__('Password')" />

                                <x-password-input></x-password-input>

                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                            {{-- Password Confirmation --}}
                            <div class="mb-3">
                                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                                <x-password-input :id="__('password_confirmation')" :name="__('password_confirmation')"></x-password-input>
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>
                            <div>
                                <div class="d-grid">
                                    <x-primary-button type="submit">{{ __('Reset Password') }}</x-primary-button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
