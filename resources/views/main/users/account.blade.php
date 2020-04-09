@extends('main.layouts.main')

@section('title', 'إعدادات الحساب')

@section('content')
    <!--=====================================-->
    <!--=        Inner Banner Start         =-->
    <!--=====================================-->
    <section class="inner-page-banner" data-bg-image="/assets/images/banner/banner1.jpg">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumbs-area">
                        <h1>بيانات الحساب</h1>
                        <ul>
                            <li> <a href="/">الرئيسية</a> </li>
                            <li>بيانات الحساب</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--=====================================-->
    <!--=        Account Page Start         =-->
    <!--=====================================-->
    <section class="section-padding-equal-70">
        <div class="row">
            <div class="col mb-4 text-center d-none d-md-block">{!! ad('large_leaderboard') !!}</div>
            <div class="col mb-4 text-center d-block d-md-none">{!! ad('mobile_banner') !!}</div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3 sidebar-break-sm sidebar-widget-area mt-0">
                    <div class="widget-bottom-margin widget-account-menu widget-light-bg">
                        <h3 class="widget-border-title">القائمة</h3>
                        <ul class="nav nav-tabs flex-column" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#dashboard" role="tab" aria-selected="true">نظرة عامة على الحساب</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#account-detail" role="tab" aria-selected="false">تعديل بيانات الحساب</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#change-password" role="tab" aria-selected="false">تغيير كلمة المرور</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#my-listing" role="tab" aria-selected="false">إعلاناتي</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#store" role="tab" aria-selected="false">المتجر الخاص</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#payment" role="tab" aria-selected="false">المعاملات المالية</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="tab-content">

                        @include('main.users.partials.dashboard')

                        @include('main.users.partials.account-details')

                        @include('main.users.partials.change-password')
                        
                        @include('main.users.partials.listings')

                        @include('main.users.partials.store-details')

                        @include('main.users.partials.transactions')
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="/assets/js/ajax/ajax.js"></script>

    <script type="text/javascript">
        var profile_picture_fileInputOptions = fileInputOptions,
            store_banner_fileInputOptions = fileInputOptions,
            store_logo_fileInputOptions = fileInputOptions;

        @if(Auth::user()->profile_picture)
            var profile_picture = '{{ Auth::user()->profile_picture() }}';
            profile_picture_fileInputOptions = $.extend(true,{
                initialPreview: [profile_picture],
                initialPreviewConfig : [{caption: "Profile Picture"}],
                deleteUrl: "/profile-picture/delete",
            },fileInputOptions);
        @endif
        @if(Auth::user()->store_banner)
            var store_banner = '{{ Auth::user()->store_banner() }}';
            store_banner_fileInputOptions = $.extend(true,{
                initialPreview: [store_banner],
                initialPreviewConfig : [{caption: "Store Banner"}],
                deleteUrl: "/store-banner/delete",
            },fileInputOptions);
        @endif
        @if(Auth::user()->store_logo)
            var store_logo = '{{ Auth::user()->store_logo() }}';
            store_logo_fileInputOptions = $.extend(true,{
                initialPreview: [store_logo],
                initialPreviewConfig : [{caption: "Store Logo"}],
                deleteUrl: "/store-logo/delete",
            },fileInputOptions);
        @endif

        $("[type=file].profile-picture").fileinput(profile_picture_fileInputOptions);
        $("[type=file].store-banner").fileinput(store_banner_fileInputOptions);
        $("[type=file].store-logo").fileinput(store_logo_fileInputOptions);
    </script>
@endsection