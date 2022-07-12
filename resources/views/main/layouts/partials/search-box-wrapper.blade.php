<div class="search-box-wrapper {{ request()->routeIs('home') ? 'd-lg-block' : 'd-lg-none' }} w-100" style="display: none; z-index: 20; height: 100%; background: rgba(0,0,0,0.3);">
    <section class="main-banner-wrap-layout1 bg-dark-overlay bg-common py-3 py-lg-5" 
        data-bg-image="/assets/images/banner/banner1.jpg">
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
                {{-- <div class="container" dir="ltr">
                    <div class="rc-carousel" data-loop="true" data-items="10" data-margin="30" data-autoplay="true" data-autoplay-timeout="2000" data-smart-speed="500" data-dots="false" data-nav="true" data-nav-speed="false" data-r-x-small="1" data-r-x-small-nav="false" data-r-x-small-dots="false" data-r-x-medium="1" data-r-x-medium-nav="false" data-r-x-medium-dots="false" data-r-small="1" data-r-small-nav="false" data-r-small-dots="false" data-r-medium="2" data-r-medium-nav="false" data-r-medium-dots="false" data-r-large="1" data-r-large-nav="false" data-r-large-dots="false" data-r-extra-large="1" data-r-extra-large-nav="false" data-r-extra-large-dots="false">
                        @foreach (ads('large_leaderboard', 7) as $ad)
                            <span class="d-block mt-3">{!! $ad !!}</span>
                        @endforeach
                    </div>
                </div> --}}
            </div>
        </div>
    </section>
</div>
