<div class="card border">
    <!-- card body  -->
    <div class="card-body p-5 d-flex flex-column gap-4">
        <h2 class="mb-0 fw-semibold">Submit a Request</h2>
        <!-- form  -->
        <form wire:submit="submit" class="needs-validation" novalidate>
            <!-- input  -->
            <div class="mb-3">
                <label class="form-label" for="name">Your Name</label>
                <input wire:model="full_name" class="form-control" type="text" name="name" placeholder="Your name"
                    id="name" required />
                @error('full_name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <!-- input  -->
            <div class="mb-3">
                <label class="form-label" for="email">
                    Email Address
                    <span class="text-danger">*</span>
                </label>
                <input wire:model="email" class="form-control" type="text" name="email"
                    placeholder="Email address here" id="email" required />
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <!-- input  -->
            <div class="mb-3">
                <label class="form-label" for="title">Title</label>
                <input wire:model="title" class="form-control" type="text" name="title" placeholder="Title here"
                    id="title" required />
                @error('title')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <!-- select options  -->
            <div class="mb-3">
                <label class="form-label" for="selectSubject">Subject</label>
                <select wire:model="subject" class="form-select" id="selectSubject" required>
                    <option selected value="">Select</option>
                    <option value="General">General</option>
                    <option value="Technical">Technical</option>
                    <option value="Accounts">Accounts</option>
                    <option value="Payment">Payment</option>
                    <option value="Other">Other</option>
                </select>
                @error('subject')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <!-- input  -->
                <label class="form-label" for="description">Description</label>
                <textarea wire:model="description" placeholder="Write down here" id="description" rows="2" class="form-control"
                    required></textarea>
                @error('description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <!-- button  -->
            <button wire:loading.attr="disabled" class="btn btn-primary" type="submit">Submit</button>
        </form>
    </div>
</div>
