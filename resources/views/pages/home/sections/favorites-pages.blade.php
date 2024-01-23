@if ($pageInFavorite != null && $section->visibility === 'enabled')
    <section class="section-favorites-pages">
            <div class="biddings">
                @foreach ($pageInFavorite as $page)
                    <a href="{{ route('dispensa.inexigibilidade') }}" class="item-bidding">
                        <i class="{{ $page->icon }}"></i>
                        <span>{{ $page->title }}</span>
                    </a>
                @endforeach
            </div>
        </section>
    </section>
@endif
