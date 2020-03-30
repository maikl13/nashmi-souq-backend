@extends('main.layouts.main')

@section('title', $user->store_name())

@section('head')
    <style>
        body { background-color: #f5f7fa; }
        .store-banner-box {
            background-image: url({{ $user->store_banner()  }});
        }
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
                        <h1>{{ $user->store_name() }}</h1>
                        <ul>
                            <li> <a href="/">الرئيسية</a> </li>
                            <li> <a href="/">المتاجر</a> </li>
                            <li>{{ $user->store_name() }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=====================================-->
    <!--=          Store Banner Start       =-->
    <!--=====================================-->
    <section class="store-banner-wrap-layout1">
        <div class="container">
            <div class="store-banner-box">
                <div class="banner-content">
                    <div class="store-logo">
                        <img src="{{ $user->store_image() }}" alt="{{ $user->store_name() }}" width="140">
                    </div>
                    <div class="store-content">
                        <h2 class="item-title">{{ $user->store_name() }}</h2>
                        <div class="store-tagline">{{ $user->store_slogan }}</div>
                        <ul class="item-meta">
                            <li><i class="fas fa-map-marker-alt"></i>{{ $user->store_address }}</li>
                            <li><i class="fas fa-user"></i>عضو {{ $user->created_at->diffForHumans() }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=====================================-->
    <!--=          Product Start         =-->
    <!--=====================================-->
    <section class="store-wrap-layout2">
        <div class="container">
            <div class="row">
                <div class="col-xl-9 col-lg-8">
                    <?php $listings = $user->listings()->latest()->paginate(9); ?>
                    @include('main.listings.partials.listings')
                </div>
                <div class="col-xl-3 col-lg-4 sidebar-break-md sidebar-widget-area">
                    @if($user->store_description)
                        <div class="widget-lg widget-store-detail widget-light-bg">
                            <h3 class="widget-border-title">عن المتجر</h3>
                            <div class="store-content">
                                <p>{{ $user->store_description }}</p>
                            </div>
                        </div>
                    @endif
                    <div class="widget-lg widget-author-info widget-store-info widget-light-bg">
                        <h3 class="widget-border-title">معلومات الإتصال</h3>
                        <div class="author-content">
                            @if($user->store_website)
                                <div class="store-website">
                                    <a href="{{ $user->store_website }}"><i class="fas fa-globe-asia"></i>الموقع الإلكتروني للمتجر</a>
                                </div>
                            @endif
                            @if($user->phone)
                                <div class="phone-number classima-phone-reveal not-revealed" data-phone="{{ Auth::check() ? $user->phone : 'قم بتسجيل الدخول' }}">
                                    <div class="number"><i class="fas fa-phone"></i><span>{{ Str::limit($user->phone, 4, 'XXXXXX') }}</span></div>
                                    <div class="item-text">إضغط هنا لإظهار رقم التلفون</div>
                                </div>
                            @endif

                            <div class="author-mail">
                                <a href="#" class="mail-btn" data-toggle="modal" data-target="#author-mail">
                                    <i class="fas fa-envelope"></i> التحدث مع {{ $user->store_name ? 'ادارة المتجر' : 'المستخدم' }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
