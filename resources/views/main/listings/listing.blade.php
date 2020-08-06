@extends('main.layouts.main')

@section('title', 'معاينة الإعلان | '. $listing->title)

@section('head')
    <link rel="stylesheet" type="text/css" href="/assets/plugins/fancybox-master/jquery.fancybox.min.css">
    <style>
        .cart-form button { border-radius: 0; padding: 20px; }
    </style>
@endsection

@section('content')
    <!--=====================================-->
    <!--=        Inner Banner Start         =-->
    <!--=====================================-->
    <section class="inner-page-banner" data-bg-image="/assets/images/banner/banner1.jpg">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumbs-area">
                        <h1>{{ $listing->title }}</h1>
                        <ul>
                            <li> <a href="/">الرئيسية</a> </li>
                            <li> <a href="/listings">الإعلانات</a> </li>
                            <li>معاينة الإعلان</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!--=====================================-->
    <!--=          Product Start         =-->
    <!--=====================================-->
    <section class="single-product-wrap-layout1 section-padding-equal-70 bg-accent">
        <div class="container">
            <div class="row">
                <div class="col mb-4 text-center d-none d-md-block">{!! ad('large_leaderboard') !!}</div>
                <div class="col mb-4 text-center d-block d-md-none">{!! ad('mobile_banner') !!}</div>
            </div>
            <div class="row">
                <div class="col-xl-9 col-lg-8">
                    <div class="single-product-box-layout1">
                        <div class="product-info light-shadow-bg">
                            <div class="product-content light-box-content">

                                @include('main.listings.partials.listing-images')

                                <div class="single-entry-meta">
                                    <ul>
                                        <li>
                                            <i class="far fa-clock"></i>
                                            {{ $listing->created_at->diffForHumans() }}
                                        </li>
                                        <li>
                                            <i class="fas fa-map-marker-alt"></i>
                                            @if($listing->state)
                                                <a href="{{ $listing->state->url() }}">{{ $listing->state->name }}</a>
                                            @endif
                                            @if($listing->area)
                                                <a href="{{ $listing->area->url() }}">{{ ', '.$listing->area->name }}</a>
                                            @endif
                                        </li>
                                        <li>
                                            <i class="fas fa-tags"></i>
                                            @if($listing->category)
                                                <a href="{{ $listing->category->url() }}">{{ $listing->category->name }}</a>
                                            @endif
                                        </li>
                                        <li><i class="far fa-eye"></i>{{ $listing->views }} مشاهدة</li>
                                    </ul>
                                </div>
                                <div class="item-details">
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="details" role="tabpanel">
                                            <p>{{ $listing->description }}</p>
                                        </div>
                                        @if(!empty(trim($listing->address)))
                                            <div class="mt-3 mb-4"> <strong>العنوان تفصيلي:</strong> {{ $listing->address }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col text-center d-none d-md-block">{!! ad('leaderboard') !!}</div>
                                    <div class="col text-center d-block d-md-none">{!! ad('mobile_banner') !!}</div>
                                </div>

                                <div class="item-action-area">
                                    <ul>
                                        <li class="item-social">
                                            <span class="share-title">
                                                <i class="fas fa-share-alt"></i> مشاركة:
                                            </span>
                                            <a href="#" class="bg-facebook open-share"><i class="fa fa-share-alt"></i></a>
                                            <?php $url = config('app.url').$listing->url() ?>
                                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($url) }}" class="bg-facebook"><i class="fab fa-facebook-f"></i></a>
                                            <a href="https://twitter.com/intent/tweet?url={{ urlencode($url) }}" class="bg-twitter"><i class="fab fa-twitter"></i></a>
                                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode($url) }}&source=LinkedIn" class="bg-linkedin"><i class="fab fa-linkedin-in"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        @include('main.listings.partials.related-listings')
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 sidebar-break-md sidebar-widget-area">
                    @if ($listing->price !== null)
                        <div class="widget-lg widget-price mb-3">
                            <div class="item-price">
                                {{ $listing->local_price() }}
                                <small><span class="currency-symbol" title="ب{{ country()->currency->name }}">{{ country()->currency->symbol }}</span></small>
                            </div>
                        </div>
                    @endif
                    @if ($listing->is_eligible_for_cart())
                        <div class="widget-lg widget-price widget-light-bg">
                            <form method="post" class="cart-form">
                                <input type="hidden" value="1" class="quantity" name="demo_vertical2"/>
                                <input type="hidden" value="{{ $listing->id }}" class="product-id">
                                <button class="btn btn-info btn-block text-right" type="submit">
                                    <i class="fa fa-cart-plus"></i> إضافة لعربة التسوق
                                </button>
                            </form>
                        </div>
                    @endif

                    @include('main.listings.partials.publisher-details')
                    
                    <div class="widget-lg widget-safty-tip widget-light-bg">
                        <h3 class="widget-border-title">لعملية شراء آمنة</h3>
                        <div class="safty-tip-content">
                            <ul>
                                <li>إلتقي بالبائع في مكان عام</li>
                                <li>إفحص المنتج جيدا قبل الشراء</li>
                                <li>قم بالدفع فقط بعد الاستلام</li>
                            </ul>
                        </div>
                    </div>
                    <div class="widget widget-banner">
                        <div class="row">
                            <div class="col text-center d-none d-md-block">{!! ad('large_rectangle') !!}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <!-- Fancybox -->
    <script src="/assets/plugins/fancybox-master/jquery.fancybox.min.js"></script>
    <script>
        $('[data-fancybox]').fancybox();
    </script>
    <script>
        $(document).ready(function(){
            if (!navigator.share) {
                $('.open-share').hide();
            }
            $('.open-share').on('click', function(e){
                e.preventDefault();
                if (navigator.share) {
                    navigator.share({
                        title: document.title,
                        text: "سوق نشمي",
                        url: window.location.href
                    }).then(() => console.log('Successful share'))
                    .catch(error => console.log('Error sharing:', error));
                }
            });
        });
    </script>
@endsection