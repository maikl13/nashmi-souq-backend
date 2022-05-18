@extends('main.layouts.main')

@section('title', 'الرئيسية')

@section('head')
    <style>
        @media (max-width: 991px){
            footer { display: none; }
            .home-listings-wrapper { max-width: 100% !important; }
        }
    </style>
@endsection

@section('content')
    @include('main.layouts.partials.home-fixed-listings')

    @include('main.layouts.partials.home-listings-wrapper')
    
    <div class="d-none d-lg-block">
        @include('main.layouts.partials.open-store-promo')
    </div>

    <div class="d-none d-lg-block">
        @include('main.layouts.partials.stores')
    </div>
    
    {{-- @include('main.layouts.partials.shipping') --}}

    <div class="d-none d-lg-block">
        @include('main.layouts.partials.categories')
    </div>

    <div class="d-none d-lg-block">
        @include('main.layouts.partials.counter')
    </div>

    <!--=====================================-->
    <!--=          Brnad Start              =-->
    <!--=====================================-->
    <div class="d-none d-lg-block">
        <section class="brand-wrap-layout1" dir="ltr">
            <div class="container py-5">
                <div class="rc-carousel" data-loop="true" data-items="10" data-margin="30" data-autoplay="true" data-autoplay-timeout="2000" data-smart-speed="1000" data-dots="false" data-nav="true" data-nav-speed="false" data-r-x-small="1" data-r-x-small-nav="false" data-r-x-small-dots="false" data-r-x-medium="2" data-r-x-medium-nav="false" data-r-x-medium-dots="false" data-r-small="2" data-r-small-nav="false" data-r-small-dots="false" data-r-medium="2" data-r-medium-nav="false" data-r-medium-dots="false" data-r-large="3" data-r-large-nav="false" data-r-large-dots="false" data-r-extra-large="4" data-r-extra-large-nav="false" data-r-extra-large-dots="false">
                    @foreach (ads('mobile_banner', 10) as $ad)
                        {!! $ad !!}
                    @endforeach
                </div>
            </div>
        </section>
    </div>
@endsection

@section('scripts')
    <script src="/assets/js/ajax/home.js?v=1.7"></script>
@endsection