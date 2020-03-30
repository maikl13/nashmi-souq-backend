@extends('main.layouts.main')

@section('title', 'أحدث الإعلانات')

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
                        <h1>أحدث الإعلانات</h1>
                        <ul>
                            <li> <a href="/">الرئيسية</a> </li>
                            <li>الإعلانات</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('main.layouts.partials.search-box')


        <!--=====================================-->
        <!--=          Product Start         =-->
        <!--=====================================-->
        <section class="product-inner-wrap-layout1 bg-accent">
            <div class="container">
                <div class="row">

                    @include('main.listings.partials.filters')
                    
                    <div class="col-xl-9 col-lg-8">
                        @include('main.listings.partials.listings')                        
                    </div>
                </div>
            </div>
        </section>
@endsection