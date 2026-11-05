@php
    $shopCategories = [
        [
            'name' => 'STEM & Robotics',
            'slug' => 'stem-robotics',
            'image' => '33qexSfiiIrXfrbWcmnswrHEk6UKy2kbuNPy6Y9E.webp',
        ],
        [
            'name' => 'Language',
            'slug' => 'language',
            'image' => 'n71saIlbUof1AEuapxX0F7CqQYlYgzkqqodsymBo.webp',
        ],
        [
            'name' => 'Art & Craft',
            'slug' => 'art-craft',
            'image' => 'PiHx6lWIm47689wVMPoFWg0s98EhZT84xzyLzIqk.webp',
        ],
        [
            'name' => 'Sensory Play',
            'slug' => 'sensory-play',
            'image' => '33qexSfiiIrXfrbWcmnswrHEk6UKy2kbuNPy6Y9E.webp',
        ],
        [
            'name' => 'Puzzle & Strategy',
            'slug' => 'puzzle-strategy',
            'image' => 'n71saIlbUof1AEuapxX0F7CqQYlYgzkqqodsymBo.webp',
        ],
        [
            'name' => 'Wooden Toys',
            'slug' => 'wooden-toys',
            'image' => 'PiHx6lWIm47689wVMPoFWg0s98EhZT84xzyLzIqk.webp',
        ],
        [
            'name' => 'Music & Sound',
            'slug' => 'music-sound',
            'image' => '33qexSfiiIrXfrbWcmnswrHEk6UKy2kbuNPy6Y9E.webp',
        ],
        [
            'name' => 'Role Play & Skills',
            'slug' => 'role-play-skills',
            'image' => 'n71saIlbUof1AEuapxX0F7CqQYlYgzkqqodsymBo.webp',
        ],
        [
            'name' => 'Math Skills',
            'slug' => 'math-skills',
            'image' => 'PiHx6lWIm47689wVMPoFWg0s98EhZT84xzyLzIqk.webp',
        ],
        [
            'name' => 'Brain Dev',
            'slug' => 'brain-dev',
            'image' => '33qexSfiiIrXfrbWcmnswrHEk6UKy2kbuNPy6Y9E.webp',
        ],
    ];
@endphp

<section class="w-full bg-gray-50 py-6 md:py-8 dark:bg-slate-900" aria-labelledby="shop-by-category-title">
    <div class="mx-auto w-full max-w-[1600px] px-4 md:px-8">

        <h2 id="shop-by-category-title"
            class="mb-5 flex items-center gap-3 text-xl font-bold tracking-tight text-slate-900 md:text-2xl dark:text-white">
            <span class="h-7 w-1 rounded-full bg-sky-500"></span>
            Shop by Category
        </h2>

        <div class="relative">

            <ul
                class="-mx-4 flex snap-x snap-mandatory gap-3 overflow-x-auto px-4 pb-3 [scrollbar-width:none] sm:gap-4 lg:mx-0 lg:grid lg:grid-cols-10 lg:gap-4 lg:overflow-visible lg:px-0 lg:pb-0 [&::-webkit-scrollbar]:hidden">

                @foreach ($shopCategories as $item)
                    <li class="w-[100px] shrink-0 snap-start sm:w-[110px] lg:w-full">

                        <a href="{{ route('categories.show', ['slug' => $item['slug']]) }}"
                            class="group flex flex-col items-center gap-2 rounded-xl no-underline focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-sky-500">

                            <span
                                class="flex aspect-square w-full items-center justify-center overflow-hidden rounded-2xl bg-white ring-1 ring-gray-200 transition duration-300 group-hover:-translate-y-1 group-hover:shadow-lg group-hover:shadow-sky-100 dark:bg-slate-800 dark:ring-slate-700">
                                <img src="{{ asset('assets/shop_category/' . $item['image']) }}"
                                    alt="{{ $item['name'] }}" width="120" height="120" loading="lazy"
                                    decoding="async"
                                    class="h-full w-full object-contain p-2 transition-transform duration-300 group-hover:scale-105">
                            </span>

                            <span
                                class="line-clamp-2 min-h-[2.5em] px-1 text-center text-xs font-semibold leading-5 text-slate-700 transition-colors group-hover:text-sky-600 sm:text-sm dark:text-slate-200 dark:group-hover:text-sky-400">
                                {{ $item['name'] }}
                            </span>

                        </a>

                    </li>
                @endforeach

            </ul>

            <div class="pointer-events-none absolute inset-y-0 right-0 w-8 bg-[linear-gradient(to_left,#f9fafb,transparent)] lg:hidden dark:bg-[linear-gradient(to_left,#0f172a,transparent)]"
                aria-hidden="true"></div>

        </div>
    </div>
</section>
