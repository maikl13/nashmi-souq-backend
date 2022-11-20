@foreach ($listings as $k => $listing)
    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
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

    @if (($k+1)%4 == 0 && ($k+1)%16 != 0)
        <div class="col-12 text-center mb-3">
            @if (rand(0,1))
                <ins class="adsbygoogle"
                    style="display:block; text-align:center;"
                    data-ad-layout="in-article"
                    data-ad-format="fluid"
                    data-ad-client="ca-pub-1250310795030706"
                    data-ad-slot="4404138738"></ins>
            @else
                <ins class="adsbygoogle"
                    style="display:block"
                    data-ad-format="fluid"
                    data-ad-layout-key="-db+83+4m-f8+ef"
                    data-ad-client="ca-pub-1250310795030706"
                    data-ad-slot="7813512154"></ins>
            @endif

            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>
    @endif
    
    @if (($k+1)%16 == 0)
        <div class="col-12 text-center mb-3">
            <ins class="adsbygoogle"
                style="display:block"
                data-ad-format="autorelaxed"
                data-ad-client="ca-pub-1250310795030706"
                data-ad-slot="4359411868"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>
    @endif

    @if ((request()->page%3 != 0))
        @if (($k+1)%12 == 0)
            <div class="row d-none d-lg-block w-100 mt-3">
                @foreach (ads(rand(0,1) ? 'large_leaderboard' : 'leaderboard', 1, true) as $ad)
                    <div class="col-12 mb-3 text-center d-none d-md-block">{!! $ad !!}</div>
                @endforeach
            </div>
        @endif

        @if (($k+1)%6 == 0)
            @foreach (ads('leaderboard', 1, true) as $ad)
                <div class="col-12 mb-3 text-center d-none d-sm-block d-lg-none">{!! $ad !!}</div>
            @endforeach
            @foreach (ads(rand(0,1) ? 'mobile_banner' : 'large_rectangle', 1, true) as $ad)
                <div class="col-12 mb-3 text-center d-block d-sm-none">{!! $ad !!}</div>
            @endforeach
        @endif
    @endif
@endforeach

@include('main.layouts.partials.categories-mobile')
