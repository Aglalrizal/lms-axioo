<div class="d-flex justify-content-between">
    <div>
        <a href="{{ route('admin.course.all') }}" type="button" class="btn btn-secondary">Kembali ke
            Daftar Kursus</a>
    </div>
    <div>
        @if ($step > 1)
            <button type="button" class="btn btn-primary" wire:click="$dispatch('back')"><i
                    class="bi bi-chevron-double-left"></i></button>
        @endif
        <button type="submit" class="btn btn-success" id="save-button">Simpan</button>
        @if ($slug && $step < 4)
            <button type="button" class="btn btn-primary" wire:click="$dispatch('next')"><i
                    class="bi bi-chevron-double-right"></i></button>
        @endif
    </div>
</div>
