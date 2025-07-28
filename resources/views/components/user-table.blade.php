<section class="container-fluid p-4">
    <div class="row">
        <!-- Page Header -->
        <div class="col-lg-12 col-md-12 col-12">
            <div class="border-bottom pb-3 mb-3 d-flex justify-content-between align-items-center">
                <div class="d-flex flex-column gap-1">
                    <h1 class="mb-0 h2 fw-bold">
                        {{ Str::of($role)->replace('-', ' ')->title() }}
                    </h1>
                </div>
                <div class="nav btn-group" role="tablist">
                    @if ($role == 'student')
                        {{-- <button class="btn btn-outline-secondary" data-bs-toggle="modal"
                            data-bs-target="#importUserModal">
                            Import
                        </button> --}}
                        <a href="{{ route('admin.user.import') }}" class="btn btn-outline-secondary">
                            Import
                        </a>
                    @endif
                    <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#createUserModal">
                        Tambah
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- card -->
            <div class="card">
                <!-- card header -->
                <div class="card-header">
                    <input wire:model.live="search" class="form-control"
                        placeholder="Search {{ Str::of($role)->replace('-', ' ')->title() }}" />
                </div>
                <!-- table -->
                <div class="table-responsive">
                    <table class="table mb-0 text-nowrap table-hover table-centered">
                        <thead class="table-light">
                            <tr>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Joined</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center flex-row gap-2">
                                            <img src="{{ optional($user)->profile_picture
                                                ? asset('storage/' . $user->profile_picture)
                                                : 'https://ui-avatars.com/api/?background=random&name=' . urlencode(optional($user)->username) }}"
                                                alt="{{ $user->username . '-avatar' }}"
                                                class="rounded-circle avatar-md" />
                                            <h5 class="mb-0">{{ $user->username }}</h5>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at->translatedFormat('d F, Y') }}</td>

                                    <td>
                                        <div class="hstack gap-4">
                                            <span class="dropdown dropstart">
                                                <a class="btn-icon btn btn-ghost btn-sm rounded-circle" href="#"
                                                    role="button" data-bs-toggle="dropdown" data-bs-offset="-20,20"
                                                    aria-expanded="false">
                                                    <i class="fe fe-more-vertical"></i>
                                                </a>
                                                <span class="dropdown-menu">
                                                    <span class="dropdown-header">Settings</span>
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.user.profile', ['username' => $user->username]) }}">
                                                        <i class="fe fe-user dropdown-item-icon"></i>
                                                        Profile
                                                    </a>
                                                    <button @click="$dispatch('edit-mode',{id:{{ $user->id }}})"
                                                        type="button" class="dropdown-item" data-bs-toggle="modal"
                                                        data-bs-target="#createUserModal">
                                                        <i class="fe fe-edit dropdown-item-icon"></i>
                                                        Edit
                                                    </button>
                                                    <button
                                                        wire:click="$dispatch('delete-user',{id: {{ $user->id }}})"
                                                        class="dropdown-item text-danger">
                                                        <i class="fe fe-trash dropdown-item-icon text-danger"></i>
                                                        Remove
                                                    </button>
                                                </span>
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No users found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <!-- Pagination -->
                    <div class="card-footer">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <livewire:admin.user.create :role="$role" />
    <livewire:admin.user.import />
</section>
<script>
    document.addEventListener('livewire:initialized', () => {
        @this.on('refresh-users', (event) => {
            var createUserModalEl = document.querySelector('#createUserModal')
            var createUserModal = bootstrap.Modal.getOrCreateInstance(createUserModalEl)
            var importUserModalEl = document.querySelector('#importUserModal')
            var importUserModal = bootstrap.Modal.getOrCreateInstance(importUserModalEl)


            createUserModal.hide();
            importUserModal.hide();
            @this.dispatch('reset-modal');
        })

        var createUserModalEl = document.getElementById('createUserModal')
        createUserModalEl.addEventListener('hidden.bs.modal', (event) => {
            @this.dispatch('reset-modal');
        })
        var importUserModalEl = document.getElementById('importUserModal')
        importUserModalEl.addEventListener('hidden.bs.modal', (event) => {
            @this.dispatch('reset-modal');
        })
    })
</script>
