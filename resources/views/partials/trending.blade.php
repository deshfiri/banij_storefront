@php
    use Illuminate\Support\Facades\Route;

    // Add more products by copying one block. Images live in: public/assets/shop_category/
    $trendingProducts = [
        [
            'name' => 'Smart Education Board',
            'slug' => 'smart-education-board',
            'image' => 'assets/shop_category/33qexSfiiIrXfrbWcmnswrHEk6UKy2kbuNPy6Y9E.webp',
            'price' => 1100,
            'rating' => 0.0,
            'reviews' => 0,
            'in_stock' => false,
        ],
    ];

    $trustItems = [
        ['title' => 'Free Delivery', 'text' => 'Orders above ৳999', 'icon' => 'truck'],
        ['title' => 'Cash on Delivery', 'text' => 'Cash at your doorstep', 'icon' => 'cash'],
        ['title' => '7-Day Returns', 'text' => 'Hassle-free returns', 'icon' => 'returns'],
        ['title' => '100% Authentic', 'text' => 'Guaranteed genuine', 'icon' => 'shield'],
    ];
@endphp

<section class="w-full bg-white py-6 md:py-8 dark:bg-slate-900" aria-labelledby="trending-title">
    <div class="mx-auto w-full max-w-[1600px] px-4 md:px-8">

        {{-- Heading + See All --}}
        <div class="mb-4 flex items-center justify-between gap-4 md:mb-6">
            <h2 id="trending-title"
                class="flex items-center gap-3 text-xl font-bold tracking-tight text-slate-900 md:text-2xl dark:text-slate-100">
                <span class="h-7 w-1 rounded-full bg-sky-500" aria-hidden="true"></span>
                Trending Now
            </h2>

            <a href="{{ route('products.index', ['sort' => 'popular']) }}"
                class="inline-flex no-underline h-10 items-center gap-1 rounded-lg px-2 text-[15px] font-medium text-sky-700 transition-colors hover:text-sky-800 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-sky-400 dark:text-sky-400 dark:hover:text-sky-300">
                See All

                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"
                    focusable="false">
                    <path d="m9 6 6 6-6 6" />
                </svg>
            </a>

            {{-- <a href="{{ route('products.index', ['shop' => 'popular']) }}"
                class="inline-flex h-10 items-center gap-1 rounded-lg px-2 text-[15px] font-medium text-sky-600 transition-colors hover:text-sky-800 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-sky-400 dark:text-sky-400 dark:hover:text-sky-300">
                See All
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"
                    focusable="false">
                    <path d="m9 6 6 6-6 6" />
                </svg>
            </a> --}}
        </div>

        {{-- Products --}}
        @if (count($trendingProducts) > 0)
            <ul class="grid grid-cols-2 gap-3 sm:grid-cols-3 sm:gap-4 md:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6">
                @foreach ($trendingProducts as $p)
                    @php
                        $productUrl = Route::has('products.show')
                            ? route('products.show', ['slug' => $p['slug']])
                            : route('products.index', ['shop' => 'popular']);
                    @endphp

                    <li>
                        <article
                            class="group flex h-full flex-col rounded-2xl border border-slate-200 bg-white p-2.5 transition-shadow hover:shadow-lg hover:shadow-slate-200/70 sm:p-3 dark:border-slate-700 dark:bg-slate-900 dark:hover:shadow-none">

                            {{-- Image --}}
                            <a href="{{ $productUrl }}"
                                class="relative block aspect-square overflow-hidden rounded-xl bg-slate-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-sky-400 dark:bg-slate-800">
                                <img src="{{ asset($p['image']) }}" alt="{{ $p['name'] }}" width="400"
                                    height="400" loading="lazy" decoding="async"
                                    class="h-full w-full object-contain p-2 transition duration-300 {{ $p['in_stock'] ? 'motion-safe:group-hover:scale-105' : 'opacity-60 blur-[3px]' }}">

                                @unless ($p['in_stock'])
                                    <span
                                        class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 whitespace-nowrap rounded-full bg-slate-800 px-4 py-2 text-[11px] font-bold uppercase tracking-wider text-white sm:text-xs">
                                        Out of stock
                                    </span>
                                @endunless
                            </a>

                            {{-- Info --}}
                            <div class="mt-3 flex flex-1 flex-col">
                                <h3
                                    class="line-clamp-2 min-h-[2.5rem] text-[15px] font-semibold leading-snug text-slate-900 dark:text-slate-100">
                                    <a href="{{ $productUrl }}"
                                        class="transition-colors hover:text-sky-700 focus-visible:outline-none focus-visible:underline dark:hover:text-sky-300">
                                        {{ $p['name'] }}
                                    </a>
                                </h3>

                                {{-- Rating --}}
                                <div class="mt-2 flex items-center gap-2 text-sm">
                                    <span
                                        class="inline-flex items-center gap-1 rounded-md bg-amber-100 px-1.5 py-0.5 text-xs font-semibold text-amber-800">
                                        <span aria-hidden="true">★</span>
                                        {{ number_format($p['rating'], 1) }}
                                    </span>
                                    <span class="text-slate-500 dark:text-slate-400">({{ $p['reviews'] }})</span>
                                </div>

                                {{-- Price + add button --}}
                                <div class="mt-auto flex items-center justify-between gap-2 pt-4">
                                    <span class="text-lg font-bold text-slate-900 dark:text-slate-100">
                                        ৳{{ number_format($p['price']) }}
                                    </span>

                                    @if ($p['in_stock'])
                                        <button type="button" data-add-to-cart data-product="{{ $p['slug'] }}"
                                            aria-label="Add {{ $p['name'] }} to cart"
                                            class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-sky-600 text-white transition-colors hover:bg-sky-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-sky-400 focus-visible:ring-offset-2 md:h-10 md:w-10 dark:focus-visible:ring-offset-slate-900">
                                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                aria-hidden="true" focusable="false">
                                                <path d="M12 5v14M5 12h14" />
                                            </svg>
                                        </button>
                                    @else
                                        <button type="button" disabled aria-disabled="true"
                                            aria-label="{{ $p['name'] }} is out of stock"
                                            class="inline-flex h-11 w-11 shrink-0 cursor-not-allowed items-center justify-center rounded-xl bg-slate-300 text-white md:h-10 md:w-10 dark:bg-slate-700 dark:text-slate-400">
                                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                aria-hidden="true" focusable="false">
                                                <path d="M12 5v14M5 12h14" />
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </article>
                    </li>
                @endforeach
            </ul>
        @endif

        {{-- Trust cards --}}
        <ul class="mt-8 grid grid-cols-1 gap-3 sm:grid-cols-2 sm:gap-4 lg:mt-10 lg:grid-cols-4">
            @foreach ($trustItems as $t)
                <li
                    class="flex items-center gap-4 rounded-2xl border border-slate-200 bg-white px-4 py-4 sm:px-5 dark:border-slate-700 dark:bg-slate-900">
                    <span
                        class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-sky-50 text-sky-600 dark:bg-sky-950/60 dark:text-sky-300">
                        <svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor"
                            stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"
                            focusable="false">
                            @switch($t['icon'])
                                @case('truck')
                                    <path d="M2 6h11v11H2z" />
                                    <path d="M13 9h4l4 4v4h-8" />
                                    <circle cx="7" cy="18" r="2" />
                                    <circle cx="17" cy="18" r="2" />
                                @break

                                @case('cash')
                                    <rect x="2" y="6" width="20" height="12" rx="2" />
                                    <circle cx="12" cy="12" r="3" />
                                    <path d="M6 12h.01M18 12h.01" />
                                @break

                                @case('returns')
                                    <path d="M3 12a9 9 0 0 1 15.5-6.2L21 8" />
                                    <path d="M21 3v5h-5" />
                                    <path d="M21 12a9 9 0 0 1-15.5 6.2L3 16" />
                                    <path d="M3 21v-5h5" />
                                @break

                                @default
                                    <path d="M12 3l8 3v6c0 5-3.5 8-8 9-4.5-1-8-4-8-9V6z" />
                                    <path d="m9 12 2 2 4-4" />
                            @endswitch
                        </svg>
                    </span>

                    <div class="min-w-0">
                        <p class="text-[15px] font-semibold text-slate-900 dark:text-slate-100">{{ $t['title'] }}</p>
                        <p class="text-sm text-slate-500 dark:text-slate-400">{{ $t['text'] }}</p>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</section>
