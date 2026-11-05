@php
    $brand = $site['branding'] ?? [];
    $shopName = (string) ($site['name'] ?? config('app.name'));
    $pageTitle = isset($title) && $title !== '' && $title !== $shopName ? $title . ' · ' . $shopName : $shopName;
    $logo = safe_url($brand['logo_url'] ?? null);
    $primary = (string) ($brand['primary_color'] ?? '#1f2937');
    $secondary = (string) ($brand['secondary_color'] ?? '#c2410c');
    $initial = mb_strtoupper(mb_substr(trim($shopName) === '' ? '?' : trim($shopName), 0, 1));
    $locale = $locale ?? 'en';
    $other = $locale === 'bn' ? 'en' : 'bn';
    $cartCount = $cartCount ?? 0;
@endphp
<!doctype html>
<html lang="{{ $locale }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle }}</title>
    @if (!empty($description))
        <meta name="description" content="{{ $description }}">
    @endif
    @if (!empty($noindex))
        <meta name="robots" content="noindex, nofollow">
    @endif
    <meta name="theme-color" content="{{ $primary }}">
    @if (!empty($image))
        <meta property="og:image" content="{{ safe_url($image) }}">
        <meta property="og:title" content="{{ $title ?? '' }}">
    @endif
    <style>
        :root {
            --brand: {{ $primary }};
            --on-brand: {{ on_colour($primary) }};
            --accent: {{ $secondary }};
            --on-accent: {{ on_colour($secondary) }}
        }
    </style>
    <link rel="stylesheet" href="{{ versioned_asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/tailwind.css') }}">
    <script src="{{ versioned_asset('js/theme.js') }}"></script>
</head>

