<div>
    <p class="display-4">Pengaturan Akun</p>
    <p>Atur informasi autentikasi akunmu</p>

    <div class="card mt-4">

        <div class="card-body" style="padding: 3rem;">
            <form class="row" id="change-email" wire:submit.prevent="changeEmail">
                <div class="row">
                    <p class="display-6 mb-0">Ubah Email</p>
                </div>

                <div class="row py-6">
                    <div class="mb-3 col-12 col-md-6">
                        <label class="form-label" for="old_email">Email Lama</label>
                        <input wire:model="old_email" type="email" id="old_email" class="form-control"
                            placeholder="Email Lama" required>
                        @error('old_email')
                            <div>{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 col-12 col-md-6">
                        <label class="form-label" for="new_email">Email Baru</label>
                        <input wire:model="new_email" type="email" id="new_email" class="form-control"
                            placeholder="Email baru" required>
                        @error('new_email')
                            <div>{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 col-12 mb-3">
                        <div>
                            <button type="submit" form="change-email" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </div>
                </div>
            </form>

            <form class="row" id="change-password" wire:submit.prevent="changePassword">
                <div class="row">
                    <p class="display-6 mb-0">Ubah Kata Sandi</p>
                </div>

                <div class="row py-6">
                    <div class="mb-3 col-12 col-md-6">
                        <label class="form-label" for="fname">Kata Sandi Lama</label>
                        <input wire:model="old_password" type="password" id="fname" class="form-control"
                            placeholder="Sandi lama" required>
                        @error('old_password')
                            <div>{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 col-12 col-md-6">
                        <label class="form-label" for="lname">Kata Sandi Baru</label>
                        <input wire:model="new_password" type="password" id="lname" class="form-control"
                            placeholder="Sandi baru" required>
                        @error('new_password')
                            <div>{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 col-12 mb-3">
                        <div>
                            <button type="submit" form="change-password" class="btn btn-primary">Simpan
                                Perubahan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
