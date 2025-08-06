<div class="p-4">
    @role('instructor')
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div class="pb-3 d-flex justify-content-between align-items-center">
                    <div class="d-flex flex-column gap-1">
                        <h1 class="mb-0 h2 fw-bold">
                            Profil
                        </h1>
                        <p>Pastikan semua data anda sudah benar dan valid!</p>
                    </div>
                </div>
            </div>
        </div>
    @endrole
    <div class="row">
        <form wire:submit="save">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-3 form-label">Foto Profil</h4>
                    <div class="mb-4 d-flex align-items-center gap-3">
                        <img src="{{ optional($user)->profile_picture
                            ? asset('storage/' . $user->profile_picture)
                            : 'https://ui-avatars.com/api/?background=random&name=' . urlencode(optional($user)->username) }}"
                            class="rounded-circle" width="80" height="80"
                            alt="{{ $user->username . '-avatar' }}">
                        <div>
                            <small class="text-muted d-block">Gambar sebaiknya memiliki rasio 1:1 dan berukuran tidak
                                lebih
                                dari
                                2MB.</small>
                            <input type="file" class="form-control mt-2" wire:model="profile_picture">
                            @error('profile_picture')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <h4 class="mb-2 mt-4">Detail Profil</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Nama Depan</label>
                            <input type="text" class="form-control" wire:model="first_name">
                            @error('first_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Belakang</label>
                            <input type="text" class="form-control" wire:model="surname">
                            @error('last_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nomor ID</label>
                            <input type="text" class="form-control" wire:model="id_number">
                            @error('id_number')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control" wire:model="phone_number">
                            @error('phone_number')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tempat Lahir</label>
                            <input type="text" class="form-control" wire:model="place_of_birth">
                            @error('place_of_birth')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" wire:model="date_of_birth">
                            @error('date_of_birth')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Alamat</label>
                            <input type="text" class="form-control" wire:model="address">
                            @error('address')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <h5 class="mb-3 mt-4">Profil Pendidikan</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Pendidikan</label>
                            <input type="text" class="form-control" wire:model="education">
                            @error('education')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Institusi</label>
                            <input type="text" class="form-control" wire:model="institution">
                            @error('institution')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="text-end mt-4">
                        @php
                            $userRole = auth()->user()->getRoleNames()->first();
                            $backUrl = match ($userRole) {
                                'super-admin' => route('admin.user', ['role' => $role]),
                                'admin' => route('admin.user', ['role' => $role]),
                                'instructor' => route('instructor.dashboard'),
                                'student' => route('student.dashboard'),
                            };
                        @endphp
                        <a class="btn btn-outline-secondary px-4" href="{{ $backUrl }}">Kembali</a>
                        <button class="btn btn-success px-4" type="submit">Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
