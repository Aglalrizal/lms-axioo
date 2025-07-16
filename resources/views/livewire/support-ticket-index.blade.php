<section class="container-fluid p-4">
    <div class="row">
        <!-- Page Header -->
        <div class="col-lg-12 col-md-12 col-12">
            <div class="border-bottom pb-3 mb-3 d-flex align-items-center justify-content-between">
                <div class="d-flex flex-column gap-1">
                    <h1 class="mb-0 h2 fw-bold">All Support Tickets</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="../dashboard/admin-dashboard.html">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item"><a href="#">CMS</a></li>
                            <li class="breadcrumb-item active" aria-current="page">All Support Tickets</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Card -->
            <div class="card rounded-3">
                <!-- Card Header -->
                <div class="card-header p-0">
                    <ul x-data="{ selected: 'all' }" class="nav nav-lb-tab border-bottom-0" id="tab" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link" @click=" selected = 'all' "
                                :class="selected === 'all' ? 'active' : ''"
                                wire:click="setShow('all')">All</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" @click=" selected = 'open' "
                                :class="selected === 'open' ? 'active' : ''"
                                wire:click="setShow('open')">Open</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" @click=" selected = 'inProgress' "
                                :class="selected === 'inProgress' ? 'active' : ''"
                                wire:click="setShow('in-progress')">In
                                Progress</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" @click=" selected = 'resolved' "
                                :class="selected === 'resolved' ? 'active' : ''"
                                wire:click="setShow('resolved')">Resolved</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" @click=" selected = 'deleted' "
                                :class="selected === 'deleted' ? 'active' : ''"
                                wire:click="setShow('deleted')">Deleted</button>
                        </li>
                    </ul>

                </div>
                <div class="p-4 row">
                    <!-- Form -->
                    <form class="d-flex align-items-center col-12 col-md-8 col-lg-3">
                        <span class="position-absolute ps-3 search-icon">
                            <i class="fe fe-search"></i>
                        </span>
                        <input wire:model="query" wire:keydown.debounce="search()" type="search"
                            class="form-control ps-6" placeholder="Search Post" />
                    </form>
                </div>
                <div>
                    <div class="tab-content" id="tabContent">
                        <!-- Tab -->
                        <div class="tab-pane fade show active" id="all-post" role="tabpanel"
                            aria-labelledby="all-post-tab">
                            <div class="table-responsive">
                                <!-- Table -->
                                <table
                                    class="table mb-0 text-nowrap table-centered table-hover table-with-checkbox table-centered table-hover">
                                    <!-- Table Head -->
                                    <thead class="table-light">
                                        <tr>
                                            {{-- <th>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="checkAll" />
                                                    <label class="form-check-label" for="checkAll"></label>
                                                </div>
                                            </th> --}}
                                            <th>Title</th>
                                            <th>Subject</th>
                                            <th>Date</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Table body -->
                                        @forelse ($tickets as $ticket)
                                            <tr wire:key="ticket-{{ $ticket->id }}">
                                                {{-- <td>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="postOne" />
                                                        <label class="form-check-label" for="postOne"></label>
                                                    </div>
                                                </td> --}}
                                                <td>
                                                    <h5 class="mb-0">
                                                        <a href="support-tickets/{{ $ticket->id }}"
                                                            class="text-inherit">{{ $ticket->title }}</a>
                                                    </h5>
                                                </td>
                                                <td>
                                                    <a href="support-tickets/{{ $ticket->id }}"
                                                        class="text-inherit">{{ $ticket->subject }}</a>
                                                </td>

                                                <td>
                                                    @if ($ticket->created_at->lessThan(now()->subDays(2)))
                                                        {{ $ticket->created_at->format('d M Y') }}
                                                    @else
                                                        {{ $ticket->created_at->diffForHumans() }}
                                                    @endif
                                                </td>

                                                <td>
                                                    <div class="d-flex align-items-center flex-row gap-2">
                                                        <h5 class="mb-0">{{ $ticket->email }}</h5>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if ($ticket->status === 'open')
                                                        <span
                                                            class="badge-dot bg-warning me-1 d-inline-block align-middle"></span>
                                                        {{ $ticket->status }}
                                                    @elseif ($ticket->status === 'in-progress')
                                                        <span
                                                            class="badge-dot bg-info me-1 d-inline-block align-middle"></span>
                                                        {{ $ticket->status }}
                                                    @elseif ($ticket->status === 'resolved')
                                                        <span
                                                            class="badge-dot bg-success me-1 d-inline-block align-middle"></span>
                                                        {{ $ticket->status }}
                                                    @elseif ($ticket->status === 'closed')
                                                        <span
                                                            class="badge-dot bg-danger me-1 d-inline-block align-middle"></span>
                                                        {{ $ticket->status }}
                                                    @else
                                                        <span
                                                            class="badge-dot bg-warning me-1 d-inline-block align-middle"></span>
                                                        {{ $ticket->status }}
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="dropdown dropstart">
                                                        <a class="btn-icon btn btn-ghost btn-sm rounded-circle"
                                                            href="#" role="button" id="courseDropdown1"
                                                            data-bs-toggle="dropdown" data-bs-offset="-20,20"
                                                            aria-expanded="false">
                                                            <i class="fe fe-more-vertical"></i>
                                                        </a>
                                                        <span class="dropdown-menu" aria-labelledby="courseDropdown1">
                                                            <span class="dropdown-header">Settings</span>
                                                            <a class="dropdown-item" href="#">
                                                                <i class="fe fe-edit dropdown-item-icon"></i>
                                                                Change Status
                                                            </a>
                                                            @if ($ticket->deleted_at)
                                                                <a wire:click="restore({{ $ticket->id }})"
                                                                    wire:confirm="Are you sure you want to restore this ticket?"
                                                                    class="dropdown-item">
                                                                    <i class="fe fe-rotate-cw dropdown-item-icon"></i>
                                                                    Restore
                                                                </a>
                                                            @else
                                                                <a wire:click="softDelete({{ $ticket->id }})"
                                                                    wire:confirm="Are you sure you want to delete this ticket?"
                                                                    class="dropdown-item">
                                                                    <i class="fe fe-trash dropdown-item-icon"></i>
                                                                    Delete
                                                                </a>
                                                            @endif

                                                        </span>
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">
                                                    <div class="d-flex justify-content-center align-items-center">
                                                        <i class="fe fe-alert-triangle me-2"></i>
                                                        <span>No tickets found.</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Card Footer -->
                    <div class="card-footer">
                        {{ $tickets->links(data: ['scrollTo' => false]) }}
                    </div>
                </div>
            </div>

</section>
