@extends('main.layouts.main')

@section('title', 'الشحن عن طريق نشمي')

@section('head')
@endsection

@section('content')

<section class="section-padding-equal-70">
    <div class="container">
        <div class="row">
            <div class="col-sm-10 col-md-8 m-auto">
                <div class="contact-page-box-layout1 light-shadow-bg">
                    <div class="light-box-register">
                        <div class="contact-form-box">
                            <h3 class="item-title py-3" style="font-size: 25px;">
                                طلب شحن عن طريق نشمي
                            </h3>
                            <div>
                                <form method="POST" action="/deliver">
                                    @csrf
                                    <div class="form-group row">
                                        <div class="col">
                                            <div class="alert alert-info">
                                                <div class="media">
                                                    <div class="media-head pl-3 pt-2">
                                                        <i class="fa fa-info-circle" style="font-size: 30px; opacity: .6;"></i>
                                                    </div>
                                                    <div class="media-body py-2">
                                                        قم بملأ بيانات الطلب و تأكد من كتابة البيانات بشكل صحيح و سيتم التواصل معك في اقرب وقت
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="seller_phone" class="col-md-3 col-form-label text-md-right" title="">رقم هاتفك</label>
                                        <div class="col-md-9">
                                        <input id="seller_phone" type="tel" class="form-control " name="seller_phone" placeholder="رقم هاتفك لتتمكن شركة الشحن من التواصل معك" required="" autocomplete="seller_phone" value="{{ old('seller_phone') ?? auth()->user()->phone }}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="seller_address" class="col-md-3 col-form-label text-md-right" title="العنوان الذي ستقوم شركة الشحن باستلام الشحنة منه">عنوان الاستلام</label>
                                        <div class="col-md-9">
                                            <input id="seller_address" type="text" class="form-control " name="seller_address" placeholder="العنوان الذي ستقوم شركة الشحن باستلام الشحنة منه" required="" autocomplete="seller_address" value="{{ old('seller_address') ?? '' }}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="buyer_name" class="col-md-3 col-form-label text-md-right" title="">اسم العميل</label>
                                        <div class="col-md-9">
                                        <input id="buyer_name" type="text" class="form-control " name="buyer_name" placeholder="اسم العميل" required="" value="{{ old('buyer_name') ?? '' }}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="buyer_phone" class="col-md-3 col-form-label text-md-right" title="">رقم هاتف العميل</label>
                                        <div class="col-md-9">
                                        <input id="buyer_phone" type="tel" class="form-control " name="buyer_phone" placeholder="رقم هاتف العميل" required="" value="{{ old('buyer_phone') ?? '' }}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="buyer_address" class="col-md-3 col-form-label text-md-right">عنوان التسليم</label>
                                        <div class="col-md-9">
                                            <input id="buyer_address" type="text" class="form-control " name="buyer_address" placeholder="عنوان العميل المستلم للشحنة" required="" value="{{ old('buyer_address') ?? '' }}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="package" class="col-md-3 col-form-label text-md-right">نوع الشحنة</label>
                                        <div class="col-md-9">
                                            <input id="package" type="text" class="form-control " name="package" placeholder="مثال: هاتف محمول من نوع ..." required="" value="{{ old('package') ?? '' }}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="amount" class="col-md-3 col-form-label text-md-right">الكمية</label>
                                        <div class="col-md-9">
                                            <input id="amount" type="number" class="form-control " name="amount" placeholder="الكمية" required="" value="{{ old('amount') ?? '1' }}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="price" class="col-md-3 col-form-label text-md-right">سعر الطلب</label>
                                        <div class="col-md-9">
                                            <input id="price" type="text" class="form-control " name="price" placeholder="سعر الطلب" required="" value="{{ old('price') ?? '' }}">
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="details" class="col-md-3 col-form-label text-md-right">بيانات إضافية</label>
                                        <div class="col-md-9">
                                            <textarea id="details" name="details" class="form-control" placeholder="بيانات إضافية" rows="5">{{ old('details') ?? '' }}</textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col-md-12">
                                            <button type="submit" class="submit-btn">
                                                إرسال طلب الشحن
                                            </button>
                                        </div>
                                    </div>
                                </form>
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
@endsection