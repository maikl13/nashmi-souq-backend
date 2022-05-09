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
                        'price' => ceil(exchange(setting('monthly_subscription'), 'USD', currency()->code)),
                    ], [
                        'name' => 'نصف سنوي',
                        'price' => ceil(exchange(setting('half_year_subscription'), 'USD', currency()->code)),
                        'discount' => setting('monthly_subscription') ? round((1-((setting('half_year_subscription')/6)/setting('monthly_subscription')))*100, 1) : 0
                    ], [
                        'name' => 'سنوي',
                        'price' => ceil(exchange(setting('yearly_subscription'), 'USD', currency()->code)),
                        'discount' => setting('yearly_subscription') ? round((1-((setting('yearly_subscription')/12)/setting('monthly_subscription')))*100, 1) : 0
                    ]
                ] as $k => $subscription)
                    @if ($subscription['price'])
                        <div class="col-xl-4 col-md-4">
                            <div class="pricing-box-layout1">
                                <h3 class="item-title">{{ $subscription['name'] }}</h3>
                                <div class="price-box py-5">
                                    <span class="h1">{{ $subscription['price'] }} <small>{{ currency()->symbol }}</small></span>
                                </div>
                                <div class="item-features">
                                    <ul>
                                        @if(isset($subscription['discount']) && $subscription['discount'])
                                            <li>خصم {{ $subscription['discount'] }}%</li>
                                        @else
                                            <li><del>خصم</del></li>
                                        @endif
                                        @if (setting('trial_period'))
                                            <li>فترة تجريبية {{ setting('trial_period') > 2 ? setting('trial_period') : '' }} 
                                                {{ trans_choice('{1} يوم|{2} يومين|[3,10] أيام|[11,*] يوم', setting('trial_period')) }}
                                            </li>
                                        @endif
                                        <li>دعم فني مجاني</li>
                                    </ul>
                                </div>
                                <div class="item-btn">
                                    <a href="/stores/new?type={{ $k+1 }}" class="btn-fill-xl color-light bgPrimary">
                                        @if (setting('trial_period'))
                                            بدء الفترة التجريبية
                                        @else
                                            إشتراك
                                        @endif
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>
@endsection