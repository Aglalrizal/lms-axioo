<ul class="navbar-nav flex-column" id="sideNavbar">
    <li class="nav-item">
        <a class="nav-link {{ Route::is('*dashboard*') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
            <i class="nav-icon fe fe-home me-2"></i>
            Dashboard
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link  collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#navProfile"
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
        <a class="nav-link " href="#" data-bs-toggle="collapse" data-bs-target="#navCourses" aria-expanded="false"
            aria-controls="navCourses">
            <i class="nav-icon fe fe-book me-2"></i>
            Kursus
        </a>
        <div id="navCourses" class="collapse {{ request()->is('admin/course/*') ? 'show' : '' }}"
            data-bs-parent="#sideNavbar">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link " href="{{ route('admin.course.all') }}">Seluruh Kursus</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="{{ route('admin.course.published') }}">Kursus Aktif</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.course.category') }}">Kursus Kategori</a>
                </li>
            </ul>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link " href="#" data-bs-toggle="collapse" data-bs-target="#navCMS" aria-expanded="false"
            aria-controls="navCMS">
            <i class="nav-icon fe fe-settings me-2"></i>
            CMS
        </a>
        <div id="navCMS" class="collapse {{ request()->is('admin/cms/*') ? 'show' : '' }}"
            data-bs-parent="#sideNavbar">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link " href="{{ route('admin.cms.blog.index') }}">Blogs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.cms.faqs') }}">Faqs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.cms.about-us') }}">Tentang Kami</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.cms.our-team') }}">Tim Kami</a>
                </li>
            </ul>
        </div>
    </li>
    <!-- Nav item -->
    <li class="nav-item">
        <a class="nav-link {{ Route::is('*quiz*') ? 'active' : '' }}" href="{{ route('quiz.index') }}">
            <i class="nav-icon fe fe-book-open me-2"></i>
            Kuis
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Route::is('*support-tickets*') ? 'active' : '' }}"
            href="{{ route('admin.support-ticket.index') }}">
            <i class="nav-icon fe fe-inbox me-2"></i>
            Support Tickets
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link  collapsed " data-bs-toggle="collapse" data-bs-target="#navReport" aria-expanded="false"
            aria-controls="navReport">
            <i class="bi bi-card-checklist me-2"></i>
            Laporan
        </a>
        <div id="navReport" class="collapse {{ request()->is('admin/report/*') ? 'show' : '' }}"
            data-bs-parent="#sideNavbar">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link " href="{{ route('admin.report.activity-log') }}">Log Aktivitas</a>
                </li>
            </ul>
        </div>
    </li>
</ul>
