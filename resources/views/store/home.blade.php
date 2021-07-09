@extends('store.layouts.store')

@section('title', 'الرئيسية')

@section('head')
    <style>
        @media (max-width: 575px){
            .home-listing { 
                margin: 0;
            }
            .home-listing .item-img {
                padding: 1rem 10px 0 0;
                min-width: 110px;
            }
            .product-box-layout1 .item-img img {
                width: auto;
                height: auto;
            }
            .home-listing .item-content {
                min-width: 218px;
            }
        }
        @media (max-width: 350px){
            .home-listing {
                display: block;
            }
            .home-listing .item-img {
                width: 100%;
                padding: 0;
            }
        }
    </style>
@endsection

@section('content')
    <!--=====================================-->
    <!--=            Banner Start           =-->
    <!--=====================================-->
    
    @if (request()->store->promotions()->count())
        @include('store.layouts.partials.promotions')
    @else
        <section class="main-banner-wrap-layout1 bg-dark-overlay bg-common {{-- minus-mgt-90 --}}" data-bg-image="{{ request()->store->store_banner() }}" style="padding: 8rem 0 7rem;">
            <div class="container">
                <div class="main-banner-box-layout1 animated-headline-">
                    <h1 class="ah-headline- item-title" style="line-height: 60px; font-size: 2.5rem">
                        <span class="ah-words-wrapper-">
                            {{-- <b class="is-visible">{{ request()->store->store_slogan }}</b> --}}
                            <b>{{ request()->store->store_slogan }}</b>
                        </span>
                    </h1>
                    
                    {{-- <div class="item-subtitle">{{ request()->store->store_slogan }}</div> --}}

                    @include('store.layouts.partials.search-box')
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
                <h2 class="heading-title">أحدث المنتجات</h2>
            </div>

            <div class="row">
                @if (request()->store->products()->shown()->count())
                    @foreach (request()->store->products()->latest()->shown()->limit(16)->get() as $product)
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                            <div class="product-box-layout1 home-listing">
                                <div class="item-img">
                                    <a href="{{ $product->url() }}"><img src="{{ $product->product_image(['size'=>'xs']) }}" class="w-100" alt="Product"></a>
                                </div>
                                <div class="item-content p-3">
                                    <h3 class="item-title mb-2">
                                        <a href="{{ $product->url() }}" class="text-right font-weight-normal">{{ $product->title }}</a>
                                    </h3>
                                    <ul class="entry-meta">
                                        {{-- <li class="d-none d-sm-block"><i class="far fa-clock"></i>{{ $product->created_at->diffForHumans() }}</li> --}}
                                        {{-- <li class="d-inline"><i class="fas fa-tags"></i>{{ $product->category ? $product->category->name : '' }}</li> --}}
                                        @if ($product->price)
                                            <li class="d-inline" style="font-size: 18px; color: #555;">
                                                {{-- <i class="fas fa-money-bill"></i> --}}
                                                <span>{{ $product->local_price() }}</span>
                                                <span class="currency-symbol" title="ب{{ country()->currency->name }}">{{ country()->currency->symbol }}</span>
                                                
                                                @if($product->price < $product->initial_price)
                                                    <del class="small mr-2" style="color: #aaa;">
                                                        {{ $product->local_initial_price() }}
                                                        <span class="currency-symbol">{{ country()->currency->symbol }}</span>
                                                    </del>
                                                @endif
                                            </li>
                                        @endif
                                    </ul>
                                    
                                    <form method="post" class="cart-form mt-3">
                                        <input type="hidden" value="1" class="quantity" name="demo_vertical2"/>
                                        <input type="hidden" value="{{ $product->id }}" class="product-id">
                                        <button class="btn btn-info btn-block text-center py-2" type="submit">
                                            <i class="fa fa-cart-plus ml-1"></i> إضافة لعربة التسوق
                                        </button>
                                    </form>
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
