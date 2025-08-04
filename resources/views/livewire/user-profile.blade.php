<div>
    <p class="display-4">Profil</p>
    <p>Pastikan semua data pribadi Anda di bawah ini sudah benar dan valid!</p>

    <div class="card mt-4">
        <div class="card-body" style="padding: 3rem;">

            <form class="row" wire:submit.prevent="save">
                <div class="row">
                    <p class="display-6 mb-0">Foto Profil</p>
                </div>

                <div class="d-flex align-items-center py-6 border-bottom">
                    <div class="position-relative">
                        @if ($profile_picture_path)
                            <img src="{{ asset($profile_picture_path) }}" alt=""
                                class="rounded-circle avatar-xl">
                        @else
                            <img src="{{ asset('assets/images/avatar/avatar-1.jpg') }}" alt=""
                                class="rounded-circle avatar-xl">
                        @endif
                    </div>
                    <div class="ms-4">
                        <p class="mb-2">Gambar Profile Anda sebaiknya memiliki rasio 1:1 dan berukuran tidak lebih
                            dari
                            2MB.</p>
                        <div class="d-flex gap-2">
                            <input type="file" wire:model="photo" id="photo" style="display: none;">
                            <button type="button" class="btn btn-warning mb-2"
                                onclick="document.querySelector('#photo').click()">Pilih Foto</button>
                            <button type="button" class="btn btn-outline-warning mb-2"
                                wire:click="confirmation">Hapus</button>
                        </div>
                    </div>
                </div>

                <div class="row mt-6">
                    <p class="display-6 mb-0">Detail Profil</p>
                </div>

                <div class="row py-6">
                    <div class="mb-3 col-12 col-md-6">
                        <label class="form-label" for="fname">Nama Depan</label>
                        <input wire:model="first_name" type="text" id="fname" class="form-control"
                            placeholder="Nama Depan">
                        @error('first_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3 col-12 col-md-6">
                        <label class="form-label" for="lname">Nama Belakang</label>
                        <input wire:model="surname" type="text" id="lname" class="form-control"
                            placeholder="Nama Belakang">
                    </div>
                    <div class="mb-3 col-12 col-md-6">
                        <label class="form-label" for="lname">Email</label>
                        <input wire:model="email" type="text" id="lname" class="form-control" placeholder="Email"
                            required>
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3 col-12 col-md-6">
                        <label class="form-label" for="lname">Nomor ID</label>
                        <input wire:model="id_number" type="text" id="lname" class="form-control"
                            placeholder="Nomor ID">
                        @error('id_number')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3 col-12 col-md-6">
                        <label class="form-label" for="lname">Tempat Lahir</label>
                        <input wire:model="place_of_birth" type="text" id="lname" class="form-control"
                            placeholder="Tempat Lahir">
                    </div>
                    <div class="mb-3 col-12 col-md-6">
                        <label class="form-label" for="lname">Tanggal Lahir</label>
                        <input wire:model="date_of_birth" type="text" id="lname" class="form-control"
                            placeholder="Tanggal Lahir">
                        @error('date_of_birth')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3 col-12 col-md-6">
                        <label class="form-label" for="lname">Kota</label>
                        <input wire:model="city" type="text" id="lname" class="form-control" placeholder="Kota">
                        @error('city')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3 col-12 col-md-6">
                        <label class="form-label" for="lname">Alamat</label>
                        <input wire:model="address" type="text" id="lname" class="form-control"
                            placeholder="Alamat">
                        @error('address')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
                <div class="row">
                    <p class="display-6 mb-0">Detail Profil</p>
                </div>

                <div class="row py-6">
                    <div class="mb-3 col-12 col-md-6">
                        <label class="form-label" for="fname">Pendidikan</label>
                        <input wire:model="education" type="text" id="fname" class="form-control"
                            placeholder="Pendidikan">
                        @error('education')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3 col-12 col-md-6">
                        <label class="form-label" for="lname">Institusi</label>
                        <input wire:model="institution" type="text" id="lname" class="form-control"
                            placeholder="Institusi">
                        @error('institution')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3 col-12 col-md-12">
                        <label class="form-label" for="phone">Jurusan</label>
                        <input wire:model="major" type="text" id="phone" class="form-control"
                            placeholder="Jurusan">
                        @error('major')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
