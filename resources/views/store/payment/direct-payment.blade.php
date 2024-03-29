@extends('store.layouts.store')

@section('title', 'دفع مباشر')

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
                        <h1>دفع مباشر</h1>
                        <ul>
                            <li> <a href="/">الرئيسية</a> </li>
                            <li>دفع مباشر</li>
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
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-10 col-md-8 mx-auto">
                    <div class="search-result-box-layout1">
                        <div class="search-item-result" style="line-height: 38px;">
                            <h3 class="item-title pb-4" style="border-bottom: 1px solid #f0f0f0">
                                <small>دفع مباشر</small>
                            </h3>
                            
                            <div class="post-ad-box-layout1 p-4">
                                <div class="post-ad-form light-box-content">
                                    <div class="alert alert-info">
                                        قم بتحديد المبلغ.
                                    </div>
                                    <form action="/direct-payment" method="post">
                                        @csrf
                                        <div class="post-section post-information">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label class="control-label">المبلغ <small> - ب{{ currency()->name }}</small></label>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <input type="number" step="1" class="form-control" name="amount" id="amount" value="{{ old('amount') ? old('amount') : '' }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="post-section">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <button type="submit" class="submit-btn">دفع</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col mb-4 text-center d-none d-md-block">{!! ad('large_leaderboard') !!}</div>
                <div class="col mb-4 text-center d-block d-md-none">{!! ad('mobile_banner') !!}</div>
            </div>
        </div>
    </section>
@endsection
