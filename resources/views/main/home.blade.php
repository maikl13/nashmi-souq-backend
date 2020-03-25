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
                <div class="item-subtitle">Search from over 2000+ Active Ads in 29+ Categories for Free</div>
                <div class="search-box-layout1">
                    <form action="#">
                        <div class="row no-gutters">
                            <div class="col-lg-3 form-group">
                                <div class="input-search-btn search-location" data-toggle="modal" data-target="#modal-location">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <label>اختر الموقع</label>
                                </div>
                            </div>
                            <div class="col-lg-3 form-group">
                                <div class="input-search-btn search-category" data-toggle="modal" data-target="#modal-category">
                                    <i class="fas fa-tags"></i>
                                    <label>اختر التصنيف</label>
                                </div>
                            </div>
                            <div class="col-lg-4 form-group">
                                <div class="input-search-btn search-keyword">
                                    <i class="fas fa-text-width"></i>
                                    <input type="text" class="form-control" placeholder="أدخل كلمة للبحث ..." name="keyword">
                                </div>
                            </div>
                            <div class="col-lg-2 form-group">
                                <button type="submit" class="submit-btn"><i class="fas fa-search"></i>بحث</button>
                            </div>
                        </div>
                    </form>
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
                    <h2 class="heading-title">أشهر الاأقسام</h2>
                </div>
                <div class="row">
                    @foreach(App\Models\Category::limit(8)->inRandomOrder()->get() as $category)
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="category-box-layout1">
                                <a href="#">
                                    <div class="item-icon">
                                        <i class="far fa-building"></i>
                                    </div>
                                    <div class="item-content">
                                        <h3 class="item-title">{{ $category->name }}</h3>
                                        <div class="item-count">1 Ad</div>
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

    <!--=====================================-->
    <!--=       Counter Start               =-->
    <!--=====================================-->
    <section class="counter-wrap-layout1 bg-attachment-fixed" data-bg-image="/assets/images/figure/counter-bg.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 d-flex justify-content-center">
                    <div class="counter-box-layout1">
                        <div class="item-icon">
                            <i class="flaticon-gift"></i>
                        </div>
                        <div class="item-content">
                            <div class="counter-number">
                                <span class="counter">5000</span>
                                <span>+</span>
                            </div>
                            <div class="item-title">اعلان</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 d-flex justify-content-center">
                    <div class="counter-box-layout1">
                        <div class="item-icon">
                            <i class="flaticon-shield"></i>
                        </div>
                        <div class="item-content">
                            <div class="counter-number">
                                <span class="counter">3265</span>
                                <span>+</span>
                            </div>
                            <div class="item-title">متجر موثق</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 d-flex justify-content-center">
                    <div class="counter-box-layout1">
                        <div class="item-icon">
                            <i class="flaticon-users"></i>
                        </div>
                        <div class="item-content">
                            <div class="counter-number">
                                <span class="counter">2000</span>
                                <span>+</span>
                            </div>
                            <div class="item-title">مستخدم</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('modals')
    <!--=====================================-->
    <!--=       Modal Start                 =-->
    <!--=====================================-->
    <div class="modal fade modal-location" id="modal-location" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close modal-close" data-dismiss="modal" aria-label="Close">
                    <span class="fas fa-times" aria-hidden="true"></span>
                </button>
                <div class="location-list">
                    <h4 class="item-title">Location</h4>
                    <ul>
                        <li><a href="#">California</a></li>
                        <li><a href="#">Kansas</a></li>
                        <li><a href="#">Louisiana</a></li>
                        <li><a href="#">New Jersey</a></li>
                        <li><a href="#">New York</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modal-location" id="modal-category" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close modal-close" data-dismiss="modal" aria-label="Close">
                    <span class="fas fa-times" aria-hidden="true"></span>
                </button>
                <div class="location-list">
                    <h4 class="item-title">Category</h4>
                    <ul>
                        <li>
                            <a href="#"><span class="item-icon"><img src="/assets/images/category/category5.png" alt="icon"></span>Business &amp; Industry</a>
                        </li>
                        <li>
                            <a href="#"><span class="item-icon"><img src="/assets/images/category/category7.png" alt="icon"></span>Cars &amp; Vehicles</a>
                        </li>
                        <li>
                            <a href="#"><span class="item-icon"><img src="/assets/images/category/category14.png" alt="icon"></span>Electronics</a>
                        </li>
                        <li>
                            <a href="#"><span class="item-icon"><img src="/assets/images/category/category4.png" alt="icon"></span>Health &amp; Beauty</a>
                        </li>
                        <li>
                            <a href="#"><span class="item-icon"><img src="/assets/images/category/category18.png" alt="icon"></span>Hobby, Sport &amp; Kids</a>
                        </li>
                        <li>
                            <a href="#"><span class="item-icon"><img src="/assets/images/category/category8.png" alt="icon"></span>Home Appliances</a>
                        </li>
                        <li>
                            <a href="#"><span class="item-icon"><img src="/assets/images/category/category6.png" alt="icon"></span>Jobs</a>
                        </li>
                        <li>
                            <a href="#"><span class="item-icon"><img src="/assets/images/category/category12.png" alt="icon"></span>Others</a>
                        </li>
                        <li>
                            <a href="#"><span class="item-icon"><img src="/assets/images/category/category11.png" alt="icon"></span>Pets &amp; Animals</a>
                        </li>
                        <li>
                            <a href="#"><span class="item-icon"><img src="/assets/images/category/category3.png" alt="icon"></span>Property</a>
                        </li>
                        <li>
                            <a href="#"><span class="item-icon"><img src="/assets/images/category/category1.png" alt="icon"></span>Services</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection