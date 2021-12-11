@foreach ($listings as $k => $listing)
    {{-- @if($k%3)
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-1250310795030706"
            crossorigin="anonymous"></script>
        <ins class="adsbygoogle"
            style="display:block"
            data-ad-format="fluid"
            data-ad-layout-key="-db+83+4m-f8+ef"
            data-ad-client="ca-pub-1250310795030706"
            data-ad-slot="7813512154"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    @endif --}}

    <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
        <div class="product-box-layout1 home-listing {{ $listing->is_featured() ? 'item-trending' : '' }} {{ $listing->is_fixed() ? 'item-fixed' : '' }}">
            <div class="item-img">
                <a href="{{ $listing->url() }}"><img src="{{ $listing->listing_image(['size'=>'xs']) }}" alt="Product"></a>
            </div>
            <div class="item-content">
                <h3 class="item-title"><a href="{{ $listing->url() }}" class="text-right">{{ $listing->title }}</a></h3>
                <ul class="entry-meta">
                    <li class="d-none d-sm-block"><i class="far fa-clock"></i>{{ $listing->created_at->diffForHumans() }}</li>
                    <li class="d-inline"><i class="fas fa-map-marker-alt"></i>{{ $listing->state ? $listing->state->name : '' }}{{ $listing->area ? ', '.$listing->area->name : '' }}</li>
                    <li class="d-inline"><i class="fas fa-tags"></i>{{ $listing->category ? $listing->category->name : '' }}</li>
                    @if ($listing->price)
                        {{-- <li class="d-inline mr-2">
                            <i class="fas fa-money-bill"></i>
                            {{ $listing->local_price() }}
                            <span class="currency-symbol" title="ب{{ country()->currency->name }}">{{ country()->currency->symbol }}</span>
                        </li> --}}
                        <li class="d-inline mr-2">
                            <i class="fas fa-money-bill"></i>
                            {{ preg_replace('/(\.00$)/i', '', number_format($listing->price(), 2)) }}
                            @if ($listing->currency)
                                <span class="currency-symbol" title="ب{{ $listing->currency->name }}">{{ $listing->currency->symbol }}</span>
                            @endif
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
@endforeach