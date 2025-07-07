<nav class="navbar navbar-expand navbar-transparent shadow-none">
    <div class="container px-0">
        <div class="d-flex align-items-center">
            <a class="navbar-brand me-4" href="/"><img src="../assets/images/brand/logo/logo.svg" alt="Geeks" />
            </a>

            <ul class="list-unstyled mb-0 lh-1">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-dark" href="#" id="navbarBrowse"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-bs-display="static">
                        Help Center
                    </a>
                    <ul class="dropdown-menu dropdown-menu-arrow" aria-labelledby="navbarBrowse">
                        <li>
                            <a class="dropdown-item" href="{{ route('public.help-center') }}">Help Center</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('public.help-center.faqs') }}">FAQ's</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('public.help-center.guide') }}">Guide</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">Guide
                                Single</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('public.help-center.support') }}l">Support</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <div class="ms-auto d-flex align-items-center">
        <div class="dropdown me-2">
            <button class="btn btn-light btn-icon rounded-circle d-flex align-items-center" type="button"
                aria-expanded="false" data-bs-toggle="dropdown" aria-label="Toggle theme (auto)">
                <i class="bi theme-icon-active"></i>
                <span class="visually-hidden bs-theme-text">Toggle theme</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bs-theme-text">
                <li>
                    <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light"
                        aria-pressed="false">
                        <i class="bi theme-icon bi-sun-fill"></i>
                        <span class="ms-2">Light</span>
                    </button>
                </li>
                <li>
                    <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark"
                        aria-pressed="false">
                        <i class="bi theme-icon bi-moon-stars-fill"></i>
                        <span class="ms-2">Dark</span>
                    </button>
                </li>
                <li>
                    <button type="button" class="dropdown-item d-flex align-items-center active"
                        data-bs-theme-value="auto" aria-pressed="true">
                        <i class="bi theme-icon bi-circle-half"></i>
                        <span class="ms-2">Auto</span>
                    </button>
                </li>
            </ul>
        </div>
        <div class="d-flex align-items-center">
            <a href="#" class="ms-2 me-md-4 text-dark" data-bs-toggle="collapse" data-bs-target="#collapseExample"
                aria-expanded="false" aria-controls="collapseExample">
                <i class="fe fe-search fs-3"></i>
            </a>
            <a href="../pages/help-center-support.html" class="btn btn-primary d-lg-block d-none">Submit
                Ticket</a>
        </div>
    </div>
    <!-- Collapse -->
</nav>
