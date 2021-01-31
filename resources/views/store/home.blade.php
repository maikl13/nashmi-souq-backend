@extends('store.layouts.store')

@section('title', 'الرئيسية')

@section('head')
    <style>
        @media (max-width: 575px){
            .home-listing { max-height: 110px; }
        }
    </style>
@endsection

@section('content')
    <!--=====================================-->
    <!--=            Banner Start           =-->
    <!--=====================================-->
    <section class="main-banner-wrap-layout1 bg-dark-overlay bg-common {{-- minus-mgt-90 --}}" data-bg-image="{{ request()->store->store_banner() }}" style="padding: 8rem 0 7rem;">
        <div class="container">
            <div class="main-banner-box-layout1 animated-headline">
                <h1 class="ah-headline item-title" style="line-height: 60px; font-size: 2.5rem">
                    <span class="ah-words-wrapper">
                        <b class="is-visible">{{ request()->store->store_slogan }}</b>
                        <b>{{ request()->store->store_slogan }}</b>
                    </span>
                </h1>
                
                {{-- <div class="item-subtitle">{{ request()->store->store_slogan }}</div> --}}

                @include('store.layouts.partials.search-box')
            </div>
        </div>
    </section>

    <!--=====================================-->
    <!--=       Product Box Start           =-->
    <!--=====================================-->
    <section class="section-padding-top-heading bg-accent">
        <div class="container">
            <div class="heading-layout1">
                <h2 class="heading-title">أحدث المنتجات</h2>
            </div>

            <div class="row">
                @if (request()->store->products()->count())
                    @foreach (request()->store->products()->limit(16)->get() as $product)
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                            <div class="product-box-layout1 home-listing">
                                <div class="item-img">
                                    <a href="{{ $product->url() }}"><img src="{{ $product->product_image(['size'=>'xs']) }}" alt="Product"></a>
                                </div>
                                <div class="item-content">
                                    <h3 class="item-title"><a href="{{ $product->url() }}" class="text-right">{{ $product->title }}</a></h3>
                                    <ul class="entry-meta">
                                        <li class="d-none d-sm-block"><i class="far fa-clock"></i>{{ $product->created_at->diffForHumans() }}</li>
                                        <li class="d-inline"><i class="fas fa-tags"></i>{{ $product->category ? $product->category->name : '' }}</li>
                                        @if ($product->price)
                                            <li class="d-inline mr-2">
                                                <i class="fas fa-money-bill"></i>
                                                {{ $product->local_price() }} 
                                                <span class="currency-symbol" title="ب{{ country()->currency->name }}">{{ country()->currency->symbol }}</span>
                                                
                                                @if($product->price < $product->initial_price)
                                                    <del>
                                                        {{ $product->local_initial_price() }}
                                                        <span class="currency-symbol">{{ country()->currency->symbol }}</span>
                                                    </del>
                                                @endif
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="col-sm-12 text-center">
                        <a href="/products" class="btn btn-default btn-block mb-3 py-3 px-5" style="background: #e65c70;color: white;">
                            المزيد من المنتجات
                        </a>
                    </div>

                @else
                    @php($msg = 'لم يتم اضافة اي منتجات حتى الآن')
                    @include('store.layouts.partials.empty')
                @endif
            </div>
        </div>
    </section>

@endsection

@section('modals')
    @include('store.layouts.partials.search-modals')
@endsection
