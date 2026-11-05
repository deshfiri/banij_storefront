{{-- Category navigation: the ERP's categories, none drawn when it has none. --}}
@if (!empty($categories))
    <nav class="category-navigation w-full  dark:bg-slate-950" aria-label="{{ t('nav.categories') }}">

        <div class="category-navigation__inner">

            {{-- All Products --}}
            <a href="{{ route('products.index') }}" class="category-navigation__all">
                {{ t('nav.all') }}
            </a>

            <div class="category-marquee">
                <div class="category-marquee__track">

                    @foreach ([false, true] as $isDuplicate)
                        {{-- The second group repeats the first so the marquee loops without a gap. --}}
                        <div class="category-marquee__group" @if ($isDuplicate) aria-hidden="true" @endif>
                            @foreach ($categories as $category)
                                @continue(($category['slug'] ?? '') === '')
                                <a @if ($isDuplicate) tabindex="-1" @endif
                                    href="{{ route('categories.show', ['slug' => (string) $category['slug']]) }}"
                                    class="category-navigation__link">
                                    {{ $category['name'] ?? '' }}
                                </a>
                            @endforeach
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </nav>
@endif
