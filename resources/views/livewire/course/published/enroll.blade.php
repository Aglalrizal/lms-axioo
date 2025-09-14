<div wire:ignore.self class="modal fade" id="enrollUserModal" tabindex="-1" aria-labelledby="enrollUserModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="enrollUserModalLabel">Daftarkan Peserta</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form wire:submit='save'>
                <div class="modal-body">
                    <div class="mb-3">
                        <div wire:ignore>
                            <label class="form-label" for="select-user">Calon Peserta</label>
                            <select class="form-select" id="select-user" style="width: 100%;" name="users[]"
                                multiple="multiple">
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->first_name . ' ' . $user->surname }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('selectedUsers')
                            <small class="d-block mt-2 text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@assets
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <style>
        .select2-results__option--selected {
            display: none;
        }
    </style>
@endassets
@script
    <script>
        let selectUsers = $('#select-user').select2({
            dropdownParent: $('#enrollUserModal'),
            placeholder: 'Dapat lebih dari satu',
            allowClear: true
        });
        selectUsers.on('change', function() {
            @this.set('selectedUsers', $(this).val());
        });

        // Clear Select2 UI when modal is fully hidden
        const enrollUserModalEl = document.getElementById('enrollUserModal');
        if (enrollUserModalEl) {
            enrollUserModalEl.addEventListener('hidden.bs.modal', () => {
                const $select = $('#select-user');
                if ($select.length && $select.data('select2')) {
                    // Clear to an empty array to avoid selecting an empty option implicitly
                    $select.val([]).trigger('change');
                }
            });
        }
    </script>
@endscript
