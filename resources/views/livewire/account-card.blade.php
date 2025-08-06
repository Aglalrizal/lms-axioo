<div class="p-4">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <div class="pb-3 d-flex justify-content-between align-items-center">
                <div class="d-flex flex-column gap-1">
                    <h1 class="mb-0 h2 fw-bold">
                        Pengaturan Akun
                    </h1>
                    <p>Atur informasi autentikasi akunmu</p>
                </div>
            </div>
        </div>
    </div>

    <form id="change-email" wire:submit.prevent="changeEmail">
        <div class="card mb-4">
            <div class="card-body">
                <p class="display-6 mb-0">Ubah Email</p>

                <div class="row">
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
                            <button type="submit" form="change-email" class="btn btn-primary">Simpan
                                Perubahan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form id="change-password" wire:submit.prevent="changePassword">
        <div class="card">
            <div class="card-body">
                <p class="display-6 mb-0">Ubah Kata Sandi</p>
                <div class="row">
                    <div class="mb-3 col-12 col-md-6">
                        <x-input-label for="old_password" :value="__('Kata Sandi Lama')" />
                        <x-password-input :id="'old_password'" :name="'old_password'"
                            wire:model="old_password"></x-password-input>
                        <x-input-error :messages="$errors->get('old_password')" class="mt-2" />
                    </div>
                    <div class="mb-3 col-12 col-md-6">
                        <x-input-label for="new_password" :value="__('Kata Sandi Baru')" />
                        <x-password-input :id="'new_password'" :name="'new_password'"
                            wire:model="new_password"></x-password-input>
                        <x-input-error :messages="$errors->get('new_password')" class="mt-2" />
                    </div>

                    <div class="col-md-4 col-12 mb-3">
                        <div>
                            <button type="submit" form="change-password" class="btn btn-primary">Simpan
                                Perubahan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@section('scripts')
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script>
        setUpPasswordToggle()
    </script>
@endsection
