@extends('main.layouts.main')

@section('title', 'نشر اعلان جديد')

@section('content')
    <section class="inner-page-banner" data-bg-image="/assets/images/banner/banner1.jpg">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumbs-area">
                        <h1>نشر اعلان جديد</h1>
                        <ul>
                            <li> <a href="/">الرئيسية</a> </li>
                            <li> <a href="/listings">الإعلانات</a> </li>
                            <li>اعلان جديد</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="section-padding-equal-70">
        <div class="container">
            <div class="row">
                <div class="col-sm-10 col-md-8 m-auto">
                    <div class="contact-page-box-layout1 light-shadow-bg py-5">
                        <div class="contact-form-box text-center py-5">
                            <h3 class="item-title">عفوا!</h3>
                            <p>لقد تخطيت الحد الأقصى لعدد الاعلانات المسموح بنشرها</p>
                            <p>
                                <span>برجاء الانتظار</span> 
                                <span class="bg-light p-2">{{ auth()->user()->remaining_time_to_be_able_to_post_listings() }}</span>
                                <span>لتتمكن من نشر إعلان جديد</span>
                            </p>
                            <div class="mt-4">
                                <a class="btn btn-success p-3" href="/listings">العودة للرئيسية <i class="fa fa-arrow-circle-left mr-4"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
