<div>
    <span class="text-danger fw-bold">
        <i class="fe fe-clock me-1 align-middle"></i>
        {{ gmdate('i:s', $timeLeft) }}
    </span>
</div>

<script>
    document.addEventListener("livewire:init", () => {
        setInterval(() => {
            Livewire.dispatch('tick')
        }, 1000);
    })
</script>
