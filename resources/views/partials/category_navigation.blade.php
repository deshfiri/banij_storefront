{{-- Category Navigation --}}
<nav class="category-navigation w-full  dark:bg-slate-950" aria-label="{{ t('nav.categories') }}">

    <div class="category-navigation__inner">

        {{-- All Products --}}
        <a href="{{ route('products.index') }}" class="category-navigation__all">
            {{ t('nav.all') }}
        </a>

        <div class="category-marquee">
            <div class="category-marquee__track">

                {{-- First Group --}}
                <div class="category-marquee__group">

                    <a href="{{ route('categories.show', ['slug' => 'home-kitchen']) }}" class="category-navigation__link">
                        Home & Kitchen
                    </a>

                    <a href="{{ route('categories.show', ['slug' => 'mobile-gadgets']) }}"
                        class="category-navigation__link">
                        Mobile-gadgets
                    </a>

                    <a href="{{ route('categories.show', ['slug' => 'lighting-lamps']) }}"
                        class="category-navigation__link">
                        Lighting-lamps
                    </a>

                    <a href="{{ route('categories.show', ['slug' => 'sports-outdoor']) }}"
                        class="category-navigation__link">
                        Sports-outdoor
                    </a>

                    <a href="{{ route('categories.show', ['slug' => 'baby-kids']) }}" class="category-navigation__link">
                        Baby-kids
                    </a>

                    <a href="{{ route('categories.show', ['slug' => 'office-supplies']) }}"
                        class="category-navigation__link">
                        Office-supplies
                    </a>

                    <a href="{{ route('categories.show', ['slug' => 'audio-sound']) }}"
                        class="category-navigation__link">
                        Audio-sound
                    </a>

                    <a href="{{ route('categories.show', ['slug' => 'travel-essentials']) }}"
                        class="category-navigation__link">
                        Travel-essentials
                    </a>

                    <a href="{{ route('categories.show', ['slug' => 'tools-hardware']) }}"
                        class="category-navigation__link">
                        Tools-hardware
                    </a>

                    <a href="{{ route('categories.show', ['slug' => 'gifts-bundles']) }}"
                        class="category-navigation__link">
                        Gifts-bundles
                    </a>

                </div>

                {{-- Duplicate Group --}}
                <div class="category-marquee__group" aria-hidden="true">

                    <a tabindex="-1" href="{{ route('categories.show', ['slug' => 'home-kitchen']) }}" class="category-navigation__link">
                        Home & Kitchen
                    </a>
                    <a tabindex="-1" href="{{ route('categories.show', ['slug' => 'mobile-gadgets']) }}"
                        class="category-navigation__link">mobile-gadgets</a>
                    <a tabindex="-1" href="{{ route('categories.show', ['slug' => 'lighting-lamps']) }}"
                        class="category-navigation__link">Lighting-lampst</a>
                    <a tabindex="-1" href="{{ route('categories.show', ['slug' => 'sports-outdoor']) }}"
                        class="category-navigation__link">Sports-outdoor</a>
                    <a tabindex="-1" href="{{ route('categories.show', ['slug' => 'baby-kids']) }}"
                        class="category-navigation__link">Baby-kids</a>
                    <a tabindex="-1" href="{{ route('categories.show', ['slug' => 'office-supplies']) }}"
                        class="category-navigation__link">Office-supplies</a>
                    <a tabindex="-1" href="{{ route('categories.show', ['slug' => 'audio-sound']) }}"
                        class="category-navigation__link">Audio-sound</a>
                    <a tabindex="-1" href="{{ route('categories.show', ['slug' => 'travel-essentials']) }}"
                        class="category-navigation__link">Travel-essentials</a>
                    <a tabindex="-1" href="{{ route('categories.show', ['slug' => 'tools-hardware']) }}"
                        class="category-navigation__link">Tools-hardware</a>
                    <a tabindex="-1" href="{{ route('categories.show', ['slug' => 'gifts-bundles']) }}"
                        class="category-navigation__link">Gifts-bundles</a>

                </div>

            </div>
        </div>
    </div>
</nav>
