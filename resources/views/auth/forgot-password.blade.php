{{-- <x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}

@extends('layouts.app')
@section('content')
    <main>
        {{-- <x-auth-session-status class="mb-4" :status="session('status')" /> --}}
        <section class="container d-flex flex-column vh-75 my-8 justify-content-center">
            <div class="row align-items-center justify-content-center g-0 h-lg-100 my-8">
                <div class="col-lg-5 col-md-8 py-xl-0">
                    <!-- Card -->
                    <div class="card shadow">
                        <!-- Card body -->
                        <div class="card-body p-6 d-flex flex-column gap-4 pb-4">
                            <x-auth-session-status class="mb-4" :status="session('status')" />
                            <div>
                                {{-- <a href="../index.html"><img src="../assets/images/brand/logo/logo-icon.svg" class="mb-4"
                                        alt="logo-icon" /></a> --}}
                                <div class="d-flex flex-column gap-1">
                                    <h1 class="mb-0 fw-bold">Lupa Kata Sandi</h1>
                                    <p class="mb-0">Isi formulir untuk mengatur ulang kata sandi Anda.</p>
                                </div>
                            </div>
                            <!-- Form -->
                            <form class="needs-validation" method="POST" action="{{ route('password.email') }}">
                                @csrf
                                <!-- Email -->
                                <div class="mb-2">
                                    <x-input-label for="email" :value="__('Email')" />
                                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                        :value="old('email')" required autofocus />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>
                                <!-- Button -->
                                <div class="d-flex align-items-center justify-content-end mt-3">
                                    <x-primary-button>
                                        {{ __('Kirim Email Atur Ulang Kata Sandi') }}
                                    </x-primary-button>
                                </div>
                                <div class="mt-2">
                                    Kembali ke
                                    <a href="{{ route('login') }}">masuk</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
