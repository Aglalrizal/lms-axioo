@php
    use Illuminate\Support\Facades\Storage;
@endphp

<div class="container-fluid p-4">
    <div class="card mb-4">

        <!-- Card Body -->
        <div class="card-body">
            <form wire:submit.prevent="save">
                <!-- Tim Kami Section -->
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <label class="form-label mb-0">Anggota Tim</label>
                        <button type="button" class="btn btn-sm btn-outline-primary" wire:click="addTim">
                            <i class="fas fa-plus"></i> Tambah Anggota
                        </button>
                    </div>

                    <div class="accordion" id="teamAccordion">
                        @foreach ($timKami as $index => $tim)
                            <div class="accordion-item" wire:key="team-{{ $tim['id'] ?? 'new-' . $index }}">
                                <h2 class="accordion-header" id="heading{{ $index }}">
                                    <div class="accordion-button {{ $index === 0 ? '' : 'collapsed' }}" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}"
                                        aria-expanded="{{ $index === 0 ? 'true' : 'false' }}">
                                        <div class="d-flex justify-content-between align-items-center w-100 me-3">
                                            <div class="d-flex align-items-center">
                                                <span class="fw-bold">
                                                    {{ $tim['nama'] ?: 'Anggota ' . ($index + 1) }}
                                                </span>
                                                @if ($tim['nama'])
                                                    <small class="text-muted ms-2">(Anggota {{ $index + 1 }})</small>
                                                @endif
                                            </div>
                                            @if (count($timKami) > 1)
                                                <button type="button" class="btn btn-sm btn-outline-danger ms-2"
                                                    wire:click="removeTim({{ $index }})">
                                                    <i class="fe fe-trash"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </h2>
                                <div id="collapse{{ $index }}"
                                    class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}"
                                    data-bs-parent="#teamAccordion">
                                    <div class="accordion-body">
                                        <!-- Photo Upload Section -->
                                        <div class="mb-3">
                                            <label class="form-label">Foto Anggota</label>
                                            <div class="d-flex align-items-start gap-3">
                                                <div class="flex-shrink-0">
                                                    @if ($photos[$index])
                                                        <img src="{{ $photos[$index]->temporaryUrl() }}"
                                                            alt="Preview foto" class="rounded border"
                                                            style="width: 80px; height: 80px; object-fit: cover;">
                                                    @elseif ($tim['photo_path'])
                                                        <img src="{{ Storage::url($tim['photo_path']) }}"
                                                            alt="Foto {{ $tim['nama'] }}" class="rounded border"
                                                            style="width: 80px; height: 80px; object-fit: cover;">
                                                    @else
                                                        <div class="d-flex align-items-center justify-content-center rounded border bg-light"
                                                            style="width: 80px; height: 80px;">
                                                            <i class="fas fa-user text-muted fs-4"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="flex-grow-1">
                                                    <input type="file"
                                                        class="form-control @error('photos.' . $index) is-invalid @enderror"
                                                        wire:model="photos.{{ $index }}" accept="image/*">
                                                    <small class="text-muted">Format: JPG, PNG, JPEG. Maksimal
                                                        2MB.</small>

                                                    <!-- Loading indicator -->
                                                    <div wire:loading wire:target="photos.{{ $index }}"
                                                        class="mt-2">
                                                        <small class="text-primary">
                                                            <i class="fas fa-spinner fa-spin"></i> Mengunggah foto...
                                                        </small>
                                                    </div>

                                                    @error('photos.' . $index)
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Nama Lengkap</label>
                                                <input type="text"
                                                    class="form-control @error('timKami.' . $index . '.nama') is-invalid @enderror"
                                                    wire:model="timKami.{{ $index }}.nama"
                                                    placeholder="Masukkan nama lengkap..." required>
                                                @error('timKami.' . $index . '.nama')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Jabatan</label>
                                                <input type="text"
                                                    class="form-control @error('timKami.' . $index . '.jabatan') is-invalid @enderror"
                                                    wire:model="timKami.{{ $index }}.jabatan"
                                                    placeholder="Masukkan jabatan anggota tim..." required>
                                                @error('timKami.' . $index . '.jabatan')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">LinkedIn Profile (Opsional)</label>
                                                <input type="url"
                                                    class="form-control @error('timKami.' . $index . '.linkedin') is-invalid @enderror"
                                                    wire:model="timKami.{{ $index }}.linkedin"
                                                    placeholder="https://linkedin.com/in/username">
                                                @error('timKami.' . $index . '.linkedin')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                        </div>
                                        <div class="mb-0">
                                            <label class="form-label">Deskripsi</label>
                                            <textarea class="form-control @error('timKami.' . $index . '.deskripsi') is-invalid @enderror" rows="4"
                                                wire:model="timKami.{{ $index }}.deskripsi" placeholder="Masukkan deskripsi atau bio singkat anggota tim..."
                                                required>
                                            </textarea>
                                            @error('timKami.' . $index . '.deskripsi')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @error('timKami')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="save">
                            <i class="fas fa-save"></i> Simpan Perubahan
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
