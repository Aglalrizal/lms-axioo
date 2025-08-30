@props([
    'photo_path',
    'title_top' => 'Hero Card',
    'title_bottom' => 'Hero Card',
    'description' => 'This is hero card component',
])

<section style="padding: 4rem 0" class="d-flex align-items-center">
    <div style="aspect-ratio: 21/9; border-radius: 50px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
        class="position-relative overflow-hidden mx-auto">
        <img src="{{ asset('assets/images/blog_hero.jpg') }}" class="object-fit-cover w-100 h-100" alt="blogpost" />
        <div class="position-absolute bottom-0 left-0 d-flex flex-column justify-content-end w-100 h-100 p-5 text-white"
            style=" background: linear-gradient(to top, rgba(0, 0, 0, 0.8) 0%, rgba(0, 0, 0, 0) 90%);">
            <h2 class="fs-1 mb-n2" style="color: white;">{{ $title_top }}</h2>
            <h2 class="fs-1" style="color: white;">{{ $title_bottom }}</h2>
            <p style="color: white;">{{ $description }}</p>
        </div>
    </div>
</section>
