@extends('main.layouts.main')

@section('title', 'الرئيسية')

@section('content')
    <!--=====================================-->
    <!--=            Banner Start           =-->
    <!--=====================================-->
    <section class="main-banner-wrap-layout1 bg-dark-overlay bg-common minus-mgt-90" data-bg-image="/assets/images/banner/banner1.jpg">
        <div class="container">
            <div class="main-banner-box-layout1 animated-headline">
                <h1 class="ah-headline item-title" style="line-height: 60px; font-size: 2.5rem">
                    <span class="ah-words-wrapper">
                        <b class="is-visible">بيع و أشترى و أجر بضغطة زر واحدة</b>
                        <b>بيع و أشترى و أجر بضغطة زر واحدة</b>
                    </span>
                </h1>
                
                <div class="item-subtitle">إبحث في أكثر من {{ App\Models\Listing::count() }} إعلان موزعين بين أكثر من {{ App\Models\Category::count() }} قسم</div>

                @include('main.layouts.partials.search-box')
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

    <!--=====================================-->
    <!--=       Product Box Start           =-->
    <!--=====================================-->
    <section class="section-padding-top-heading bg-accent">
        <div class="container">
            <div class="heading-layout1">
                <h2 class="heading-title">Featured Ads</h2>
            </div>
            <div class="row">
                @for ($i = 0; $i < 8; $i++)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="product-box-layout1">
                            <div class="item-img">
                                <a href="single-product1.html"><img src="/assets/images/product/product2.jpg" alt="Product"></a>
                            </div>
                            <div class="item-content">
                                <h3 class="item-title"><a href="single-product1.html">New Banded Smart Watch from China</a></h3>
                                <ul class="entry-meta">
                                    <li><i class="far fa-clock"></i>3 months ago</li>
                                    <li><i class="fas fa-map-marker-alt"></i>Kansas, Emporia</li>
                                </ul>
                                <div class="item-price">
                                    <span class="currency-symbol">$</span>
                                    47
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </section>

    @include('main.layouts.partials.counter')
@endsection

@section('modals')
    @include('main.layouts.partials.search-modals')
@endsection

@section('scripts')
    @include('main.layouts.partials.search-box-scripts')
@endsection