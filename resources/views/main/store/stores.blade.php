@extends('main.layouts.main')

@section('title', 'المتاجر')

@section('head')
    <style>
        body { background-color: #f5f7fa; }
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
                        <h1>المتاجر</h1>
                        <ul>
                            <li> <a href="/">الرئيسية</a> </li>
                            <li>المتاجر</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--=====================================-->
    <!--=          Store List Start         =-->
    <!--=====================================-->
    <section class="store-wrap-layout1 bg-accent">
        <div class="container">
            <div class="row">
                <div class="col mb-5 text-center d-none d-md-block">{!! ad('large_leaderboard') !!}</div>
                <div class="col mb-5 text-center d-block d-md-none">{!! ad('mobile_banner') !!}</div>
            </div>
            <div class="row">
                @forelse($stores as $store)
                    <div class="col-xl-2 col-lg-4 col-md-6">
                        <div class="store-list-layout1">
                            <a href="{{ $store->url() }}">
                                <div class="item-logo">
                                    <img src="{{ $store->store_image(['size'=>'xxs']) }}" width="100" alt="store">
                                </div>
                                <div class="item-content">
                                    <h3 class="item-title">{{ $store->store_name() }}</h3>
                                    <div class="ad-count">{{ $store->listings()->count() }} إعلان</div>
                                </div>
                            </a>
                        </div>
                    </div>
                @empty
                    <?php $msg = 'لا يوجد متاجر حتى الآن'; ?>
                    @include('main.layouts.partials.empty')
                @endforelse

            </div>

            {{ $stores->links() }}

            <div class="row mt-5">
                @foreach (ads('large_rectangle', 4, true) as $ad)
                    <div class="col-lg-3 col-md-6 mb-3 text-center">{!! $ad !!}</div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