<body class="">
    <a class="skip" href="#main">{{ t('nav.skip') }}</a>


    @php
        // Shared Tailwind classes. Presentation only, nothing functional.
        // Sky "soft" button: used by track, language, theme toggle and menu button.
        $navBtn =
            'items-center justify-center rounded-lg border border-sky-200 bg-sky-50 text-[15px] font-medium text-sky-800 cursor-pointer transition-colors hover:border-sky-700 hover:bg-sky-700 hover:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-sky-400 focus-visible:ring-offset-2 dark:border-sky-900 dark:bg-sky-950/60 dark:text-sky-200 dark:hover:border-sky-700 dark:hover:bg-sky-700 dark:hover:text-white dark:focus-visible:ring-offset-slate-900';

        // Items inside the dropdown menu.
        $menuItem =
            'block w-full rounded-lg px-3 py-2.5 text-start text-[15px] font-medium text-slate-700 cursor-pointer transition-colors hover:bg-sky-700 hover:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-sky-400 dark:text-slate-200 dark:hover:bg-sky-700 dark:hover:text-white';

        // Category pills.
        $chip =
            'shrink-0 whitespace-nowrap rounded-full border border-sky-200 bg-sky-50 px-4 py-2 text-sm font-medium text-sky-800 transition-colors hover:border-sky-700 hover:bg-sky-700 hover:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-sky-400 dark:border-sky-900 dark:bg-sky-950/60 dark:text-sky-200 dark:hover:border-sky-700 dark:hover:bg-sky-700 dark:hover:text-white';
    @endphp

    <header
        class="relative z-50 w-full border-b border-slate-100  text-slate-900 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-100">

        {{-- Main Header --}}
        <div class="mx-auto w-full max-w-[1600px] px-4 py-3 md:px-8">

            {{-- Phone: row 1 = logo + actions, row 2 = search. Tablet and desktop: one row. --}}
            <div
                class="flex min-h-[56px] flex-wrap items-center gap-x-3 gap-y-3 md:min-h-[64px] md:flex-nowrap md:gap-x-5">

                {{-- Brand Logo --}}
                <a href="{{ route('home') }}" aria-label="{{ $shopName }}"
                    class="order-1 flex min-w-0 max-w-[130px] shrink-0 items-center rounded-lg focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-sky-400 min-[380px]:max-w-[160px] sm:max-w-[220px]">

                    @if ($logo !== '')
                        <img src="{{ $logo }}" alt="{{ $shopName }}" width="240" height="64"
                            class="h-9 w-auto max-w-full object-contain md:h-14" data-fallback="brand-mark">
                    @endif

                    <span class="brand-mark text-2xl font-bold text-sky-600" aria-hidden="true" {!! $logo !== '' ? ' hidden' : '' !!}>
                        {{ $initial }}
                    </span>

                    @if ($logo === '')
                        <span
                            class="brand-name ml-2 min-w-0 truncate text-lg font-extrabold  tracking-tight text-sky-600 sm:text-xl md:text-2xl">
                            {{ $shopName }}
                        </span>
                    @endif
                </a>

                {{-- Search Form --}}
                <form action="{{ route('search') }}" method="get" role="search"
                    class="order-3 flex h-11 w-full min-w-0 overflow-hidden rounded-xl border border-slate-300 bg-white shadow-sm transition focus-within:border-sky-500 focus-within:ring-2 focus-within:ring-sky-100 md:order-2 md:h-12 md:w-auto md:max-w-3xl md:flex-1 dark:border-slate-700 dark:bg-slate-900 dark:focus-within:ring-sky-900">

                    <label class="sr-only" for="q">
                        {{ t('nav.search') }}
                    </label>

                    <input id="q" name="q" type="search" maxlength="100" value="{{ $searchTerm ?? '' }}"
                        placeholder="{{ t('nav.search_placeholder') }}"
                        class="w-full min-w-0 flex-1 border-0 bg-transparent px-3 text-base text-slate-700 outline-none placeholder:text-slate-400 focus:ring-0 md:px-4 dark:text-slate-100 dark:placeholder:text-slate-500">

                    <button type="submit" aria-label="{{ t('nav.search') }}"
                        class="flex w-11 shrink-0 items-center justify-center bg-sky-600 text-white transition-colors hover:bg-sky-700 focus-visible:bg-sky-800 focus-visible:outline-none md:w-14">

                        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" focusable="false"
                            class="h-5 w-5 md:h-[22px] md:w-[22px]">
                            <circle cx="10.8" cy="10.8" r="6.8" stroke="currentColor" stroke-width="2" />
                            <path d="m16 16 5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        </svg>

                    </button>
                </form>


                <nav class="order-2 ml-auto flex items-center gap-1 sm:gap-1.5 md:order-3 [&_a]:no-underline [&_button]:no-underline"
                    aria-label="{{ t('nav.account') }}">

                    {{-- Track order: Large screens --}}
                    <a href="{{ route('track.form') }}"
                        class="{{ $navBtn }} hidden h-10 px-3.5 lg:inline-flex no-underline hover:no-underline">
                        {{ t('nav.track') }}
                    </a>

                    {{-- Language switch: Large screens --}}
                    <form action="{{ route('locale.update') }}" method="post" class="hidden lg:block">
                        @csrf
                        <input type="hidden" name="locale" value="{{ $other }}">

                        <button type="submit" lang="{{ $other }}"
                            class="{{ $navBtn }} inline-flex h-10 px-3.5 no-underline hover:no-underline">
                            {{ $other === 'en' ? 'English' : 'বাংলা' }}
                        </button>
                    </form>

                    {{-- Theme toggle
                    <button type="button" data-theme-toggle data-label-dark="{{ t('nav.theme_to_dark') }}"
                        data-label-light="{{ t('nav.theme_to_light') }}" aria-label="{{ t('nav.theme_to_dark') }}"
                        hidden class="{{ $navBtn }} inline-flex h-11 w-11 md:h-10 md:w-10 [&[hidden]]:hidden">

                        <svg class="block dark:hidden" viewBox="0 0 24 24" width="22" height="22"
                            aria-hidden="true" focusable="false">
                            <path d="M20 14.5A8 8 0 0 1 9.5 4a8 8 0 1 0 10.5 10.5Z" fill="none" stroke="currentColor"
                                stroke-width="1.8" stroke-linejoin="round" />
                        </svg>

                        <svg class="hidden dark:block" viewBox="0 0 24 24" width="22" height="22"
                            aria-hidden="true" focusable="false">
                            <circle cx="12" cy="12" r="4" fill="none" stroke="currentColor"
                                stroke-width="1.8" />
                            <path
                                d="M12 3v2M12 19v2M3 12h2M19 12h2M5.6 5.6l1.4 1.4M17 17l1.4 1.4M18.4 5.6 17 7M7 17l-1.4 1.4"
                                fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                        </svg>
                    </button> --}}

                    {{-- Cart --}}
                    <a href="{{ route('cart.show') }}"
                        class="relative inline-flex h-11 w-11 items-center justify-center gap-2 rounded-xl bg-sky-700 px-3.5 text-[15px] font-semibold text-white no-underline transition-all duration-200 hover:bg-sky-800 hover:text-white hover:no-underline focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-sky-400 focus-visible:ring-offset-2 sm:w-auto md:h-10 dark:focus-visible:ring-offset-slate-900">

                        <svg viewBox="0 0 24 24" width="22" height="22" aria-hidden="true" focusable="false"
                            class="shrink-0">
                            <path d="M3 4h2l2.4 11.2a1 1 0 0 0 1 .8h8.9a1 1 0 0 0 1-.76L20 8H6.2" fill="none"
                                stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <circle cx="9.5" cy="20" r="1.4" fill="currentColor" />
                            <circle cx="17" cy="20" r="1.4" fill="currentColor" />
                        </svg>

                        <span class="sr-only sm:not-sr-only">{{ t('nav.cart') }}</span>

                        @if ($cartCount > 0)
                            <span
                                class="absolute -right-1.5 -top-1.5 inline-flex h-5 min-w-[20px] items-center justify-center rounded-full bg-slate-900 px-1.5 text-xs font-bold leading-none text-white ring-2 ring-white sm:static sm:ring-0 dark:ring-slate-900"
                                aria-label="{{ t('nav.cart_items', ['n' => (string) $cartCount]) }}">
                                {{ num($cartCount) }}
                            </span>
                        @endif
                    </a>

                    {{-- Mobile / Tablet Menu: Hidden on large screens --}}
                    <details class="group relative lg:hidden">

                        <summary aria-label="{{ t('nav.menu_open') }}"
                            class="{{ $navBtn }} inline-flex h-11 w-11 list-none select-none rounded-xl group-open:border-sky-700 group-open:bg-sky-700 group-open:text-white md:h-10 md:w-10 [&::-webkit-details-marker]:hidden">

                            <svg viewBox="0 0 24 24" width="24" height="24" aria-hidden="true"
                                focusable="false">
                                <path d="M4 7h16M4 12h16M4 17h16" fill="none" stroke="currentColor"
                                    stroke-width="1.8" stroke-linecap="round" />
                            </svg>

                            <span class="sr-only">{{ t('nav.menu') }}</span>
                        </summary>

                        {{-- Dropdown --}}
                        <div
                            class="absolute end-0 top-full z-50 mt-2 flex max-h-[calc(100vh-6rem)] w-72 max-w-[calc(100vw-2rem)] flex-col gap-1 overflow-y-auto rounded-2xl border border-slate-200 bg-white p-2 shadow-xl shadow-slate-900/10 dark:border-slate-700 dark:bg-slate-900">

                            <a href="{{ route('track.form') }}"
                                class="{{ $menuItem }} no-underline hover:no-underline">
                                {{ t('nav.track') }}
                            </a>

                            <a href="{{ route('about') }}"
                                class="{{ $menuItem }} no-underline hover:no-underline">
                                {{ t('page.about') }}
                            </a>

                            <a href="{{ route('contact') }}"
                                class="{{ $menuItem }} no-underline hover:no-underline">
                                {{ t('page.contact') }}
                            </a>

                            <form action="{{ route('locale.update') }}" method="post"
                                class="mt-1 border-t border-slate-200 pt-2 dark:border-slate-700">
                                @csrf
                                <input type="hidden" name="locale" value="{{ $other }}">

                                <button type="submit" lang="{{ $other }}"
                                    class="{{ $menuItem }} w-full text-left no-underline hover:no-underline">
                                    {{ $other === 'en' ? 'English' : 'বাংলা' }}
                                </button>
                            </form>
                        </div>
                    </details>
                </nav>

            </div>

            {{-- Categories: one scrollable row on phones, wrapping pills from tablet up --}}
            {{-- @if (!empty($categories))
                <nav class="mt-3 border-t border-slate-100 pt-3 dark:border-slate-800"
                    aria-label="{{ t('nav.categories') }}">
                    <div
                        class="-mx-4 flex gap-2 overflow-x-auto px-4 pb-1 [scrollbar-width:none] md:mx-0 md:flex-wrap md:overflow-visible md:px-0 [&::-webkit-scrollbar]:hidden">
                        <a href="{{ route('products.index') }}" class="{{ $chip }}">{{ t('nav.all') }}</a>
                        @foreach ($categories as $category)
                            <a href="{{ route('categories.show', ['slug' => (string) ($category['slug'] ?? '')]) }}"
                                class="{{ $chip }}">{{ $category['name'] ?? '' }}</a>
                        @endforeach
                    </div>
                </nav>
            @endif --}}
        </div>
    </header>
    @include('partials.category_navigation')



    {{-- @if (!($site['accepting_orders'] ?? true))
        <div class="notice notice-warning" role="status">
            <div class="container">
                {{ t('site.not_accepting') }}
            </div>
        </div>
    @endif --}}


    <main id="main" class="w-full  ">

        {{-- Existing Flash Messages --}}
        @foreach ($flash ?? [] as $message)
            {{-- <div class="flash flash-{{ $message['type'] }}"
                role="{{ $message['type'] === 'error' ? 'alert' : 'status' }}">
                {{ $message['message'] }} --}}
            </div>
        @endforeach

        {{-- Homepage Hero Banner --}}
        @if (request()->routeIs('home'))
            <section class="relative mt-5 w-full px-3 pb-4 sm:px-6 sm:pb-6 lg:px-8">

                <div class="mx-auto w-full max-w-[1700px] overflow-hidden rounded-xl sm:rounded-2xl">

                    <img src="{{ asset('assets/home_images/home_images.jpg') }}"
                        alt="{{ $shopName }} - Homepage Banner"
                        class="block h-auto max-h-[650px] w-full object-cover object-center" fetchpriority="high"
                        decoding="async">

                </div>

            </section>
        @endif
        {{-- Homepage Sections Only --}}
        @if (request()->routeIs('home'))
            @include('partials.categorybyproduct')

            @include('partials.trending')
        @endif

        {{-- Existing Page Content --}}
        <div class="container">
            @yield('content')

        </div>

    </main>



    {{--
    @include('partials.categorybyproduct')
    @include('partials.trending') --}}


    <footer class="w-full border-t border-gray-200 bg-gray-50 text-slate-700">

        {{-- Main Footer --}}
        <div class="mx-auto max-w-[1600px] px-5 py-12 sm:px-8 lg:px-12 lg:py-16">

            <div class="grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-5 lg:gap-12">

                {{-- Brand --}}
                <div class="lg:col-span-1">

                    <a href="{{ route('products.index') }}" class="mb-4 inline-flex items-center no-underline">

                        <img src="https://minimindsplay.com/storage/settings/6B5OmcUkpscJc7XS43TLLvGFOPIfGwYpP6lAMXub.webp"
                            alt="Mini Minds" class="h-14 w-auto max-w-[180px] object-contain" loading="lazy">

                    </a>

                    <p class="max-w-xs text-sm leading-7 text-slate-500">
                        Bangladesh's most trusted online marketplace.
                    </p>

                    {{-- Social Media --}}
                    <div class="mt-6 flex items-center gap-3">

                        {{-- Facebook --}}
                        <a href="https://www.facebook.com/minimindsplay" target="_blank" rel="noopener noreferrer"
                            aria-label="Facebook"
                            class="flex h-10 w-10 items-center justify-center rounded-full bg-white text-slate-600 ring-1 ring-gray-200 transition hover:bg-sky-500 hover:text-white hover:ring-sky-500">

                            <svg viewBox="0 0 24 24" class="h-5 w-5" fill="currentColor" aria-hidden="true">
                                <path
                                    d="M13.5 21v-8.2h2.8l.4-3.2h-3.2V7.5c0-.9.3-1.5 1.6-1.5h1.7V3.1c-.3 0-1.4-.1-2.6-.1-2.6 0-4.4 1.6-4.4 4.5v2.1H7v3.2h2.8V21h3.7z" />
                            </svg>

                        </a>

                        {{-- YouTube --}}
                        @if (!empty($brand['youtube']))
                            <a href="{{ $brand['youtube'] }}" target="_blank" rel="noopener noreferrer"
                                aria-label="YouTube"
                                class="flex h-10 w-10 items-center justify-center rounded-full bg-white text-slate-600 ring-1 ring-gray-200 transition hover:bg-red-500 hover:text-white hover:ring-red-500">

                                <svg viewBox="0 0 24 24" class="h-5 w-5" fill="currentColor" aria-hidden="true">
                                    <path
                                        d="M23 7.2a3 3 0 0 0-2.1-2.1C19 4.6 12 4.6 12 4.6s-7 0-8.9.5A3 3 0 0 0 1 7.2 31 31 0 0 0 .5 12a31 31 0 0 0 .5 4.8 3 3 0 0 0 2.1 2.1c1.9.5 8.9.5 8.9.5s7 0 8.9-.5a3 3 0 0 0 2.1-2.1 31 31 0 0 0 .5-4.8 31 31 0 0 0-.5-4.8ZM9.8 15.3V8.7l5.8 3.3-5.8 3.3Z" />
                                </svg>

                            </a>
                        @endif

                        {{-- Instagram --}}
                        @if (!empty($brand['instagram']))
                            <a href="{{ $brand['instagram'] }}" target="_blank" rel="noopener noreferrer"
                                aria-label="Instagram"
                                class="flex h-10 w-10 items-center justify-center rounded-full bg-white text-slate-600 ring-1 ring-gray-200 transition hover:bg-pink-500 hover:text-white hover:ring-pink-500">

                                <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor"
                                    stroke-width="1.8" aria-hidden="true">
                                    <rect x="3" y="3" width="18" height="18" rx="5" />
                                    <circle cx="12" cy="12" r="4" />
                                    <circle cx="18" cy="6" r="1" fill="currentColor"
                                        stroke="none" />
                                </svg>

                            </a>
                        @endif

                        {{-- TikTok --}}
                        @if (!empty($brand['tiktok']))
                            <a href="{{ $brand['tiktok'] }}" target="_blank" rel="noopener noreferrer"
                                aria-label="TikTok"
                                class="flex h-10 w-10 items-center justify-center rounded-full bg-white text-slate-600 ring-1 ring-gray-200 transition hover:bg-slate-900 hover:text-white hover:ring-slate-900">

                                <svg viewBox="0 0 24 24" class="h-5 w-5" fill="currentColor" aria-hidden="true">
                                    <path
                                        d="M19.6 8.2a7.3 7.3 0 0 1-4.4-1.5v7.1a5.7 5.7 0 1 1-5.7-5.7c.4 0 .8 0 1.2.1v3.2a2.6 2.6 0 1 0 1.4 2.4V2.5h3.2c.2 2.1 1.8 3.8 4.3 4v1.7Z" />
                                </svg>

                            </a>
                        @endif

                    </div>

                </div>


                {{-- Shop --}}
                <div>

                    <h3 class="mb-5 text-sm font-bold uppercase tracking-wider text-slate-900">
                        Shop
                    </h3>

                    <ul class="space-y-3 text-sm">

                        <li>
                            <a href="{{ route('products.index', ['sort' => 'discount']) }}"
                                class="text-slate-500 no-underline transition hover:text-sky-600">
                                Flash Deals
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('products.index', ['sort' => 'newest']) }}"
                                class="text-slate-500 no-underline transition hover:text-sky-600">
                                New Arrivals
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('products.index', ['sort' => 'popular']) }}"
                                class="text-slate-500 no-underline transition hover:text-sky-600">
                                Best Sellers
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('products.index') }}"
                                class="text-slate-500 no-underline transition hover:text-sky-600">
                                All Categories
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('cart.show') }}"
                                class="text-slate-500 no-underline transition hover:text-sky-600">
                                {{ t('nav.cart') }}
                            </a>
                        </li>

                    </ul>

                </div>


                {{-- Support --}}
                <div>

                    <h3 class="mb-5 text-sm font-bold uppercase tracking-wider text-slate-900">
                        Support
                    </h3>

                    <ul class="space-y-3 text-sm">

                        <li>
                            <a href="{{ route('track.form') }}"
                                class="text-slate-500 no-underline transition hover:text-sky-600">
                                Track Order
                            </a>
                        </li>

                        <li>
                            <a href="https://minimindsplay.com/page/return-policy"
                                class="text-slate-500 no-underline transition hover:text-sky-600">
                                Returns
                            </a>
                        </li>

                        <li>
                            <a href="https://minimindsplay.com/page/faq"
                                class="text-slate-500 no-underline transition hover:text-sky-600">
                                FAQ
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('contact') }}"
                                class="text-slate-500 no-underline transition hover:text-sky-600">
                                Contact Us
                            </a>
                        </li>

                    </ul>

                </div>


                {{-- Company --}}
                <div>

                    <h3 class="mb-5 text-sm font-bold uppercase tracking-wider text-slate-900">
                        Company
                    </h3>

                    <ul class="space-y-3 text-sm">

                        <li>
                            <a href="{{ route('about') }}"
                                class="text-slate-500 no-underline transition hover:text-sky-600">
                                About Us
                            </a>
                        </li>

                        <li>
                            <a href="https://minimindsplay.com/page/privacy-policy"
                                class="text-slate-500 no-underline transition hover:text-sky-600">
                                Privacy Policy
                            </a>
                        </li>

                        <li>
                            <a href="https://minimindsplay.com/page/terms"
                                class="text-slate-500 no-underline transition hover:text-sky-600">
                                Terms & Conditions
                            </a>
                        </li>

                        <li>
                            <a href="https://minimindsplay.com/page/shipping-policy"
                                class="text-slate-500 no-underline transition hover:text-sky-600">
                                Shipping Policy
                            </a>
                        </li>

                    </ul>

                </div>


                {{-- Get the App --}}
                <div>

                    <h3 class="mb-5 text-sm font-bold uppercase tracking-wider text-slate-900">
                        Get the App
                    </h3>

                    <p class="mb-5 text-sm leading-6 text-slate-500">
                        Shop faster with our mobile app coming soon to your store.
                    </p>

                    <div class="flex flex-wrap gap-3">

                        <a href="https://minimindsplay.com/#"
                            class="flex items-center gap-3 rounded-xl bg-slate-900 px-4 py-3 text-white no-underline transition hover:bg-slate-700">

                            <svg viewBox="0 0 24 24" class="h-7 w-7" fill="currentColor" aria-hidden="true">
                                <path
                                    d="M16.4 12.7c0-2 1.6-3 1.7-3.1a3.7 3.7 0 0 0-2.9-1.6c-1.2-.1-2.3.7-2.9.7s-1.5-.7-2.5-.7a3.8 3.8 0 0 0-3.2 2c-1.4 2.4-.4 6 1 8 .7 1 1.5 2.1 2.5 2.1s1.3-.7 2.6-.7 1.6.7 2.6.7 1.7-1 2.4-2a9 9 0 0 0 1.1-2.3 3.5 3.5 0 0 1-2.4-3.1ZM14.5 6.8A3.5 3.5 0 0 0 15.3 4a3.7 3.7 0 0 0-2.5 1.3 3.3 3.3 0 0 0-.8 2.7 3.2 3.2 0 0 0 2.5-1.2Z" />
                            </svg>

                            <span>
                                <span class="block text-[10px]">Download on the</span>
                                <span class="block text-sm font-semibold">App Store</span>
                            </span>

                        </a>

                        <a href="https://minimindsplay.com/#"
                            class="flex items-center gap-3 rounded-xl bg-slate-900 px-4 py-3 text-white no-underline transition hover:bg-slate-700">

                            <svg viewBox="0 0 24 24" class="h-7 w-7" fill="currentColor" aria-hidden="true">
                                <path
                                    d="M3.5 2.5 14 12 3.5 21.5c-.3-.3-.5-.8-.5-1.4V3.9c0-.6.2-1.1.5-1.4Zm1.2-.8 11 6.3-2.5 2.3L4.7 1.7Zm11 13.3 2.8 1.6-11 6.3 8.2-7.9Zm4.2-4.2c.9.5.9 1.9 0 2.4l-2.8 1.6-3-2.8 3-2.8 2.8 1.6Z" />
                            </svg>

                            <span>
                                <span class="block text-[10px]">Get it on</span>
                                <span class="block text-sm font-semibold">Google Play</span>
                            </span>

                        </a>

                    </div>

                </div>

            </div>


            {{-- Contact Information --}}
            @if (!empty($site['contact']['phone']) || !empty($site['contact']['email']) || !empty($site['contact']['address']))
                <div
                    class="mt-12 flex flex-col gap-3 border-t border-gray-200 pt-7 text-sm text-slate-500 sm:flex-row sm:flex-wrap sm:items-center sm:gap-7">

                    @if (!empty($site['contact']['phone']))
                        <span>{{ $site['contact']['phone'] }}</span>
                    @endif

                    @if (!empty($site['contact']['email']))
                        <span>{{ $site['contact']['email'] }}</span>
                    @endif

                    @if (!empty($site['contact']['address']))
                        <span>{{ $site['contact']['address'] }}</span>
                    @endif

                </div>
            @endif

        </div>


        {{-- Bottom Footer --}}
        <div class="border-t border-gray-200 bg-white">

            <div
                class="mx-auto flex max-w-[1600px] flex-col items-center justify-between gap-5 px-5 py-6 text-center sm:px-8 md:flex-row md:text-left lg:px-12">

                <p class="text-xs text-slate-500">
                    {{ t('footer.rights', ['year' => gmdate('Y'), 'name' => $shopName]) }}
                </p>

                <div class="flex flex-col items-center gap-4 sm:flex-row">

                    {{-- Payment Methods --}}
                    <div class="flex items-center gap-3">
                        <span class="text-xs font-semibold text-slate-500">
                            We accept
                        </span>

                        <img src="{{ asset('assets/img/payment-methods.png') }}" alt="Accepted payment methods"
                            class="h-8 max-w-[190px] object-contain" loading="lazy">
                    </div>

                    <span class="hidden h-5 w-px bg-gray-200 sm:block"></span>

                    <span class="text-xs text-slate-500">
                        {{ t('footer.powered') }}
                    </span>

                    <a href="#main"
                        class="text-xs font-semibold text-sky-600 no-underline transition hover:text-sky-700">
                        {{ t('footer.top') }} ↑
                    </a>

                </div>

            </div>

        </div>

    </footer>


    <script src="{{ versioned_asset('js/app.js') }}" defer></script>
</body>

</html>
