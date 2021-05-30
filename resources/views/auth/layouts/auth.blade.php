@extends('main.layouts.main')

@section('head')
    @yield('page-head')
@endsection

@section('content')
    @section('hero-area')
        <section class="inner-page-banner" data-bg-image="/assets/images/banner/banner1.jpg">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="breadcrumbs-area">
                            <h1>@yield('title')</h1>
                            <ul>
                                <li> <a href="{{ Url('/') }}">الرئيسية</a> </li>
                                <li>@yield('title')</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @show

    <section class="section-padding-equal-70">
        <div class="container">
            <div class="row">
                <div class="col-sm-10 col-md-8 m-auto">
                    <div class="contact-page-box-layout1 light-shadow-bg">
                        <div class="light-box-register">
                            <div class="contact-form-box">
                                <h3 class="item-title">
                                    @section('card-title')
                                        @yield('title')
                                    @show
                                </h3>
                                <div>

                                	@yield('page-content')

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    @yield('page-scripts')
@endsection