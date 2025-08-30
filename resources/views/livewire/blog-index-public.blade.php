<div>
    <div class="container">
        <section style="padding: 4rem 0" class="d-flex align-items-center">
            <div style="height: 450px; aspect-ratio: 21/9; border-radius: 50px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
                class="position-relative overflow-hidden mx-auto">
                <img src="{{ asset('assets/images/blog_hero.jpg') }}" class="object-fit-cover w-100 h-100"
                    alt="blogpost" />
                <div class="position-absolute bottom-0 left-0 d-flex flex-column justify-content-end w-100 h-100 p-5 text-white"
                    style=" background: linear-gradient(to top, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0) 50%);">
                    <h2 class="text-white fs-2 mb-n2">WAWASAN DAN INSPIRASI</h2>
                    <h2 class="text-white fs-2">UNTUK TUMBUH BERSAMA</h2>
                    <p>Temukan artikel, tips, dan insight terbaru seputar pengembangan diri, teknologi, dan
                        dunia
                        kerja
                        masa kini.</p>
                </div>
            </div>
        </section>

        <section class="pb-8 pt-4">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                    <ul x-data="{ selected: 'berita' }" class="nav nav-pills nav-fill mb-6 border border-3 rounded"
                        id="tab" role="tablist">

                        {{-- @foreach ($categories as $category)
                            <li class="nav-item">
                                <button class="nav-link" @click=" selected = '{{ $category->slug }}' "
                                    :class="selected === '{{ $category->slug }}' ? 'active' : ''"
                                    wire:click="setShow('{{ $category->slug }}')">{{ $category->name }}</button>
                            </li>
                        @endforeach --}}

                        <li class="nav-item">
                            <button class="nav-link" @click=" selected = 'berita' "
                                :class="selected === 'berita' ? 'active' : ''"
                                wire:click="setShow('berita')">Berita</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" @click=" selected = 'akademi' "
                                :class="selected === 'akademi' ? 'active' : ''"
                                wire:click="setShow('akademi')">Akademi</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" @click=" selected = 'event' "
                                :class="selected === 'event' ? 'active' : ''"
                                wire:click="setShow('event')">Event</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" @click=" selected = 'tutorial' "
                                :class="selected === 'tutorial' ? 'active' : ''"
                                wire:click="setShow('tutorial')">Tutorial</button>
                        </li>
                    </ul>
                </div>

                <div class="row g-5">
                    @forelse ($blogs as $blog)
                        <div class="col-lg-4 col-md-6 col-12 mb-3 d-flex justify-content-center"
                            wire:key="blog-{{ $blog->id }}">
                            <x-blog-card :key="$blog->id" :blog="$blog" />
                        </div>
                    @empty
                        <div class="col-xl-12 col-lg-12 col-md-12 col-12 text-center mt-4">
                            <div class="d-flex justify-content-center align-items-center">
                                <i class="fe fe-alert-triangle me-2"></i>
                                <span>Belum ada blog yang dipublikasikan.</span>
                            </div>
                    @endforelse
                </div>

                <!-- Buttom -->
                <div class="col-xl-12 col-lg-12 col-md-12 col-12 text-center mt-4">
                    {{ $blogs->links() }}
                </div>
            </div>
        </section>

    </div>
</div>
