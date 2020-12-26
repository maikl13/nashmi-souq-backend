@extends('main.layouts.main')

@section('title', 'الاشتراكات')

@section('head')
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
                        <h1>أسعار الاشتراك ف المتجر</h1>
                        <ul>
                            <li> <a href="/">الرئيسية</a> </li>
                            <li>أسعار الاشتراك ف المتجر</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section-padding-top-heading">
        <div class="container">
            <div class="row">
                @foreach ([
                    [
                        'name' => 'شهري',
                        'price' => setting('monthly_subscription'),
                    ], [
                        'name' => 'نصف سنوي',
                        'price' => setting('half_year_subscription'),
                        'discount' => setting('monthly_subscription') ? round((1-((setting('half_year_subscription')/6)/setting('monthly_subscription')))*100, 1) : 0
                    ], [
                        'name' => 'سنوي',
                        'price' => setting('yearly_subscription'),
                        'discount' => setting('yearly_subscription') ? round((1-((setting('yearly_subscription')/12)/setting('monthly_subscription')))*100, 1) : 0
                    ]
                ] as $subscription)
                    @if ($subscription['price'])
                        <div class="col-xl-4 col-md-4">
                            <div class="pricing-box-layout1">
                                <h3 class="item-title">{{ $subscription['name'] }}</h3>
                                <div class="price-box">
                                    <span class="item-currency">${{ $subscription['price'] }}</span>
                                </div>
                                <div class="item-features">
                                    <ul>
                                        @if(isset($subscription['discount']) && $subscription['discount'])
                                            <li>خصم {{ $subscription['discount'] }}%</li>
                                        @else
                                            <li><del>خصم</del></li>
                                        @endif
                                        <li>فترة تجريبية 15 يوم</li>
                                        <li>دعم فني مجاني</li>
                                    </ul>
                                </div>
                                <div class="item-btn">
                                    <a href="/stores/new" class="btn-fill-xl color-light bgPrimary">بدء الفترة التجريبية</a>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>
@endsection