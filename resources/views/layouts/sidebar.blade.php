<nav class="navbar-vertical navbar">
    <div class="vh-100" data-simplebar>
        <!-- Brand logo -->
        <a class="navbar-brand" href="/">
            <img src="{{ asset('assets/images/brand/logo/logo-inverse.svg') }}" alt="UpMySkill" />
        </a>
        <!-- Navbar nav -->
        <ul class="navbar-nav flex-column" id="sideNavbar">
            {{-- <li class="nav-item">
                <a class="nav-link " href="#" data-bs-toggle="collapse" data-bs-target="#navDashboard"
                    aria-expanded="false" aria-controls="navDashboard">
                    <i class="nav-icon fe fe-home me-2"></i>
                    Dashboard
                </a>
                <div id="navDashboard" class="collapse  show " data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link  active " href="../../pages/dashboard/admin-dashboard.html">Overview</a>
                        </li>
                        <!-- Nav item -->
                        <li class="nav-item">
                            <a class="nav-link " href="../../pages/dashboard/dashboard-analytics.html">Analytics</a>
                        </li>
                    </ul>
                </div>
            </li> --}}
            <!-- Nav item -->
            <li class="nav-item">
                <a class="nav-link  collapsed " href="#" data-bs-toggle="collapse" data-bs-target="#navProfile"
                    aria-expanded="false" aria-controls="navProfile">
                    <i class="nav-icon fe fe-user me-2"></i>
                    User
                </a>
                <div id="navProfile" class="collapse " data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('admin.users.all') }}">All</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="../../pages/dashboard/admin-instructor.html">Instructor</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="../../pages/dashboard/admin-students.html">Students</a>
                        </li>
                    </ul>
                </div>
            </li>
            <!-- Nav item -->
            <li class="nav-item">
                <a class="nav-link  collapsed " href="#" data-bs-toggle="collapse" data-bs-target="#navCMS"
                    aria-expanded="false" aria-controls="navCMS">
                    <i class="nav-icon fe fe-book-open me-2"></i>
                    CMS
                </a>
                <div id="navCMS" class="collapse " data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('admin.faq') }}">FAQ</a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav>
