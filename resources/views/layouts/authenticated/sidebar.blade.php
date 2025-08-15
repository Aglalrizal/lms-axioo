<div class="position-relative">
    <nav class="navbar navbar-expand-lg sidenav sidenav-navbar">
        <!-- Menu -->
        <a class="d-xl-none d-lg-none d-block text-inherit fw-bold" href="#">Menu</a>
        <!-- Button -->

        <button class="navbar-toggler d-lg-none icon-shape icon-sm rounded bg-primary text-light" type="button"
            data-bs-toggle="collapse" data-bs-target="#sidenavNavbar" aria-controls="sidenavNavbar" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="fe fe-menu"></span>
        </button>

        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenavNavbar">
            <div class="navbar-nav flex-column mt-4 mt-lg-0 d-flex flex-column gap-3">
                <div class="text-center ">
                    <img @if ($user->profile_picture_path) src="{{ asset($user->profile_picture_path) }}"
                    @else src="{{ asset('../assets/images/avatar/avatar-1.jpg') }}" @endif
                        class="rounded-circle avatar-xl mb-3" alt="">
                    <p class="mb-0 fw-bold">{{ $user->first_name }} {{ $user->surname }}</p>
                    <p class="mb-0">{{ $user->username }}</p>
                </div>
                <ul class="list-unstyled mb-0">
                    <!-- Nav item -->

                    <li class="nav-item">
                        <a class="nav-link @if (request()->routeIs('user.dashboard')) active @endif"
                            href="{{ route('user.dashboard') }}">
                            <i class="fe fe-home nav-icon"></i>
                            Dashboard
                        </a>
                    </li>
                    <!-- Nav item -->
                    <li class="nav-item">
                        <a class="nav-link @if (request()->routeIs('user.dashboard.courses')) active @endif"
                            href="{{ route('user.dashboard.courses') }}">
                            <i class="fe fe-award nav-icon"></i>
                            Kursus saya
                        </a>
                    </li>
                    <!-- Nav item -->
                    <li class="nav-item">
                        <a class="nav-link @if (request()->routeIs('user.dashboard.certificates')) active @endif"
                            href="{{ route('user.dashboard.certificates') }}">
                            <i class="fe fe-file-text nav-icon"></i>
                            Sertifikat
                        </a>
                    </li>
                    <!-- Nav item -->
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fe fe-folder nav-icon"></i>
                            Program
                        </a>
                    </li>
                    <!-- Nav item -->
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fe fe-credit-card nav-icon"></i>
                            Transaksi
                        </a>
                    </li>
                </ul>
                <!-- Navbar header -->
                <div class="d-flex flex-column gap-1">
                    <span class="navbar-header">Account Settings</span>
                    <ul class="list-unstyled mb-0">
                        <!-- Nav item -->
                        <li class="nav-item ">
                            <a class="nav-link @if (request()->routeIs('user.dashboard.account')) active @endif"
                                href="{{ route('user.dashboard.account') }}">
                                <i class="fe fe-settings nav-icon"></i>
                                Akun
                            </a>
                        </li>
                        <!-- Nav item -->
                        <li class="nav-item">
                            <a class="nav-link @if (request()->routeIs('user.dashboard.profile')) active @endif"
                                href="{{ route('user.dashboard.profile', $user) }}">
                                <i class="fe fe-user nav-icon"></i>
                                Profil
                            </a>
                        </li>
                        <!-- Nav item -->
                        <li class="nav-item">
                            <a class="nav-link" href="../index.html">
                                <i class="fe fe-power nav-icon"></i>
                                Sign Out
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</div>
