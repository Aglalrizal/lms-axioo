<div wire:ignore.self class="modal fade" id="detailLogItemModal" tabindex="-1" aria-labelledby="detailLogItemModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-content">
                @if ($log)
                    <div class="modal-header">
                        <h1 class="modal-title" id="detailLogItemModalLabel">Detail Log</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Event:</strong> {{ ucfirst($log->event) }}</p>
                        <p><strong>Deskripsi:</strong> {{ $log->description }}</p>
                        <p><strong>Pada:</strong> {{ $log->created_at->format('d M Y H:i') }}</p>
                        <hr>
                        {{-- @php $changes = $log->changes(); @endphp
                        @if ($changes)
                            <ul class="list-group">
                                @foreach ($changes['attributes'] ?? [] as $key => $new)
                                    @continue($key === 'updated_at')
                                    @php $old = $changes['old'][$key] ?? '-' @endphp
                                    <li class="list-group-item">
                                        <strong>{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong><br>
                                        <span class="text-muted">{{ $old }}</span>
                                        <i class="bi bi-arrow-right mx-2"></i>
                                        <span class="text-success">{{ $new }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted">No changes recorded.</p>
                        @endif --}}
                        <pre>{{ json_encode($log->properties, JSON_PRETTY_PRINT) }}</pre>
                    </div>
                @else
                    <div class="modal-body text-center text-muted py-5">
                        Loading log data...
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
