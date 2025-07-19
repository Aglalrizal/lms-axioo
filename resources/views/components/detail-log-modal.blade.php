    <div class="modal fade" id="detailLogItemModal" tabindex="-1" aria-labelledby="faqItemModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="detailLogItemModal">Heyo</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Event:</strong> {{ ucfirst($log->event) }}</p>
                    <p><strong>Deskripsi:</strong> {{ $log->description }}</p>
                    <hr>
                    @php $changes = $log->changes(); @endphp
                    @if ($changes)
                        <ul class="list-group">
                            @foreach ($changes['attributes'] ?? [] as $key => $new)
                                @php $old = $changes['old'][$key] ?? null; @endphp
                                <li class="list-group-item">
                                    <strong>{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong><br>
                                    <span class="text-muted">Old:</span> "{{ $old ?? '-' }}"<br>
                                    <span class="text-success">New:</span> "{{ $new }}"
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">No changes recorded.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
