@extends('main.layouts.main')

@section('title', 'الرئيسية')

@section('content')
    <!--=====================================-->
    <!--=            Banner Start           =-->
    <!--=====================================-->
    <section class="main-banner-wrap-layout1 bg-dark-overlay bg-common {{-- minus-mgt-90 --}}" data-bg-image="/assets/images/banner/banner1.jpg" style="padding: 8rem 0 7rem;">
        <div class="container">
            <div class="main-banner-box-layout1 animated-headline">
                <h1 class="ah-headline item-title" style="line-height: 60px; font-size: 2.5rem">
                    <span class="ah-words-wrapper">
                        <b class="is-visible">{{ setting('slogan') }}</b>
                        <b>{{ setting('slogan') }}</b>
                    </span>
                </h1>
                
                <div class="item-subtitle">إبحث في أكثر من {{ App\Models\Listing::count() }} إعلان موزعين بين أكثر من {{ App\Models\Category::count() }} قسم</div>

                @include('main.layouts.partials.search-box')

                <div class="row mt-4">
                    <div class="col mt-4 text-center d-none d-md-block">{!! ad('large_leaderboard') !!}</div>
                    <div class="col mt-4 text-center d-block d-md-none">{!! ad('mobile_banner') !!}</div>
                </div>
            </div>
        </div>
    </section>

    <!--=====================================-->
    <!--=            Category Start           =-->
    <!--=====================================-->
    @if(App\Models\Category::count())
        <section class="section-padding-top-heading">
            <div class="container">
                <div class="heading-layout1">
                    <h2 class="heading-title">أشهر الأقسام</h2>
                </div>
                
                {{-- ad spaces --}}
                <div class="row mb-4">
                    <div class="col-md-6 mb-3 text-center d-none d-md-block">{!! ad('leaderboard') !!}</div>
                    <div class="col-md-6 mb-3 text-center d-block d-md-none">{!! ad('mobile_banner') !!}</div>
                    <div class="col-md-6 mb-3 text-center d-none d-md-block">{!! ad('leaderboard') !!}</div>
                    <div class="col-md-6 mb-3 text-center d-block d-md-none">{!! ad('mobile_banner') !!}</div>
                </div>

                <div class="row">
                    @foreach(App\Models\Category::limit(8)->inRandomOrder()->get() as $category)
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="category-box-layout1">
                                <a href="/listings?categories[]={{ $category->id }}">
                                    <div class="item-icon">
                                        <i class="{{ $category->icon }}"></i>
                                    </div>
                                    <div class="item-content">
                                        <h3 class="item-title">{{ $category->name }}</h3>
                                        <div class="item-count">{{ $category->listings()->count() }} إعلان</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @include('main.layouts.partials.open-store-promo')

    <!--=====================================-->
    <!--=       Product Box Start           =-->
    <!--=====================================-->
    <section class="section-padding-top-heading bg-accent">
        <div class="container">
            <div class="heading-layout1">
                <h2 class="heading-title">إعلانات مميزة</h2>
            </div>

            <div class="row">
                @foreach (App\Models\Listing::localized()->active()->featured()->limit(12)->get() as $listing)
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                        <div class="product-box-layout1 home-listing {{ $listing->is_featured() ? 'item-trending' : '' }} {{ $listing->is_fixed() ? 'item-fixed' : '' }}">
                            <div class="item-img">
                                <a href="{{ $listing->url() }}"><img src="{{ $listing->listing_image() }}" alt="Product"></a>
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
                                            {{ $listing->local_price() }}
                                            <span class="currency-symbol" title="ب{{ country()->currency->name }}">{{ country()->currency->symbol }}</span>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
                
            {{-- ad spaces --}}
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-3 text-center">{!! ad('large_rectangle') !!}</div>
                <div class="col-lg-3 col-md-6 mb-3 text-center">{!! ad('large_rectangle') !!}</div>
                <div class="col-lg-3 col-md-6 mb-3 text-center">{!! ad('large_rectangle') !!}</div>
                <div class="col-lg-3 col-md-6 mb-3 text-center">{!! ad('large_rectangle') !!}</div>
            </div>
        </div>
    </section>

    @include('main.layouts.partials.counter')

    <!--=====================================-->
    <!--=          Brnad Start              =-->
    <!--=====================================-->
    <section class="brand-wrap-layout1" dir="ltr">
        <div class="container py-5">
            <div class="rc-carousel" data-loop="true" data-items="10" data-margin="30" data-autoplay="true" data-autoplay-timeout="3000" data-smart-speed="1000" data-dots="false" data-nav="true" data-nav-speed="false" data-r-x-small="1" data-r-x-small-nav="false" data-r-x-small-dots="false" data-r-x-medium="2" data-r-x-medium-nav="false" data-r-x-medium-dots="false" data-r-small="2" data-r-small-nav="false" data-r-small-dots="false" data-r-medium="2" data-r-medium-nav="false" data-r-medium-dots="false" data-r-large="3" data-r-large-nav="false" data-r-large-dots="false" data-r-extra-large="4" data-r-extra-large-nav="false" data-r-extra-large-dots="false">
                {!! ad('mobile_banner') !!}
                {!! ad('mobile_banner') !!}
                {!! ad('mobile_banner') !!}
                {!! ad('mobile_banner') !!}
                {!! ad('mobile_banner') !!}
                {!! ad('mobile_banner') !!}
                {!! ad('mobile_banner') !!}
                {!! ad('mobile_banner') !!}
            </div>
        </div>

    </section>
@endsection

@section('modals')
    @include('main.layouts.partials.search-modals')
@endsection

@section('scripts')
    @include('main.layouts.partials.search-box-scripts')
@endsection