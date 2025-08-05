<section class="container-fluid p-4">
    <div class="row">
        <!-- Page Header -->
        <div class="col-lg-12 col-md-12 col-12">
            <div class="border-bottom pb-3 mb-3 d-flex justify-content-between align-items-center">
                <div class="d-flex flex-column gap-1">
                    <h1 class="mb-0 h2 fw-bold">
                        User Profile
                    </h1>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- card -->
            <livewire:profile-card :username="$user->username" />
        </div>
    </div>
</section>
