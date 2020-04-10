@extends('admin.layouts.admin')

@section('title', __('Website Sections'))

@section('breadcrumb')
	<li class="breadcrumb-item active" aria-current="page">{{ __('Website Sections') }}</li>
@endsection

@section('content')
    
    <div class="row">
        <div class="col-12">
            <div class="card  text-right" style="direction:rtl">
                <div class="card-header">
                    <h4>{{ __('Website Sections') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-lg-3">
                            <ul class="nav nav-pills flex-column pr-0" id="myTab4" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home" data-toggle="tab" href="#home-panel" role="tab" aria-controls="home" aria-selected="true">الرئيسية</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="about" data-toggle="tab" href="#about-panel" role="tab" aria-controls="about" aria-selected="false">{{ __('About Us') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="privacy" data-toggle="tab" href="#privacy-panel" role="tab" aria-controls="contact" aria-selected="false">{{ __('Privacy Policy') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="terms" data-toggle="tab" href="#terms-panel" role="tab" aria-controls="contact" aria-selected="false">{{ __('Terms And Conditions') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="safety" data-toggle="tab" href="#safety-panel" role="tab" aria-controls="contact" aria-selected="false">قواعد السلامة</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-12 col-sm-12 col-lg-9">
                            <div class="tab-content border p-3" id="myTab3Content">

                                <div class="tab-pane fade show active p-0" id="home-panel" role="tabpanel" aria-labelledby="home">
                                    <div class="card">
                                        <div class="card-header text-right">
                                            <h4>الرئيسية</h4>
                                        </div>
                                        <div class="card-body">
                                            <form class="update-site-settings form-horizontal text-right" style="direction:rtl;" action="/admin/site-settings/update" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group row">
                                                    <label for="slogan" class="col-md-3 col-form-label">شعار كتابي</label>
                                                    <div class="col-md-9 text-right" dir="ltr">
                                                        <input type="text" class="form-control" id="slogan" name="slogan"  value="{{ setting('slogan', false) }}">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="notification" class="col-md-3 col-form-label">إشعار للمستخدمين</label>
                                                    <div class="col-md-9 text-right" dir="ltr">
                                                        <textarea name="notification" id="notification" class="form-control" rows="4">{{ setting('notification', false) }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="notification2" class="col-md-3 col-form-label">إشعار للمستخدمين 2</label>
                                                    <div class="col-md-9 text-right" dir="ltr">
                                                        <textarea name="notification2" id="notification2" class="form-control" rows="3">{{ setting('notification2', false) }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="open_store_section_header" class="col-md-3 col-form-label">عنوان قسم المتجر الخاص</label>
                                                    <div class="col-md-9 text-right" dir="ltr">
                                                        <input type="text" class="form-control" id="open_store_section_header" name="open_store_section_header"  value="{{ setting('open_store_section_header', false) }}">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="open_store_section" class="col-md-3 col-form-label">قسم المتجر الخاص</label>
                                                    <div class="col-md-9 text-right" dir="ltr">
                                                        <textarea name="open_store_section" id="open_store_section" class="form-control" rows="3">{{ setting('open_store_section', false) }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="form-group mb-0 mt-2 row justify-content-end">
                                                    <div class="col-md-9">
                                                        <button type="submit" class="btn btn-primary float-left">{{ __('Save') }}</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade p-0" id="about-panel" role="tabpanel" aria-labelledby="about">
                                    <div class="card">
                                        <div class="card-header text-right">
                                            <h4>{{ __('About Us') }}</h4>
                                        </div>
                                        <div class="card-body">

                                            <form class="update-site-settings form-horizontal text-right" style="direction:rtl;" action="/admin/site-settings/update" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="about" class="col-form-label">{{ __('About Us') }}</label>
                                                    <textarea name="about" id="about" class="form-control editor" cols="30" rows="10" style="line-height: 23px;">{{ setting('about', false) }}</textarea>
                                                </div>

                                                <div class="form-group mb-0 mt-2 row justify-content-end">
                                                    <div class="col-md-9">
                                                        <button type="submit" class="btn btn-primary float-left">{{ __('Save') }}</button>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade p-0" id="privacy-panel" role="tabpanel" aria-labelledby="privacy">
                                    <div class="card">
                                        <div class="card-header text-right">
                                            <h4>{{ __('Privacy Policy') }}</h4>
                                        </div>
                                        <div class="card-body">

                                            <form class="update-site-settings form-horizontal text-right" style="direction:rtl;" action="/admin/site-settings/update" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="privacy" class="col-form-label">{{ __('Privacy Policy') }}</label>
                                                    <textarea name="privacy" id="privacy" cols="30" rows="10" class="form-control editor">{{ setting('privacy', true) }}</textarea>
                                                </div>
                                                <div class="form-group mb-0 mt-2 row justify-content-end">
                                                    <div class="col-md-9">
                                                        <button type="submit" class="btn btn-primary float-left">{{ __('Save') }}</button>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade p-0" id="terms-panel" role="tabpanel" aria-labelledby="terms">
                                    <div class="card">
                                        <div class="card-header text-right">
                                            <h4>{{ __('Terms And Conditions') }}</h4>
                                        </div>
                                        <div class="card-body">

                                            <form class="update-site-settings form-horizontal text-right" style="direction:rtl;" action="/admin/site-settings/update" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="terms" class="col-form-label">{{ __('Terms And Conditions') }}</label>
                                                    <textarea name="terms" id="terms" cols="30" rows="10" class="form-control editor">{{ setting('terms', true) }}</textarea>
                                                </div>
                                                <div class="form-group mb-0 mt-2 row justify-content-end">
                                                    <div class="col-md-9">
                                                        <button type="submit" class="btn btn-primary float-left">{{ __('Save') }}</button>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade p-0" id="safety-panel" role="tabpanel" aria-labelledby="safety">
                                    <div class="card">
                                        <div class="card-header text-right">
                                            <h4>قواعد السلامة</h4>
                                        </div>
                                        <div class="card-body">

                                            <form class="update-site-settings form-horizontal text-right" style="direction:rtl;" action="/admin/site-settings/update" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="safety" class="col-form-label">قواعد السلامة</label>
                                                    <textarea name="safety" id="safety" cols="30" rows="10" class="form-control editor">{{ setting('safety', true) }}</textarea>
                                                </div>
                                                <div class="form-group mb-0 mt-2 row justify-content-end">
                                                    <div class="col-md-9">
                                                        <button type="submit" class="btn btn-primary float-left">{{ __('Save') }}</button>
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
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="/admin-assets/js/ajax/settings.js"></script>

    <script type="text/javascript">
        @foreach(['about_image'] as $image)
            @if(setting($image, false))
                var imageOptions = $.extend(true,{
                    initialPreview: ['{{ setting($image, true) }}'],
                    initialPreviewConfig : [{caption: "Image"}],
                    deleteUrl: "site-settings/{{ $image }}/delete",
                },fileInputOptions);
                $("[type=file].{{ $image }}").fileinput(imageOptions);
            @else
                $("[type=file].{{ $image }}").fileinput(fileInputOptions);
            @endif
        @endforeach
    </script>
@endsection