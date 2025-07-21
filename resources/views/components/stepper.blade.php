<div class="bs-stepper-header shadow-sm">
    <div class="step {{ Route::is('admin.course.create.step.one') ? 'active' : '' }}">
        <button wire:click='$step=1' class="step-trigger">
            <span class="bs-stepper-circle">1</span>
            <span class="bs-stepper-label">Basic Information</span>
        </button>
    </div>
    <div class="bs-stepper-line"></div>
    <div class="step {{ Route::is('admin.course.create.step.two') ? 'active' : '' }}">
        <button wire:click='$step=2' class="step-trigger">
            <span class="bs-stepper-circle">2</span>
            <span class="bs-stepper-label">Courses Media</span>
        </button>
    </div>
    <div class="bs-stepper-line"></div>
    <div class="step {{ Route::is('admin.course.create.step.three') ? 'active' : '' }}">
        <button wire:click='$step=3' class="step-trigger">
            <span class="bs-stepper-circle">3</span>
            <span class="bs-stepper-label">Curriculum</span>
        </button>
    </div>
    <div class="bs-stepper-line"></div>
    <div class="step {{ Route::is('admin.course.create.step.four') ? 'active' : '' }}">
        <button wire:click='$step=4' class="step-trigger">
            <span class="bs-stepper-circle">4</span>
            <span class="bs-stepper-label">Settings</span>
        </button>
    </div>
</div>
