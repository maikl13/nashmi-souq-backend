@extends('store.layouts.store')

@section('title', 'دفع قيمة الإشتراك')

@section('head')
    <link rel="stylesheet" href="/assets/plugins/select2/select2.min.css">
    <style>
        .select2-container {
            direction: rtl !important;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            float: right !important;
        }
        .select2-container .select2-search--inline {
            float: right !important;
        }
        .select2-selection__choice__remove { float: left !important; }
        .select2-container--default .select2-selection__rendered li {
            padding-left: 3px !important;
            padding-right: 12px;
        }
        .select2-container--default .select2-selection--single .select2-selection__clear {
            float: left !important;
        }
        .select2-container .select2-search--inline .select2-search__field {
            margin-top: 10px;
        }
    </style>
@endsection

@section('content')
    <section class="section-padding-equal-70" data-bg-image="/assets/images/banner/banner2.jpg" style=";background-blend-mode: overlay;background-repeat: no-repeat;background-position: center;background-size: cover;background-color: #444444;">
        <div class="container my-5">
            <div class="col-xs-12 col-lg-8 col-xl-6 mx-auto my-5">
                <div class="card" style="border-radius: 15px;overflow: hidden;border: none;">
                    <div class="card-header py-5" style="text-align: center;background: #f85c7017;border: none;">
                        <span class="card-title" style="font-size: 22px; color: #333;">
                            @if (auth()->user()->subscriptions()->active()->count())
                                إنتهت مدة الاشتراك برجاء التجديد 
                            @else
                                اختر وسيلة الدفع المناسبة لإتمام الاشتراك
                            @endif
                        </span>
                    </div>

                    <div class="card-body">
                        
                        <div class="post-ad-box-layout1 myaccount-store-settings">
                            <form action="{{ route('subscription.store', auth()->user()->store_slug) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="post-section store-information">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label class="control-label">نوع الاشتراك</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <div class="form-group">
                                                <select name="subscription_type" id="" class="form-control">
                                                    <option value="1" {{ auth()->user()->subscription_type == 1 ? 'selected' : '' }}>
                                                        شهري ({{ setting('monthly_subscription') }}$)
                                                    </option>
                                                    <option value="2" {{ auth()->user()->subscription_type == 2 ? 'selected' : '' }}>
                                                        نصف سنوي ({{ setting('half_year_subscription') }}$)
                                                    </option>
                                                    <option value="4" {{ auth()->user()->subscription_type == 3 ? 'selected' : '' }}>
                                                        سنوي ({{ setting('yearly_subscription') }}$)
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label class="control-label">طريقة الدفع</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <div class="form-group">
                                                <select name="payment_method" id="" class="form-control">
                                                    <option value="{{ App\Models\Transaction::PAYMENT_DIRECT_PAYMENT }}">بطاقة إئتمانية</option>
                                                    <option value="{{ App\Models\Transaction::PAYMENT_MADA }}">مدى</option>
                                                    <option value="{{ App\Models\Transaction::PAYMENT_PAYPAL }}">باي بال</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <button type="submit" class="submit-btn btn-block py-3">دفع</button>
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
    </section>
@endsection

@section('scripts')
    <script src="/assets/js/ajax/ajax.js"></script>
    <script src="/assets/plugins/labelauty/source/jquery-labelauty.js"></script>
@endsection