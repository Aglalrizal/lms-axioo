<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container px-0">
        <a class="navbar-brand" href="/"><img src="{{ asset('assets/images/upmyskill_logo_light.png') }}"
                alt="UpMysSkill" style="height: 40px; width: auto;" /></a>

        <!-- Mobile view nav wrap -->
        <div class="ms-auto d-flex align-items-center order-lg-3">
            <div class="d-flex align-items-center gap-2">
                @auth
                    @php
                        $userRole = auth()->user()->getRoleNames()->first();
                        $goto = '';
                        if ($userRole == 'admin' || $userRole == 'super-admin') {
                            $goto = route('admin.dashboard');
                        } elseif ($userRole == 'instructor') {
                            $goto = route('instructor.dashboard');
                        } else {
                            $goto = route('user.dashboard');
                        }
                    @endphp
                    <ul class="navbar-nav me-3">
                        <li class="nav-item ">
                            <a class="nav-link" href="{{ $goto }}" id="navbarBrowse"
                                aria-haspopup="true"data-bs-display="static">Dashboard</a>
                        </li>
                    </ul>

                    <x-user-dropdown></x-user-dropdown>
                @endauth
                @guest
                    @if (!(Route::is('login') || Route::is('register')))
                        <a href="{{ route('login') }}" class="btn btn-outline-dark">Masuk</a>
                        <a href="{{ route('register') }}" class="btn btn-dark d-none d-md-block">Daftar</a>
                    @endif
                @endguest
            </div>
        </div>

        <div>
            <!-- Burger Button -->
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

            <form class="mt-3 mt-lg-0 ms-lg-5 d-flex align-items-center">
                <span class="position-absolute ps-3 search-icon">
                    <i class="fe fe-search"></i>
                </span>
                <label for="search" class="visually-hidden"></label>
                <input type="search" id="search" class="form-control ps-6 rounded-5" placeholder="Search Courses">
            </form>

            <ul class="navbar-nav mt-3 mt-lg-0 mx-lg-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" href="{{ route('public.about-us') }}" id="navbarBrowse"
                        aria-haspopup="true"data-bs-display="static">Tentang Kami</a>
                </li>

                <li class="nav-item dropdown mx-lg-3 mx-xl-6">
                    <a class="nav-link" href="{{ route('public.course.explore') }}" id="navbarBrowse"
                        aria-haspopup="true"data-bs-display="static">Kursus</a>
                </li>

                {{-- <li class="nav-item dropdown mx-lg-3 mx-xl-6">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarLanding" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">Kursus</a>
                    <ul class="dropdown-menu    " aria-labelledby="navbarLanding">
                        <li>
                            <a href={{ route('public.search', ['category' => 'Axioo']) }} class="dropdown-item">
                                <span>Axioo</span>
                            </a>
                        </li>
                        <li>
                            <a href={{ route('public.search', ['category' => 'Intel']) }} class="dropdown-item">
                                <span>Intel</span>
                            </a>
                        </li>
                    </ul>
                </li> --}}

                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" id="navbarBrowse"
                        aria-haspopup="true"data-bs-display="static">Langganan</a>
                </li>

            </ul>
        </div>
    </div>
</nav>
