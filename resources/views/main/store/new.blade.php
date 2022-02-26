@extends('main.layouts.main')

@section('title', 'انشاء متجر جديد')

@section('content')
    <section class="section-padding-equal-70" data-bg-image="/assets/images/banner/banner2.jpg" style=";background-blend-mode: overlay;background-repeat: no-repeat;background-position: center;background-size: cover;background-color: #444444;">
        <div class="container">
            <div class="col-xs-12 col-lg-8 col-xl-6 mx-auto">
                <div class="card" style="border-radius: 15px;overflow: hidden;border: none;">
                    <div class="card-header py-5" style="text-align: center;background: #f85c7017;border: none;">
                        <span class="card-title" style="font-size: 22px; color: #333;">انشاء متجر جديد</span>
                    </div>

                    <div class="card-body">
                        
                        <div class="post-ad-box-layout1 myaccount-store-settings">
                            <form action="/stores/new" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="store_online_payments" value="on">
                                <input type="hidden" name="store_cod_payments" value="on">
                                <div class="post-section store-information">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label class="control-label">إسم المتجر <span>*</span></label>
                                        </div>
                                        <div class="col-sm-9">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input class="form-control" id="store_name" type="text" name="store_name" placeholder="إسم المتجر" value="{{ old('store_name') ? old('store_name') : Auth::user()->store_name }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label class="control-label">رابط المتجر <span>*</span></label>
                                        </div>
                                        <div class="col-sm-9">
                                            
                                            <div class="form-group" dir="ltr">
                                                <div class="input-group">
                                                    <input class="form-control" id="store_slug" type="text" name="store_slug" placeholder="رابط المتجر" value="{{ old('store_slug') ? old('store_slug') : Auth::user()->store_slug }}">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="basic-addon3">.{{ config('app.domain') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label class="control-label">وصف المتجر</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <div class="form-group">
                                                <textarea name="store_description" class="form-control textarea" id="store_description" cols="30" rows="4" placeholder="وصف المتجر">{{ old('store_description') ? old('store_description') : Auth::user()->store_description }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label class="control-label">نوع الاشتراك</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <div class="form-group">
                                                <select name="subscription_type" id="" class="form-control">
                                                    <option value="1" {{ request()->type == 1 ? 'selected' : '' }}>شهري</option>
                                                    <option value="2" {{ request()->type == 2 ? 'selected' : '' }}>نصف سنوي</option>
                                                    <option value="4" {{ request()->type == 3 ? 'selected' : '' }}>سنوي</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-9">
                                            <div class="form-group">
                                                <button type="submit" class="submit-btn btn-block py-3">إنشاء المتجر</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                    
                    <div class="card-footer py-4" style="text-align: center;background: #f85c7017;border: none;">
                        <i class="fa fa-exclamation-circle"></i>
                        يمكنك تعديل كافة البيانات السابقة لاحقا
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="/assets/js/ajax/ajax.js"></script>

    <script type="text/javascript">
        var store_banner_fileInputOptions = fileInputOptions,
            store_logo_fileInputOptions = fileInputOptions;

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

        $("[type=file].store-banner").fileinput(store_banner_fileInputOptions);
        $("[type=file].store-logo").fileinput(store_logo_fileInputOptions);
    </script>

    <script src="/assets/plugins/labelauty/source/jquery-labelauty.js"></script>
@endsection