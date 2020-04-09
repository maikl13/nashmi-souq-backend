@extends('main.layouts.main')

@section('title', 'إتصل بنا')

@section('content')
    <!--=====================================-->
    <!--=        Inner Banner Start         =-->
    <!--=====================================-->
    <section class="inner-page-banner" data-bg-image="/assets/images/banner/banner1.jpg">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumbs-area">
                        <h1>إتصل بنا</h1>
                        <ul>
                            <li> <a href="/">الرئيسية</a> </li>
                            <li>إتصل بنا</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--=====================================-->
    <!--=        Contact Page Start         =-->
    <!--=====================================-->
    <section class="section-padding-equal-70">
        <div class="row">
            <div class="col mb-4 text-center d-none d-md-block">{!! ad('large_leaderboard') !!}</div>
            <div class="col mb-4 text-center d-block d-md-none">{!! ad('mobile_banner') !!}</div>
        </div>
        <div class="container">
            <div class="contact-page-box-layout1 light-shadow-bg">
                <div class="light-box-content">
                    <iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?q={{ setting('latitude') }},{{ setting('longitude') }}&z=15&output=embed" aria-label="" style="border:0; width:100%; min-height:350px; height: 100%;"></iframe>
                    <div class="clearfix"></div>
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="contact-info">
                                <h3 class="item-title">معلومات</h3>
                                <ul>
                                    @if( setting('address') )
                                        <li><i class="fas fa-paper-plane"></i>{{ setting('address') }}</li>
                                    @endif
                                    @if( setting('phone') )
                                        <li><i class="fas fa-phone-volume"></i><span dir="ltr">{{ setting('phone') }}</span></li>
                                    @endif
                                    @if( setting('phone2') )
                                        <li><i class="fas fa-phone-volume"></i><span dir="ltr">{{ setting('phone2') }}</span></li>
                                    @endif
                                    @if( setting('email') )
                                        <li><i class="far fa-envelope"></i>{{ setting('email') }}</li>
                                    @endif
                                    @if( setting('fax') )
                                        <li><i class="fas fa-fax"></i>{{ setting('fax') }}</li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="contact-form-box">
                                <h3 class="item-title">إتصل بنا</h3>
                                <form id="contact-form" method="POST" action="/contact-us">
                                    @csrf
                                    <div class="form-group">
                                        <input type="text" placeholder="الاسم *" class="form-control" name="name" data-error="حقل الاسم مطلوب" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group">
                                        <input type="email" placeholder="البريد الإلكتروني *" class="form-control" name="email" data-error="حقل البريد الالكتروني مطلوب" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group">
                                        <input type="tel" placeholder="رقم الهاتف *" class="form-control" name="phone" data-error="حقل الهاتف مطلوب" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" placeholder="عنوان الرسالة *" class="form-control" name="subject" data-error="حقل العنوان مطلوب" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group">
                                        <textarea placeholder="الرسالة *" class="textarea form-control" name="message" id="form-message" rows="8" cols="20" data-error="حقل الرسالة مطلوب" required></textarea>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="submit-btn">إرسال</button>
                                    </div>
                                    <div class="form-response"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
