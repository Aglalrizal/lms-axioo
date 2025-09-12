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
                        <a href="{{ route('admin.user.import') }}" class="btn btn-outline-primary">
                            Import
                        </a>
                    @endif
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">
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
                        placeholder="Cari {{ Str::of($role)->replace('-', ' ')->title() }}" />
                    <div class="d-flex justify-content-between align-items-center my-3">
                        <div class="d-flex align-items-center gap-2">
                            <select wire:model.live="sortBy" class="form-select">
                                <option value="username">Username</option>
                                <option value="created_at">Tanggal Bergabung</option>
                                <option value="first_name">Nama</option>
                                <option value="Email">Email</option>
                            </select>

                            <select wire:model.live="sortDirection" class="form-select">
                                <option value="asc">A-Z / Terlama</option>
                                <option value="desc">Z-A / Terbaru</option>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- table -->
                <div class="table-responsive">
                    <table class="table mb-0 text-nowrap table-hover table-centered">
                        <thead class="table-light">
                            <tr>
                                <th>Username</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Tanggal Bergabung</th>
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
                                    <td>{{ Str::title($user->first_name . ' ' . $user->surname) }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at->translatedFormat('d F, Y') }}</td>

                                    <td>
                                        <div class="hstack gap-4">
                                            {{-- <a href="#" data-bs-toggle="tooltip" data-placement="top"
                                                        title="Message"><i class="fe fe-mail"></i></a>
                                                    <a href="#" data-bs-toggle="tooltip" data-placement="top"
                                                        title="Delete"><i class="fe fe-trash"></i></a> --}}
                                            <span class="dropdown dropstart">
                                                <a class="btn-icon btn btn-ghost btn-sm rounded-circle" href="#"
                                                    role="button" data-bs-toggle="dropdown" data-bs-offset="-20,20"
                                                    aria-expanded="false">
                                                    <i class="fe fe-more-vertical"></i>
                                                </a>
                                                <span class="dropdown-menu">
                                                    <span class="dropdown-header">Pengaturan</span>
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.user.profile', ['username' => $user->username]) }}">
                                                        <i class="fe fe-user dropdown-item-icon"></i>
                                                        Profil
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
                                                        Hapus
                                                    </button>
                                                </span>
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Pengguna tidak ada.</td>
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
</section>
<script>
    document.addEventListener('livewire:initialized', () => {
        @this.on('refresh-users', (event) => {
            var createUserModalEl = document.querySelector('#createUserModal')
            var createUserModal = bootstrap.Modal.getOrCreateInstance(createUserModalEl)


            createUserModal.hide();
            @this.dispatch('reset-modal');
        })

        var createUserModalEl = document.getElementById('createUserModal')
        createUserModalEl.addEventListener('hidden.bs.modal', (event) => {
            @this.dispatch('reset-modal');
        })
    })
</script>
@section('scripts')
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script>
        setUpPasswordToggle()
    </script>
@endsection
