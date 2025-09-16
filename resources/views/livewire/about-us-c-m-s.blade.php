<div class="container-fluid p-4">
    <div class="card mb-4">
        <!-- Card Body -->
        <div class="card-body">
            <form wire:submit.prevent="save">
                <div class="mb-3">
                    <label for="tentangKami" class="form-label">Tentang Kami</label>
                    <textarea class="form-control @error('tentangKami') is-invalid @enderror" id="tentangKami" rows="4"
                        wire:model="tentangKami" required>
                    </textarea>
                    @error('tentangKami')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="visiKami" class="form-label">Visi Kami</label>
                    <textarea class="form-control @error('visiKami') is-invalid @enderror" id="visiKami" rows="4"
                        wire:model="visiKami" required>
                    </textarea>
                    @error('visiKami')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Misi Kami Section -->
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <label class="form-label mb-0">Misi Kami</label>
                        <button type="button" class="btn btn-sm btn-primary" wire:click="addMisi">
                            <i class="fas fa-plus"></i> Tambah Misi
                        </button>
                    </div>

                    <div class="accordion" id="missionAccordion">
                        @foreach ($misiKami as $index => $misi)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="missionHeading{{ $index }}">
                                    <div class="accordion-button {{ $index === 0 ? '' : 'collapsed' }}" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#missionCollapse{{ $index }}"
                                        aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"
                                        aria-controls="missionCollapse{{ $index }}">
                                        <div class="d-flex justify-content-between align-items-center w-100 me-3">
                                            <div class="d-flex align-items-center">
                                                <span class="fw-bold">
                                                    {{ $misi['title'] ?: 'Misi ' . ($index + 1) }}
                                                </span>
                                                @if ($misi['title'])
                                                    <small class="text-muted ms-2">(Misi {{ $index + 1 }})</small>
                                                @endif
                                            </div>
                                            @if (count($misiKami) > 1)
                                                <button type="button" class="btn btn-sm btn-outline-danger ms-2"
                                                    wire:click="removeMisi({{ $index }})"
                                                    onclick="event.stopPropagation();">
                                                    <i class="fe fe-trash"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </h2>
                                <div id="missionCollapse{{ $index }}"
                                    class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}"
                                    aria-labelledby="missionHeading{{ $index }}"
                                    data-bs-parent="#missionAccordion">
                                    <div class="accordion-body">
                                        <div class="mb-3">
                                            <label class="form-label">Judul Misi</label>
                                            <input type="text"
                                                class="form-control @error('misiKami.' . $index . '.title') is-invalid @enderror"
                                                wire:model="misiKami.{{ $index }}.title"
                                                placeholder="Masukkan judul misi..." required>
                                            @error('misiKami.' . $index . '.title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-0">
                                            <label class="form-label">Deskripsi Misi</label>
                                            <textarea class="form-control @error('misiKami.' . $index . '.description') is-invalid @enderror" rows="3"
                                                wire:model="misiKami.{{ $index }}.description" placeholder="Masukkan deskripsi misi..." required>
                                            </textarea>
                                            @error('misiKami.' . $index . '.description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @error('misiKami')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="save">
                            <i class="fas fa-save"></i> Perbarui Konten
                        </span>
                        <span wire:loading wire:target="save">
                            <i class="fas fa-spinner fa-spin"></i> Menyimpan...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
