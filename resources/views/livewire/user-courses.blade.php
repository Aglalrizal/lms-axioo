<div class="p-4">
    <p class="display-4 text-dark">Progres Belajar</p>
    <p class="text-dark">Periksa dan terus tingkatkan progres belajarmu setiap harinya!</p>

    <div class="card mt-4">
        <div class="card-body" style="padding: 3rem;">

            <div class="btn-group w-100">
                <button wire:click="setShow('onGoing')"
                    class="btn btn-outline-primary {{ $isShowing === 'onGoing' ? 'active' : '' }}">
                    Kelas yang sedang dipelajari</button>
                <button wire:click="setShow('completed')"
                    class="btn btn-outline-primary {{ $isShowing === 'completed' ? 'active' : '' }}">
                    Kelas yang telah diselesaikan</button>
            </div>

            <div class="mt-6">
                <div class="row">
                    @forelse ($courses as $course)
                        <div class="col-md-6 col-lg-4 col-xl-3 col-12 mb-3 d-flex justify-content-center">
                            <x-course-progress-card :key="$course->id" :course="$course" />
                        </div>
                    @empty
                        <div class="card">
                            <div class="card-body text-center">
                                @if ($isShowing === 'onGoing')
                                    <p class="text-muted mb-0">Belum ada kelas yang sedang dipelajari.</p>
                                    <a href="{{ route('public.course.explore') }}" class="btn btn-primary mt-2">Ikuti
                                        Kelas</a>
                                @else
                                    <p class="text-muted mb-0">Belum ada kelas yang diselesaikan.</p>
                                    <a href="{{ route('public.course.explore') }}" class="btn btn-primary mt-2">Ikuti
                                        Kelas</a>
                                @endif
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@assets
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
@endassets
