<div class="dropdown ms-2 d-inline-block position-static">
    <a class="rounded-circle" href="#" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
        <div class="avatar avatar-md avatar-indicators avatar-online">
            <img alt="{{ auth()->user()->username . '-avatar' }}"
                src="{{ optional(auth()->user())->profile_picture
                    ? asset('storage/' . auth()->user()->profile_picture)
                    : 'https://ui-avatars.com/api/?background=random&name=' . urlencode(optional(auth()->user())->username) }}"
                class="rounded-circle" />
        </div>
    </a>
    <div class="dropdown-menu dropdown-menu-end position-absolute mx-3 my-5">
        <div class="dropdown-item">
            <div class="d-flex">
                <div class="avatar avatar-md avatar-indicators avatar-online">
                    <img alt="{{ auth()->user()->username . '-avatar' }}"
                        src="{{ optional(auth()->user())->profile_picture
                            ? asset('storage/' . auth()->user()->profile_picture)
                            : 'https://ui-avatars.com/api/?background=random&name=' . urlencode(optional(auth()->user())->username) }}"
                        class="rounded-circle" />
                </div>
                <div class="ms-3 lh-1">
                    <h5 class="mb-1">{{ auth()->user()->username ?? 'user' }}</h5>
                    <p class="mb-0">{{ auth()->user()->email }}</p>
                </div>
            </div>
        </div>

        <div class="dropdown-divider"></div>

        <ul class="list-unstyled">
            @php
                $userRole = auth()->user()->getRoleNames()->first();
                $goto = '';
                if ($userRole == 'admin' || $userRole == 'super-admin') {
                    $goto = route('admin.dashboard');
                } elseif ($userRole == 'instructor') {
                    $goto = route('instructor.dashboard');
                }
            @endphp
            <li>
                <a class="dropdown-item" href="{{ $goto }}">
                    <i class="fe fe-home me-2"></i> Dashboard
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="#">
                    <i class="fe fe-user me-2"></i> Profile
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="#">
                    <i class="fe fe-star me-2"></i> Subscription
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="#">
                    <i class="fe fe-settings me-2"></i> Settings
                </a>
            </li>
        </ul>

        <div class="dropdown-divider"></div>

        <ul class="list-unstyled mb-0">
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item bg-transparent border-0">
                        <i class="fe fe-power me-2"></i> Sign Out
                    </button>
                </form>
            </li>
        </ul>
    </div>
</div>
