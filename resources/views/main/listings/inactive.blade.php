@extends('main.layouts.main')

@section('title', "الإعلان غير متوفر حاليا")

@section('content')
    <section class="section-padding-equal-70">
        <div class="container">
            <div class="row">
                <div class="col-sm-10 col-md-8 m-auto">
                    <div class="contact-page-box-layout1 light-shadow-bg">
                        <div class="light-box-register">
                            <div class="contact-form-box text-center py-5">
                                <h3 class="item-title">عفوا!</h3>
                                <div>

                                    <span>يبدوا أن الإعلان الذي تحاول الوصول إليه غير متوفر في الوقت الحالي.</span>

                                </div>
                                <div class="mt-4">
                                    <a class="btn btn-success p-3" href="/listings">الإنتقال لصفحة الإعلانات <i class="fa fa-arrow-circle-left mr-4"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
