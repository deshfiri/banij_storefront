@php
    // Set by CatalogController::home(): the ERP's featured products, or its newest when none are featured.
    $trendingProducts = $featured ?? [];
    $trendingIsNewest = $featuredIsNewest ?? false;
    $trendingEmpty = $trendingProducts === [];
@endphp

<section class="w-full bg-white py-6 md:py-8 dark:bg-slate-900" aria-labelledby="trending-title">
    <div class="mx-auto w-full max-w-[1600px] px-4 md:px-8">

        {{-- Heading + See All --}}
        <div class="mb-4 flex items-center justify-between gap-4 md:mb-6">
            <h2 id="trending-title"
                class="flex items-center gap-3 text-xl font-bold tracking-tight text-slate-900 md:text-2xl dark:text-slate-100">
                <span class="h-7 w-1 rounded-full bg-sky-500" aria-hidden="true"></span>
                {{ t($trendingIsNewest ? 'home.new_arrivals' : 'home.featured') }}
            </h2>

            <a href="{{ route('products.index') }}"
                class="inline-flex no-underline h-10 items-center gap-1 rounded-lg px-2 text-[15px] font-medium text-sky-700 transition-colors hover:text-sky-800 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-sky-400 dark:text-sky-400 dark:hover:text-sky-300">
                {{ t('home.view_all') }}

                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                    <path d="m9 6 6 6-6 6" />
                </svg>
            </a>
        </div>

        {{-- Products --}}
        @if ($trendingEmpty)
            <div class="empty">
                <svg viewBox="0 0 24 24" width="40" height="40" aria-hidden="true" focusable="false"><path d="M4 8l8-4 8 4v8l-8 4-8-4V8zm0 0l8 4m8-4l-8 4m0 8v-8" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/></svg>
                <p>{{ t('catalog.empty') }}</p>
            </div>
        @else
            <div class="grid">
                @foreach ($trendingProducts as $product)
                    @include('partials.product_card', ['product' => $product])
                @endforeach
            </div>
        @endif

        {{-- Only what the ERP says is true of this shop: cash on delivery, when it is switched on. --}}
        @if (!empty($site['cod']['enabled']))
            <ul class="mt-8 grid grid-cols-1 gap-3 sm:grid-cols-2 sm:gap-4 lg:mt-10 lg:grid-cols-4">
                <li
                    class="flex items-center gap-4 rounded-2xl border border-slate-200 bg-white px-4 py-4 sm:px-5 dark:border-slate-700 dark:bg-slate-900">
                    <span
                        class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-sky-50 text-sky-600 dark:bg-sky-950/60 dark:text-sky-300">
                        <svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor"
                            stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"
                            focusable="false">
                            <rect x="2" y="6" width="20" height="12" rx="2" />
                            <circle cx="12" cy="12" r="3" />
                            <path d="M6 12h.01M18 12h.01" />
                        </svg>
                    </span>

                    <div class="min-w-0">
                        <p class="text-[15px] font-semibold text-slate-900 dark:text-slate-100">{{ t('payment.cod') }}</p>
                        <p class="text-sm text-slate-500 dark:text-slate-400">{{ t('payment.cod_help') }}</p>
                    </div>
                </li>
            </ul>
        @endif
    </div>
</section>
