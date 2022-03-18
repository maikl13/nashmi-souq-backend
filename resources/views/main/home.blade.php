@extends('main.layouts.main')

@section('title', 'الرئيسية')

@section('head')
    <style>
        @media (max-width: 575px){
            .home-listing { max-height: 110px; }
        }
    </style>
@endsection

@section('content')
    <!--=====================================-->
    <!--=            Banner Start           =-->
    <!--=====================================-->
    <section class="main-banner-wrap-layout1 bg-dark-overlay bg-common py-5 {{-- minus-mgt-90 --}}" data-bg-image="/assets/images/banner/banner1.jpg">
        <div class="container py-lg-5">
            <div class="main-banner-box-layout1 animated-headline- py-xl-3">
                <div class="d-none d-lg-block">
                    <h1 class="ah-headline- item-title" style="line-height: 60px; font-size: 2.5rem">
                        <span class="ah-words-wrapper-">
                            {{-- <b class="is-visible">{{ setting('slogan') }}</b> --}}
                            <b>{{ setting('slogan') }}</b>
                        </span>
                    </h1>
                    
                    <div class="item-subtitle">إبحث في أكثر من {{ App\Models\Listing::count() + 36200 }} إعلان موزعين بين أكثر من {{ App\Models\Category::count() }} قسم</div>
                </div>

                @include('main.layouts.partials.search-box')

                {{-- ad spaces --}}
                <div class="container" dir="ltr">
                    <div class="rc-carousel" data-loop="true" data-items="10" data-margin="30" data-autoplay="true" data-autoplay-timeout="2000" data-smart-speed="500" data-dots="false" data-nav="true" data-nav-speed="false" data-r-x-small="1" data-r-x-small-nav="false" data-r-x-small-dots="false" data-r-x-medium="1" data-r-x-medium-nav="false" data-r-x-medium-dots="false" data-r-small="1" data-r-small-nav="false" data-r-small-dots="false" data-r-medium="2" data-r-medium-nav="false" data-r-medium-dots="false" data-r-large="1" data-r-large-nav="false" data-r-large-dots="false" data-r-extra-large="1" data-r-extra-large-nav="false" data-r-extra-large-dots="false">
                        @foreach (ads('large_leaderboard', 7) as $ad)
                            <span class="d-block mt-3">{!! $ad !!}</span>
                        @endforeach
                   </div>
                </div>
            </div>
        </div>
    </section>

    <!--=====================================-->
    <!--=       Product Box Start           =-->
    <!--=====================================-->

    @include('main.layouts.partials.home-fixed-listings')

    <section class="section-padding-top-heading bg-accent">
        <div class="container">
            <div class="heading-layout1">
                <h2 class="heading-title">أحدث الإعلانات</h2>
            </div>

            <div class="row listings">
                @include('main.layouts.partials.home-listings')
            </div>

            <div class="row ">
                <div class="col-sm-12 text-center">
                    <a class="more-listings btn btn-default btn-block mb-3 py-3 px-5" style="background: #e65c70;color: white;cursor: pointer;">
                        المزيد من الإعلانات
                    </a>
                </div>
            </div>

            {{-- ad spaces --}}
            <div class="container" dir="ltr">
                <div class="rc-carousel" data-loop="true" data-items="10" data-margin="30" data-autoplay="true" data-autoplay-timeout="2000" data-smart-speed="1000" data-dots="false" data-nav="true" data-nav-speed="false" data-r-x-small="1" data-r-x-small-nav="false" data-r-x-small-dots="false" data-r-x-medium="2" data-r-x-medium-nav="false" data-r-x-medium-dots="false" data-r-small="2" data-r-small-nav="false" data-r-small-dots="false" data-r-medium="2" data-r-medium-nav="false" data-r-medium-dots="false" data-r-large="3" data-r-large-nav="false" data-r-large-dots="false" data-r-extra-large="4" data-r-extra-large-nav="false" data-r-extra-large-dots="false">
                    @foreach (ads('large_rectangle', 10) as $ad)
                        {!! $ad !!}
                    @endforeach
                </div>
            </div>
        </div>
    </section>
                

    @include('main.layouts.partials.open-store-promo')

    @if (\App\Models\User::whereNotNull('store_name')->inRandomOrder()->count())
        <section class="section-padding-top-heading">
            <div class="container">
                <div class="heading-layout1">
                    <h2 class="heading-title">متاجر سوق نشمي</h2>
                </div>
                <div class="container" dir="ltr">
                    <div class="rc-carousel" data-loop="true" data-items="10" data-margin="30" data-autoplay="true" data-autoplay-timeout="2000" data-smart-speed="1000" data-dots="false" data-nav="true" data-nav-speed="false" data-r-x-small="2" data-r-x-small-nav="false" data-r-x-small-dots="false" data-r-x-medium="3" data-r-x-medium-nav="false" data-r-x-medium-dots="false" data-r-small="3" data-r-small-nav="false" data-r-small-dots="false" data-r-medium="4" data-r-medium-nav="false" data-r-medium-dots="false" data-r-large="4" data-r-large-nav="false" data-r-large-dots="false" data-r-extra-large="5" data-r-extra-large-nav="false" data-r-extra-large-dots="false">
                        @foreach(\App\Models\User::whereNotNull('store_name')->whereHas('products')->whereHas('active_subscriptions')->inRandomOrder()->limit(20)->get() as $store)
                            <div class="store-list-layout1">
                                <a href="{{ $store->store_url() }}">
                                    <div class="item-logo">
                                        <img src="{{ $store->store_image(['size'=>'xs']) }}" style="width: 100%; height: 100px; object-fit: contain;" alt="store">
                                    </div>
                                    <div class="item-content" dir="rtl">
                                        <h3 class="item-title">{{ $store->store_name() }}</h3>
                                        <div class="ad-count">{{ $store->products()->count() }} منتج</div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    <section class="section-padding-top-heading py-3" style="background: rgb(248,92,112);background: linear-gradient(45deg, rgba(248,92,112,0.6) 0%, rgba(230,92,112,1) 80%);">
        <div class="container text-center">
            <div class="text-center d-inline-block text-lg-right">
                <div class="p-3 d-inline-block" style="vertical-align: middle;">
                    <i class="fa fa-truck text-danger" style="padding: 41px;border-radius: 50%;background: white;font-size: 37px;"></i>
                </div>
                <div class="p-1 d-inline-block" style="vertical-align: middle;">
                    <p class="text-white mb-0 d-inline-block" style="font-size: 17px;max-width: 520px;vertical-align: middle;">تقدم لك نشمي خدمة الشحن بأفضل الأسعار, لتتمكن من البيع بدون ان تشغل بالك بأعباء الشحن,.</p>
                    <a href="/deliver" class="btn btn-default my-3 py-2 px-4  d-inline-block" style="background: #fff5f6;color: #444;">اشحن مع نشمي</a>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </section>

    <!--=====================================-->
    <!--=            Category Start         =-->
    <!--=====================================-->
    @if(App\Models\Category::whereNull('category_id')->count())
        <section class="section-padding-top-heading">
            <div class="container">
                <div class="heading-layout1">
                    <h2 class="heading-title">أشهر الأقسام</h2>
                </div>
                
                {{-- ad spaces --}}
                <div class="row mb-4">
                    @foreach (ads('leaderboard', 2, true) as $ad)
                        <div class="col-md-6 mb-3 text-center d-none d-md-block">{!! $ad !!}</div>
                    @endforeach
                    @foreach (ads('mobile_banner', 2, true) as $ad)
                        <div class="col-md-6 mb-3 text-center d-block d-md-none">{!! $ad !!}</div>
                    @endforeach
                    {{-- <amp-ad width="100vw" height="320"
                        type="adsense"
                        data-ad-client="ca-pub-1250310795030706"
                        data-ad-slot="1187204680"
                        data-auto-format="rspv"
                        data-full-width="">
                    <div overflow=""></div>
                    </amp-ad>
                    
                    <amp-ad width="100vw" height="320"
                        type="adsense"
                        data-ad-client="ca-pub-1250310795030706"
                        data-ad-slot="1187204680"
                        data-auto-format="rspv"
                        data-full-width="">
                    <div overflow=""></div>
                    </amp-ad> --}}
                </div>

                <div class="row">
                    @foreach(App\Models\Category::whereNull('category_id')->limit(8)->inRandomOrder()->get() as $category)
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="category-box-layout1">
                                <a href="/listings?categories[]={{ $category->id }}">
                                    <div class="item-icon">
                                        <i class="{{ $category->icon }}"></i>
                                    </div>
                                    <div class="item-content">
                                        <h3 class="item-title">{{ $category->name }}</h3>
                                        <div class="item-count">{{ $category->listings()->count() * 43 }} إعلان</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @include('main.layouts.partials.counter')

    <!--=====================================-->
    <!--=          Brnad Start              =-->
    <!--=====================================-->
    <section class="brand-wrap-layout1" dir="ltr">
        <div class="container py-5">
            <div class="rc-carousel" data-loop="true" data-items="10" data-margin="30" data-autoplay="true" data-autoplay-timeout="2000" data-smart-speed="1000" data-dots="false" data-nav="true" data-nav-speed="false" data-r-x-small="1" data-r-x-small-nav="false" data-r-x-small-dots="false" data-r-x-medium="2" data-r-x-medium-nav="false" data-r-x-medium-dots="false" data-r-small="2" data-r-small-nav="false" data-r-small-dots="false" data-r-medium="2" data-r-medium-nav="false" data-r-medium-dots="false" data-r-large="3" data-r-large-nav="false" data-r-large-dots="false" data-r-extra-large="4" data-r-extra-large-nav="false" data-r-extra-large-dots="false">
                @foreach (ads('mobile_banner', 10) as $ad)
                    {!! $ad !!}
                @endforeach
            </div>
        </div>

    </section>
@endsection

@section('modals')
    @include('main.layouts.partials.search-modals')
@endsection

@section('scripts')
    @include('main.layouts.partials.search-box-scripts')
    <script src="/assets/js/ajax/home.js?v=1.4"></script>
@endsection