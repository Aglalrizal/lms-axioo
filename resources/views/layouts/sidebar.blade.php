<nav class="navbar-vertical navbar">
    <div class="vh-100" data-simplebar>
        <!-- Brand logo -->
        <a class="navbar-brand text-center" href="/"><img src="{{ asset('assets/images/upmyskill_logo_light.png') }}"
                alt="UpMysSkill" style="height: 50px; width: auto;filter:brightness(0) invert(1)" /></a>
        <!-- Navbar nav -->

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
        @role('super-admin')
            @include('partials.sidebar.super-admin')
            @elserole('admin')
            @include('partials.sidebar.admin')
            @elserole('instructor')
            @include('partials.sidebar.instructor')
            @elserole('student')
            @include('partials.sidebar.student')
        @endrole
    </div>
</nav>
