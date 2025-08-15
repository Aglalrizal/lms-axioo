<section class="container-fluid p-4">
    <div class="card rounded-3">
        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Ganti Status Tiket</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <select wire:model="status" class="form-select" id="selectSubject" required>
                                <option value="open">Open</option>
                                <option value="resolved">Resolved</option>
                                <option value="closed">Closed</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button wire:click="updateStatus" type="button" data-bs-dismiss="modal"
                            class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- card header -->
        <div class="card-header">
            <div class="d-md-flex justify-content-between align-items-center">
                <div class="d-flex mb-3 mb-md-0">
                    <div>
                        <a href="/admin/support-tickets" class="btn btn-outline-secondary btn-sm fs-5"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Back to ticket list">
                            <i class=" fe fe-arrow-left "></i></a>
                    </div>
                    <div class="ms-3 py-1 px-3 rounded-md bg-secondary-soft">
                        @if ($ticket->status === 'open')
                            <span class="badge-dot bg-warning me-1 d-inline-block align-middle"></span>
                            {{ $ticket->status }}
                        @elseif ($ticket->status === 'resolved')
                            <span class="badge-dot bg-success me-1 d-inline-block align-middle"></span>
                            {{ $ticket->status }}
                        @elseif ($ticket->status === 'closed')
                            <span class="badge-dot bg-danger me-1 d-inline-block align-middle"></span>
                            {{ $ticket->status }}
                        @else
                            <span class="badge-dot bg-warning me-1 d-inline-block align-middle"></span>
                            {{ $ticket->status }}
                        @endif
                    </div>
                </div>
                <!-- button -->
                <div class="d-flex align-items-center">
                    <div class="ms-2">
                        <button type="button" class="btn btn-outline-secondary btn-sm fs-5" data-bs-toggle="modal"
                            data-bs-target="#exampleModalCenter"> <i class=" fe fe-toggle-left me-1  "></i>Ubah Status
                        </button>
                    </div>
                    <div class="ms-2">
                        {{-- <div class="btn-group" role="group" aria-label="Basic example"> --}}
                        <button wire:click="confirmation" type="button" class="btn btn-outline-secondary btn-sm fs-5"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus"><i
                                class=" fe fe-trash-2 "></i></button>
                        {{-- </div> --}}
                    </div>
                </div>
            </div>
        </div>
        <!-- card body -->
        <div class="card-body">
            <div class="d-xl-flex justify-content-between align-items-start ">
                <div class=" lh-1">
                    <h5 class="mb-1 fs-3">{{ $ticket->title }}</h5>
                    <p class="mb-0">{{ $ticket->full_name }} - {{ $ticket->email }}
                    </p>
                </div>

                <div>
                    <small class="text-gray-500">{{ $ticket->created_at->format('d M Y, H:i') }}
                        ({{ $ticket->created_at->diffForHumans() }})</small>
                </div>

            </div>
            <!-- text -->
            <div class="mt-6">
                <p>{{ $ticket->description }}</p>
            </div>

            <!-- Display existing reply -->
            @if ($ticket->reply)
                <div class="mt-6">
                    <h6 class="mb-3">Admin Reply:</h6>
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <small class="text-muted">
                                    <strong>{{ $ticket->reply->admin_name }}</strong> -
                                    {{ $ticket->reply->created_at->format('d M Y, H:i') }}
                                </small>
                                @if ($ticket->reply->sent_at)
                                    <span class="badge bg-success">Email Sent</span>
                                @endif
                            </div>
                            <p class="mb-0">{!! nl2br(e($ticket->reply->message)) !!}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <!-- card footer -->

        <div class="card-footer py-4">
            @if ($ticket->status !== 'closed' && !$ticket->reply)
                <button wire:click="toggleReplyForm" class="btn btn-outline-secondary btn-sm fs-5 me-2 mb-2 mb-md-0">
                    <span class="me-1 align-text-bottom">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-reply" viewBox="0 0 16 16">
                            <path
                                d="M6.598 5.013a.144.144 0 0 1 .202.134V6.3a.5.5 0 0 0 .5.5c.667 0 2.013.005 3.3.822.984.624 1.99 1.76 2.595 3.876-1.02-.983-2.185-1.516-3.205-1.799a8.74 8.74 0 0 0-1.921-.306 7.404 7.404 0 0 0-.798.008h-.013l-.005.001h-.001L7.3 9.9l-.05-.498a.5.5 0 0 0-.45.498v1.153c0 .108-.11.176-.202.134L2.614 8.254a.503.503 0 0 0-.042-.028.147.147 0 0 1 0-.252.499.499 0 0 0 .042-.028l3.984-2.933zM7.8 10.386c.068 0 .143.003.223.006.434.02 1.034.086 1.7.271 1.326.368 2.896 1.202 3.94 3.08a.5.5 0 0 0 .933-.305c-.464-3.71-1.886-5.662-3.46-6.66-1.245-.79-2.527-.942-3.336-.971v-.66a1.144 1.144 0 0 0-1.767-.96l-3.994 2.94a1.147 1.147 0 0 0 0 1.946l3.994 2.94a1.144 1.144 0 0 0 1.767-.96v-.667z" />
                        </svg>
                    </span>
                    <span>{{ $showReplyForm ? 'Cancel Reply' : 'Reply' }}</span>
                </button>
            @elseif($ticket->reply)
                <p>Ticket ini sudah memiliki balasan.</p>
            @endif
        </div>




    </div>

    <!-- Reply Form -->
    @if ($showReplyForm)
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">Send Reply to Customer</h6>
            </div>
            <div class="card-body">
                <form wire:submit.prevent="sendReply">
                    <div class="mb-3">
                        <label for="adminName" class="form-label">Your Name</label>
                        <input wire:model="adminName" type="text"
                            class="form-control @error('adminName') is-invalid @enderror" id="adminName"
                            placeholder="Enter your name">
                        @error('adminName')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="replyMessage" class="form-label">Reply Message</label>
                        <textarea wire:model="replyMessage" class="form-control @error('replyMessage') is-invalid @enderror"
                            id="replyMessage" rows="5" placeholder="Type your reply message here..."></textarea>
                        @error('replyMessage')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="fe fe-info me-1"></i>
                            This reply will be sent to: <strong>{{ $ticket->email }}</strong>
                            <br>
                            <i class="fe fe-check-circle me-1"></i>
                            Ticket status will be automatically changed to "Resolved"
                        </small>

                        <div>
                            <button type="button" wire:click="toggleReplyForm" class="btn btn-secondary me-2">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <span wire:loading.remove>Send Reply & Resolve Ticket</span>
                                <span wire:loading>
                                    <span class="spinner-border spinner-border-sm me-1" role="status"></span>
                                    Sending...
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif
</section>
