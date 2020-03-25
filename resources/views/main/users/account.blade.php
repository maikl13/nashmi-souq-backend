@extends('main.layouts.main')

@section('title', 'إعدادات الحساب')

@section('content')
    <!--=====================================-->
    <!--=        Inner Banner Start         =-->
    <!--=====================================-->
    <section class="inner-page-banner" data-bg-image="media/banner/banner1.jpg">
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

    <script type="text/javascript">
        @if(Auth::user()->profile_picture)
            var profile_picture = '{{ Auth::user()->profile_picture() }}';
            var fileInputOptions = $.extend(true,{
                initialPreview: [profile_picture],
                initialPreviewConfig : [{caption: "Profile Picture"}],
                deleteUrl: "/profile-picture/delete",
            },fileInputOptions);
        @endif

        var profilePicture = $("[type=file].profile-picture").fileinput(fileInputOptions);
    </script>
@endsection