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
            <div class="d-flex flex-wrap" style="gap: 12px;">
                @forelse($stores as $store)
                    <div class="ms-2 me-4" style="max-width: 100%; width: 110px; flex-grow: 1;">
                        <div class="store-list-layout1 mb-0">
                            <a href="{{ $store->store_url() }}">
                                <div class="item-logo bg-light">
                                    <img src="{{ $store->store_image(['size'=>'xs']) }}" style="width: 100%; height: 100px; object-fit: contain;" alt="store">
                                </div>
                                <div class="item-content" dir="auto" style="white-space: nowrap; text-overflow: ellipsis; overflow: hidden;">
                                    <h2 class="item-title d-inline font-weight-normal">{{ $store->store_name() }}</h2>
                                    <div class="ad-count">{{ $store->products()->count() }} منتج</div>
                                </div>
                            </a>
                        </div>
                    </div>
                @empty
                    <?php $msg = '-'; ?>
                    @include('main.layouts.partials.empty')
                @endforelse
            </div>

            {{ $stores->links() }}

            <div class="row mt-5">
                <div class="col text-center d-none d-md-block">{!! ad('large_leaderboard') !!}</div>
                <div class="col text-center d-block d-md-none">{!! ad('mobile_banner') !!}</div>
            </div>
        </div>
    </section>

    @include('main.layouts.partials.open-store-promo')
@endsection
