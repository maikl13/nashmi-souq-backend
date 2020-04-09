@extends('main.layouts.main')

@section('title', $title)

@section('head')
    <style>
        .search-result-box-layout1 ul {
            list-style: initial;
            margin: 0;
            padding-right: 2rem;
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
                        <h1>{{ $title }}</h1>
                        <ul>
                            <li> <a href="/">الرئيسية</a> </li>
                            <li>{{ $title }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=====================================-->
    <!--=        Faq Page Start             =-->
    <!--=====================================-->
    <section class="section-padding-equal-70">
        <div class="row">
            <div class="col mb-4 text-center d-none d-md-block">{!! ad('large_leaderboard') !!}</div>
            <div class="col mb-4 text-center d-block d-md-none">{!! ad('mobile_banner') !!}</div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="search-result-box-layout1">
                        <div class="search-item-result" style="line-height: 38px;">
                            <h2 class="item-title">
                                <a href="">{{ $title }}</a>
                            </h2>
                            <p>{!! $content !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
