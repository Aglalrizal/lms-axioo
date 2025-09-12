<div wire:ignore.self class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="createUserModalLabel">{{ $formtitle ?? 'Buat ' . $title }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form wire:submit={{ $editform ? 'update' : 'save' }}>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input wire:model="username" type="text"
                            class="form-control @error('username') is-invalid @enderror text-dark">
                        <small class="text-muted"><i class="bi bi-info-circle"></i>
                            Only letters, numbers, and underscores are allowed. No spaces.</small>
                        @error('username')
                            <small class="d-block mt-2 text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input wire:model="email" type="text"
                            class="form-control @error('email') is-invalid @enderror text-dark">
                        @error('email')
                            <small class="d-block mt-2 text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    @if ($editform)
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select wire:model="userRole" id="role" class="form-select text-dark">
                                <option value="">Pilih role</option>
                                @foreach (\Spatie\Permission\Models\Role::all() as $role)
                                    <option value="{{ $role->name }}">
                                        {{ Str::of($role->name)->replace('-', ' ')->title() }}</option>
                                @endforeach
                            </select>
                            @error('role')
                                <small class="d-block mt-2 text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" id="changePasswordCheck"
                                wire:model.live="changePassword">
                            <label class="form-check-label" for="changePasswordCheck">
                                Change Password?
                            </label>
                        </div>
                        @if ($changePassword)
                            <div class="mb-3">
                                <label for="password" class="form-label">New Password</label>
                                {{-- <div class="input-group">
                                    <input class="form-control" type="password" id="new_password" wire:model="password"
                                        @error('password') is-invalid @enderror>
                                    <span class="input-group-text">
                                        <i class="bi bi-eye" style="cursor: pointer" id="toggleNewPassword"></i>
                                    </span>
                                </div> --}}
                                <input wire:model="password" type="text"
                                    class="form-control @error('password') is-invalid @enderror">
                                @error('password')
                                    <small
                                        class="d-block mt-2
                        text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        @endif
                    @else
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <input class="form-control text-dark @error('password') is-invalid @enderror"
                                    type="password" id="password" wire:model="password">
                                <span class="input-group-text">
                                    <i class="bi bi-eye" style="cursor: pointer" data-target="#password"
                                        data-toggle="password"></i>
                                </span>
                            </div>
                            @error('password')
                                <small class="d-block mt-2
                        text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
