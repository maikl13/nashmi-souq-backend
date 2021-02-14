@extends('main.layouts.main')

@section('title', 'أقسام المتجر')

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
        <div class="container">
            <div class="col-xs-12 col-lg-8 col-xl-6 mx-auto">
                <div class="card" style="border-radius: 15px;overflow: hidden;border: none;">
                    <div class="card-header py-5" style="text-align: center;background: #f85c7017;border: none;">
                        <span class="card-title" style="font-size: 22px; color: #333;">قم بإختيار الفئات التي سيتم عرضها في المتجر</span>
                    </div>

                    <div class="card-body">
                        
                        <div class="post-ad-box-layout1 myaccount-store-settings">
                            <form action="{{ route('store-categories.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="post-section store-information">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <select name="categories[]" class="form-control select2" multiple>
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <button type="submit" class="submit-btn btn-block py-3">حفظ</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                    
                    <div class="card-footer py-4" style="text-align: center;background: #f85c7017;border: none;">
                        <i class="fa fa-exclamation-circle"></i>
                        يمكنك تعديل الأقسام لاحقا من لوحة تحكم المتجر
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

    <script src="/assets/plugins/select2/select2.min.js"></script>
    <script>
        $('.select2').select2({
            placeholder: "قم بإختيار أقسام المتجر"
        });
    </script>
@endsection