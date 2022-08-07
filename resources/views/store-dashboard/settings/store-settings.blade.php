@extends('store-dashboard.layouts.store-dashboard')

@section('title', 'إعدادات المتجر')

@section('head')
@endsection

@section('content')
    <form class="row" action="/dashboard/store-settings" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="col-12 col-xl-6">
            <div class="card">
                <div class="card-header text-right" dir="rtl">
                    <h4> الاعدادات العامة </h4>
                </div>
                <div class="card-body text-right" dir="rtl" style="margin: -30px;">
                    @include('store-dashboard.settings.partials.store-details-general')
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-6">
            <div class="card">
                <div class="card-header text-right" dir="rtl">
                    <h4> بيانات التواصل </h4>
                </div>
                <div class="card-body text-right" dir="rtl" style="margin: -30px;">
                    @include('store-dashboard.settings.partials.store-details-contact')
                </div>
            </div>
        </div>
    </form>
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