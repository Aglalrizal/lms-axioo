<ul class="navbar-nav flex-column" id="sideNavbar">
    <li class="nav-item">
        <a class="nav-link {{ Route::is('*dashboard*') ? 'active' : '' }}" href="{{ route('user.dashboard') }}">
            <i class="nav-icon fe fe-home me-2"></i>
            Home
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Route::is('*course*') ? 'active' : '' }}" href="{{ route('user.dashboard.courses') }}">
            <i class="nav-icon fe fe-book-open me-2"></i>
            Kursus Saya
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('user.dashboard.certificates') }}">
            <i class="nav-icon fe fe-file-text me-2"></i>
            Sertifikat
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="nav-icon fe fe-folder me-2"></i>
            Program
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="nav-icon fe fe-credit-card me-2"></i>
            Transaksi
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link  collapsed " data-bs-toggle="collapse" data-bs-target="#navSetting" aria-expanded="false"
            aria-controls="navSetting">
            <i class="bi bi-gear me-2"></i>
            Pengaturan
        </a>
        <div id="navSetting" class="collapse {{ request()->is('admin/report/*') ? 'show' : '' }}"
            data-bs-parent="#sideNavbar">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link "
                        href="{{ route('user.dashboard.profile', ['username' => auth()->user()->username]) }}">Profil</a>
                </li>
            </ul>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link " href="{{ route('user.dashboard.account') }}">Akun</a>
                </li>
            </ul>
        </div>
    </li>
</ul>
