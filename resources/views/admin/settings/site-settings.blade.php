@extends('admin.layouts.admin')

@section('title', __('Website Settings'))

@section('breadcrumb')
	<li class="breadcrumb-item active" aria-current="page">{{ __('Website Settings') }}</li>
@endsection

@section('content')
    
    <div class="row">
        <div class="col-12">
            <div class="card  text-right" style="direction:rtl">
                <div class="card-header">
                    <h4>{{ __('Website Settings') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-lg-3">
                            <ul class="nav nav-pills flex-column pr-0" id="myTab4" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab4" data-toggle="tab" href="#home4" role="tab" aria-controls="home" aria-selected="true">{{ __('Basic Details') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="contact-tab4" data-toggle="tab" href="#contact4" role="tab" aria-controls="contact" aria-selected="false">{{ __('Contact Details') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="logo-tab4" data-toggle="tab" href="#logo4" role="tab" aria-controls="logo" aria-selected="false">{{ __('Website Logo') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab4" data-toggle="tab" href="#profile4" role="tab" aria-controls="profile" aria-selected="false">{{ __('Social Accounts') }}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-12 col-sm-12 col-lg-9">
                            <div class="tab-content border p-3" id="myTab3Content">
                                <div class="tab-pane fade show active p-0" id="home4" role="tabpanel" aria-labelledby="home-tab4">
                                    <div class="card">
                                        <div class="card-header text-right">
                                            <h4>{{ __('Edit') }} {{ __('Basic Details') }}</h4>
                                        </div>
                                        <div class="card-body">

                                            <form class="update-site-settings form-horizontal text-right" style="direction:rtl;" action="/admin/site-settings/update" method="POST" enctype="multipart/form-data">
                                            	@csrf
                                                <div class="form-group row">
                                                    <label for="name" class="col-md-3 col-form-label">{{ __('Website Name') }}</label>
                                                    <div class="col-md-9" dir="ltr">
                                                        <input type="text" required class="form-control" id="name" name="name"  value="{{ setting('website_name', false) }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="description" class="col-md-3 col-form-label">{{ __('Website Description') }}</label>
                                                    <div class="col-md-9" dir="ltr">
                                                        <textarea name="description" id="description" class="form-control" rows="7" style="line-height: 23px;">{{ setting('website_description', false) }}</textarea>
                                                    </div>
                                                </div>
                                                @if(false)
                                                    <div class="form-group row">
                                                        <label for="hide_developer_names" class="col-md-3 col-form-label">{{ __('Hide Developer Name') }}</label>
                                                        <div class="col-md-9" dir="ltr">
                                                            <select name="hide_developer_names" id="hide_developer_names" class="form-control" dir="rtl">
                                                                <option value="0">{{ __('No') }}</option>
                                                                <option value="1" {{ setting('hide_developers_names', false) ? 'selected' : '' }}>{{ __('Yes') }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                @endif

                                                <div class="form-group mb-0 mt-2 row justify-content-end">
                                                    <div class="col-md-9">
                                                        <button type="submit" class="btn btn-primary float-left">{{ __('Save') }}</button>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade p-0" id="contact4" role="tabpanel" aria-labelledby="contact-tab4">
                                    <div class="card">
                                        <div class="card-header text-right">
                                            <h4>{{ __('Social Accounts') }}</h4>
                                        </div>
                                        <div class="card-body">

                                            <form class="update-site-settings form-horizontal text-right" style="direction:rtl;" action="/admin/site-settings/update" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group row">
                                                    <label for="address" class="col-md-3 col-form-label">{{ __('Address') }}</label>
                                                    <div class="col-md-9 input-group" dir="ltr">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-map-marker"></i></span>
                                                        </div>
                                                        <input type="text" class="form-control" id="address" name="address"  value="{{ setting('address', false) }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="email" class="col-md-3 col-form-label">{{ __('Email') }}</label>
                                                    <div class="col-md-9 input-group" dir="ltr">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                                        </div>
                                                        <input type="text" class="form-control" id="email" name="email"  value="{{ setting('email', false) }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="phone" class="col-md-3 col-form-label">{{ __('Phone') }}</label>
                                                    <div class="col-md-9 input-group" dir="ltr">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                                        </div>
                                                        <input type="text" class="form-control" id="phone" name="phone"  value="{{ setting('phone', false) }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="phone2" class="col-md-3 col-form-label">{{ __('Phone') }} 2</label>
                                                    <div class="col-md-9 input-group" dir="ltr">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                                        </div>
                                                        <input type="text" class="form-control" id="phone2" name="phone2"  value="{{ setting('phone2', false) }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="fax" class="col-md-3 col-form-label">{{ __('Fax') }}</label>
                                                    <div class="col-md-9 input-group" dir="ltr">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-fax"></i></span>
                                                        </div>
                                                        <input type="text" class="form-control" id="fax" name="fax"  value="{{ setting('fax', false) }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="whatsapp" class="col-md-3 col-form-label">{{ __('Whatsapp') }}</label>
                                                    <div class="col-md-9 input-group" dir="ltr">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-whatsapp"></i></span>
                                                        </div>
                                                        <input type="text" class="form-control" id="whatsapp" name="whatsapp"  value="{{ setting('whatsapp', false) }}">
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

                                <div class="tab-pane fade p-0" id="logo4" role="tabpanel" aria-labelledby="logo-tab4">
                                    <div class="card">
                                        <div class="card-header text-right">
                                            <h4>{{ __('Website Logo') }}</h4>
                                        </div>
                                        <div class="card-body">
                                            <form class="update-site-settings form-horizontal text-right" style="direction:rtl;" action="/admin/site-settings/update" method="POST" enctype="multipart/form-data">
                                                @csrf


                                                <div class="form-group">
                                                    <label for="logo" class="col-md-3 col-form-label">{{ __('Logo') }}</label>
                                                    <div class="text-right">
                                                        <input class="form-control logo" id="logo" type="file" accept="image/*" name="logo">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="footer_logo" class="col-md-3 col-form-label">{{ __('Footer Logo') }}</label>
                                                    <div class="text-right">
                                                        <input class="form-control footer_logo" id="footer_logo" type="file" accept="image/*" name="footer_logo">
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

                                <div class="tab-pane fade p-0" id="profile4" role="tabpanel" aria-labelledby="profile-tab4">
                                    <div class="card">
                                        <div class="card-header text-right">
                                            <h4>{{ __('Social Accounts') }}</h4>
                                        </div>
                                        <div class="card-body">

                                            <form class="update-site-settings form-horizontal text-right" style="direction:rtl;" action="/admin/site-settings/update" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group row">
                                                    <label for="facebook" class="col-md-3 col-form-label">{{ __('Facebook') }}</label>
                                                    <div class="col-md-9 input-group" dir="ltr">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-facebook"></i></span>
                                                        </div>
                                                        <input type="text" class="form-control" id="facebook" name="facebook"  value="{{ setting('facebook', false) }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="twitter" class="col-md-3 col-form-label">{{ __('Twitter') }}</label>
                                                    <div class="col-md-9 input-group" dir="ltr">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-twitter"></i></span>
                                                        </div>
                                                        <input type="text" class="form-control" id="twitter" name="twitter"  value="{{ setting('twitter', false) }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="instagram" class="col-md-3 col-form-label">{{ __('Instagram') }}</label>
                                                    <div class="col-md-9 input-group" dir="ltr">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-instagram"></i></span>
                                                        </div>
                                                        <input type="text" class="form-control" id="instagram" name="instagram"  value="{{ setting('instagram', false) }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="youtube" class="col-md-3 col-form-label">{{ __('Youtube') }}</label>
                                                    <div class="col-md-9 input-group" dir="ltr">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-youtube-play"></i></span>
                                                        </div>
                                                        <input type="text" class="form-control" id="youtube" name="youtube"  value="{{ setting('youtube', false) }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="linkedin" class="col-md-3 col-form-label">{{ __('Linked-in') }}</label>
                                                    <div class="col-md-9 input-group" dir="ltr">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-linkedin-in"></i></span>
                                                        </div>
                                                        <input type="text" class="form-control" id="linkedin" name="linkedin"  value="{{ setting('linkedin', false) }}">
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
        @foreach(['logo', 'footer_logo'] as $image)
            @if(setting($image, true))
                var imageOptions = $.extend(true,{
                    initialPreview: ['{{ setting($image, true) }}'],
                    initialPreviewConfig : [{caption: "Logo"}],
                    deleteUrl: "site-settings/{{ $image }}/delete",
                },fileInputOptions);
                $("[type=file].{{ $image }}").fileinput(imageOptions);
            @else
                $("[type=file].{{ $image }}").fileinput(fileInputOptions);
            @endif
        @endforeach
    </script>
@endsection