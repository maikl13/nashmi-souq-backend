@extends('main.layouts.main')

@section('title', 'الرئيسية')

@section('head')
    <style>
        @media (max-width: 575px){
            .home-listing { 
                max-height: 110px;
                overflow: hidden;
            }
        }
        @media (max-width: 991px){
            footer { display: none; }
            .home-listings-wrapper { max-width: 100% !important; }
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

    @include('main.layouts.partials.home-listings-wrapper')
    
    <div class="d-none d-lg-block">
        @include('main.layouts.partials.open-store-promo')
    </div>

    <div class="d-none d-lg-block">
        @include('main.layouts.partials.stores')
    </div>
    
    {{-- @include('main.layouts.partials.shipping') --}}

    <div class="d-none d-lg-block">
        @include('main.layouts.partials.categories')
    </div>

    <div class="d-none d-lg-block">
        @include('main.layouts.partials.counter')
    </div>

    <!--=====================================-->
    <!--=          Brnad Start              =-->
    <!--=====================================-->
    <div class="d-none d-lg-block">
        <section class="brand-wrap-layout1" dir="ltr">
            <div class="container py-5">
                <div class="rc-carousel" data-loop="true" data-items="10" data-margin="30" data-autoplay="true" data-autoplay-timeout="2000" data-smart-speed="1000" data-dots="false" data-nav="true" data-nav-speed="false" data-r-x-small="1" data-r-x-small-nav="false" data-r-x-small-dots="false" data-r-x-medium="2" data-r-x-medium-nav="false" data-r-x-medium-dots="false" data-r-small="2" data-r-small-nav="false" data-r-small-dots="false" data-r-medium="2" data-r-medium-nav="false" data-r-medium-dots="false" data-r-large="3" data-r-large-nav="false" data-r-large-dots="false" data-r-extra-large="4" data-r-extra-large-nav="false" data-r-extra-large-dots="false">
                    @foreach (ads('mobile_banner', 10) as $ad)
                        {!! $ad !!}
                    @endforeach
                </div>
            </div>
        </section>
    </div>
@endsection

@section('modals')
    @include('main.layouts.partials.search-modals')
@endsection

@section('scripts')
    @include('main.layouts.partials.search-box-scripts')

    <script src="/assets/js/ajax/home.js?v=1.7"></script>
@endsection