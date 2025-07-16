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
                <div id="navProfile" class="collapse {{ request()->is('admin/user/*') ? 'show' : '' }}"
                    data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                        @foreach (\Spatie\Permission\Models\Role::all() as $role)
                            <li class="nav-item">
                                <a class="nav-link"
                                    href="{{ route('admin.user', ['role' => $role->name]) }}">{{ Str::of($role->name)->replace('-', ' ')->title() }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="#" data-bs-toggle="collapse" data-bs-target="#navCourses"
                    aria-expanded="false" aria-controls="navCourses">
                    <i class="nav-icon fe fe-book me-2"></i>
                    Courses
                </a>
                <div id="navCourses" class="collapse {{ request()->is('admin/course/*') ? 'show' : '' }}"
                    data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link " href="../../pages/dashboard/admin-course-overview.html">All Courses</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.course.category') }}">Courses
                                Category</a>
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
                <div id="navCMS" class="collapse {{ request()->is('admin/cms/*') ? 'show' : '' }}"
                    data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('admin.cms.faqs') }}">FAQs</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('admin.cms.support-ticket.index') }}">Support
                                Tickets</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link  collapsed " href="#" data-bs-toggle="collapse" data-bs-target="#navReport"
                    aria-expanded="false" aria-controls="navReport">
                    <i class="bi bi-card-checklist me-2"></i>
                    Report
                </a>
                <div id="navReport" class="collapse {{ request()->is('admin/report/*') ? 'show' : '' }}"
                    data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('admin.report.activity-log') }}">Activity Log</a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav>
