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
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">{{ __('Basic Details') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="maps-tab" data-toggle="tab" href="#maps" role="tab" aria-controls="maps" aria-selected="false">إعدادات خرائط جوجل</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">{{ __('Contact Details') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="logo-tab" data-toggle="tab" href="#logo" role="tab" aria-controls="logo" aria-selected="false">{{ __('Website Logo') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">{{ __('Social Accounts') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="promoted-listing-tab" data-toggle="tab" href="#promoted-listing" role="tab" aria-controls="promoted-listing" aria-selected="false">إعدادات الإعلانات المميزة</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="stores-tab" data-toggle="tab" href="#stores" role="tab" aria-controls="stores" aria-selected="false">إعدادات المتاجر</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-12 col-sm-12 col-lg-9">
                            <div class="tab-content border p-3" id="myTab3Content">
                                <div class="tab-pane fade show active p-0" id="home" role="tabpanel" aria-labelledby="home-tab">
                                    <div class="card">
                                        <div class="card-header text-right">
                                            <h4>{{ __('Edit') }} {{ __('Basic Details') }}</h4>
                                        </div>
                                        <div class="card-body">

                                            <form class="update-site-settings form-horizontal text-right" style="direction:rtl;" action="/admin/site-settings/update" method="POST" enctype="multipart/form-data">
                                            	@csrf
                                                <div class="form-group row">
                                                    <label for="website_name" class="col-md-3 col-form-label">{{ __('Website Name') }}</label>
                                                    <div class="col-md-9" dir="ltr">
                                                        <input type="text" required class="form-control" id="website_name" name="website_name"  value="{{ setting('website_name', false) }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="website_description" class="col-md-3 col-form-label">{{ __('Website Description') }}</label>
                                                    <div class="col-md-9" dir="ltr">
                                                        <textarea name="website_description" id="website_description" class="form-control" rows="7" style="line-height: 23px;">{{ setting('website_description', false) }}</textarea>
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

                                <div class="tab-pane fade p-0" id="contact" role="tabpanel" aria-labelledby="contact-tab">
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
                                                <div class="form-group row">
                                                    <label for="delivery_phone" class="col-md-3 col-form-label">رقم هاتف الشحن</label>
                                                    <div class="col-md-9 input-group" dir="ltr">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                                        </div>
                                                        <input type="text" class="form-control" id="delivery_phone" name="delivery_phone"  value="{{ setting('delivery_phone', false) }}" required>
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

                                <div class="tab-pane fade p-0" id="maps" role="tabpanel" aria-labelledby="maps-tab">
                                    <div class="card">
                                        <div class="card-header text-right">
                                            <h4>إعدادات خرائط جوجل</h4>
                                        </div>
                                        <div class="card-body">

                                            <form class="update-site-settings form-horizontal text-right" style="direction:rtl;" action="/admin/site-settings/update" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group row">
                                                    <label for="latitude" class="col-md-3 col-form-label">خط الطول Latitude</label>
                                                    <div class="col-md-9 text-right" dir="ltr">
                                                        <input type="text" class="form-control" id="latitude" name="latitude"  value="{{ setting('latitude', false) }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="longitude" class="col-md-3 col-form-label">دائرة العرض Longitude</label>
                                                    <div class="col-md-9 input-group" dir="ltr">
                                                        <input type="text" class="form-control" id="longitude" name="longitude"  value="{{ setting('longitude', false) }}">
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

                                <div class="tab-pane fade p-0" id="logo" role="tabpanel" aria-labelledby="logo-tab">
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

                                <div class="tab-pane fade p-0" id="profile" role="tabpanel" aria-labelledby="profile-tab">
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
                                                            <span class="input-group-text"><i class="fa fa-linkedin"></i></span>
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

                                <div class="tab-pane fade p-0" id="promoted-listing" role="tabpanel" aria-labelledby="promoted-listing-tab">
                                    <div class="card">
                                        <div class="card-header text-right">
                                            <h4>مزايا الإعلانات المميزة</h4>
                                        </div>
                                        <div class="card-body">

                                            <form class="update-site-settings form-horizontal text-right" style="direction:rtl;" action="/admin/site-settings/update" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group row">
                                                    <label for="featured_ads_benefits" class="col-md-3 col-form-label">مزايا الإعلانات المميزة</label>
                                                    <div class="col-md-9 text-right" dir="rtl">
                                                        <textarea type="text" class="form-control" id="featured_ads_benefits" name="featured_ads_benefits" rows="5">{{ setting('featured_ads_benefits', false) }}</textarea>
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
                                    <div class="card">
                                        <div class="card-header text-right">
                                            <h4>أسعار الإعلانات المميزة</h4>
                                        </div>
                                        <div class="card-body">

                                            <form class="update-site-settings form-horizontal text-right" style="direction:rtl;" action="/admin/site-settings/update" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group row">
                                                    <label for="tier1" class="col-md-3 col-form-label">يوم</label>
                                                    <div class="col-md-9 input-group" dir="ltr">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-dollar"></i></span>
                                                        </div>
                                                        <input type="number" step="0.01" class="form-control" id="tier1" name="tier1"  value="{{ setting('tier1', false) }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="tier2" class="col-md-3 col-form-label">3 أيام</label>
                                                    <div class="col-md-9 input-group" dir="ltr">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-dollar"></i></span>
                                                        </div>
                                                        <input type="number" step="0.01" class="form-control" id="tier2" name="tier2"  value="{{ setting('tier2', false) }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="tier3" class="col-md-3 col-form-label">أسبوع</label>
                                                    <div class="col-md-9 input-group" dir="ltr">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-dollar"></i></span>
                                                        </div>
                                                        <input type="number" step="0.01" class="form-control" id="tier3" name="tier3"  value="{{ setting('tier3', false) }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="tier4" class="col-md-3 col-form-label">15 يوم</label>
                                                    <div class="col-md-9 input-group" dir="ltr">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-dollar"></i></span>
                                                        </div>
                                                        <input type="number" step="0.01" class="form-control" id="tier4" name="tier4"  value="{{ setting('tier4', false) }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="tier5" class="col-md-3 col-form-label">شهر</label>
                                                    <div class="col-md-9 input-group" dir="ltr">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-dollar"></i></span>
                                                        </div>
                                                        <input type="number" step="0.01" class="form-control" id="tier5" name="tier5"  value="{{ setting('tier5', false) }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="tier6" class="col-md-3 col-form-label">3 شهور</label>
                                                    <div class="col-md-9 input-group" dir="ltr">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-dollar"></i></span>
                                                        </div>
                                                        <input type="number" step="0.01" class="form-control" id="tier6" name="tier6"  value="{{ setting('tier6', false) }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="tier7" class="col-md-3 col-form-label">6 شهور</label>
                                                    <div class="col-md-9 input-group" dir="ltr">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-dollar"></i></span>
                                                        </div>
                                                        <input type="number" step="0.01" class="form-control" id="tier7" name="tier7"  value="{{ setting('tier7', false) }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="tier8" class="col-md-3 col-form-label">سنة</label>
                                                    <div class="col-md-9 input-group" dir="ltr">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-dollar"></i></span>
                                                        </div>
                                                        <input type="number" step="0.01" class="form-control" id="tier8" name="tier8"  value="{{ setting('tier8', false) }}">
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
                                    <div class="card">
                                        <div class="card-header text-right">
                                            <h4>مزايا الإعلانات المثبتة</h4>
                                        </div>
                                        <div class="card-body">

                                            <form class="update-site-settings form-horizontal text-right" style="direction:rtl;" action="/admin/site-settings/update" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group row">
                                                    <label for="featured_ads_benefits2" class="col-md-3 col-form-label">مزايا الإعلانات المثبتة</label>
                                                    <div class="col-md-9 text-right" dir="rtl">
                                                        <textarea type="text" class="form-control" id="featured_ads_benefits2" name="featured_ads_benefits2" rows="5">{{ setting('featured_ads_benefits2', false) }}</textarea>
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
                                    <div class="card">
                                        <div class="card-header text-right">
                                            <h4>أسعار الإعلانات المثبتة</h4>
                                        </div>
                                        <div class="card-body">

                                            <form class="update-site-settings form-horizontal text-right" style="direction:rtl;" action="/admin/site-settings/update" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group row">
                                                    <label for="tier9" class="col-md-3 col-form-label">شهر</label>
                                                    <div class="col-md-9 input-group" dir="ltr">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-dollar"></i></span>
                                                        </div>
                                                        <input type="number" step="0.01" class="form-control" id="tier9" name="tier9"  value="{{ setting('tier9', false) }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="tier10" class="col-md-3 col-form-label">شهرين</label>
                                                    <div class="col-md-9 input-group" dir="ltr">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-dollar"></i></span>
                                                        </div>
                                                        <input type="number" step="0.01" class="form-control" id="tier10" name="tier10"  value="{{ setting('tier10', false) }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="tier11" class="col-md-3 col-form-label">3 شهور</label>
                                                    <div class="col-md-9 input-group" dir="ltr">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-dollar"></i></span>
                                                        </div>
                                                        <input type="number" step="0.01" class="form-control" id="tier11" name="tier11"  value="{{ setting('tier11', false) }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="tier12" class="col-md-3 col-form-label">4 شهور</label>
                                                    <div class="col-md-9 input-group" dir="ltr">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-dollar"></i></span>
                                                        </div>
                                                        <input type="number" step="0.01" class="form-control" id="tier12" name="tier12"  value="{{ setting('tier12', false) }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="tier13" class="col-md-3 col-form-label">5 شهور</label>
                                                    <div class="col-md-9 input-group" dir="ltr">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-dollar"></i></span>
                                                        </div>
                                                        <input type="number" step="0.01" class="form-control" id="tier13" name="tier13"  value="{{ setting('tier13', false) }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="tier14" class="col-md-3 col-form-label">6 شهور</label>
                                                    <div class="col-md-9 input-group" dir="ltr">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-dollar"></i></span>
                                                        </div>
                                                        <input type="number" step="0.01" class="form-control" id="tier14" name="tier14"  value="{{ setting('tier14', false) }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="tier15" class="col-md-3 col-form-label">7 شهور</label>
                                                    <div class="col-md-9 input-group" dir="ltr">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-dollar"></i></span>
                                                        </div>
                                                        <input type="number" step="0.01" class="form-control" id="tier15" name="tier15"  value="{{ setting('tier15', false) }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="tier16" class="col-md-3 col-form-label">8 شهور</label>
                                                    <div class="col-md-9 input-group" dir="ltr">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-dollar"></i></span>
                                                        </div>
                                                        <input type="number" step="0.01" class="form-control" id="tier16" name="tier16"  value="{{ setting('tier16', false) }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="tier17" class="col-md-3 col-form-label">9 شهور</label>
                                                    <div class="col-md-9 input-group" dir="ltr">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-dollar"></i></span>
                                                        </div>
                                                        <input type="number" step="0.01" class="form-control" id="tier17" name="tier17"  value="{{ setting('tier17', false) }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="tier18" class="col-md-3 col-form-label">10 شهور</label>
                                                    <div class="col-md-9 input-group" dir="ltr">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-dollar"></i></span>
                                                        </div>
                                                        <input type="number" step="0.01" class="form-control" id="tier18" name="tier18"  value="{{ setting('tier18', false) }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="tier19" class="col-md-3 col-form-label">11 شهر</label>
                                                    <div class="col-md-9 input-group" dir="ltr">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-dollar"></i></span>
                                                        </div>
                                                        <input type="number" step="0.01" class="form-control" id="tier19" name="tier19"  value="{{ setting('tier19', false) }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="tier20" class="col-md-3 col-form-label">12 شهر</label>
                                                    <div class="col-md-9 input-group" dir="ltr">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-dollar"></i></span>
                                                        </div>
                                                        <input type="number" step="0.01" class="form-control" id="tier20" name="tier20"  value="{{ setting('tier20', false) }}">
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
                                
                                <div class="tab-pane fade p-0" id="stores" role="tabpanel" aria-labelledby="stores-tab">
                                    <div class="card">
                                        <div class="card-header text-right">
                                            <h4>إعدادات عامة</h4>
                                        </div>
                                        <div class="card-body">

                                            <form class="update-site-settings form-horizontal text-right" style="direction:rtl;" action="/admin/site-settings/update" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group row">
                                                    <label for="trial_period" class="col-md-3 col-form-label">مدة الفترة التجريبية</label>
                                                    <div class="col-md-9 input-group" dir="ltr">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><small>يوم</small></span>
                                                        </div>
                                                        <input type="number" step="0.01" class="form-control" id="trial_period" name="trial_period" value="{{ setting('trial_period', false) }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="grace_period" class="col-md-3 col-form-label">مدة فترة السماح</label>
                                                    <div class="col-md-9 input-group" dir="ltr">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><small>يوم</small></span>
                                                        </div>
                                                        <input type="number" step="0.01" class="form-control" id="grace_period" name="grace_period" value="{{ setting('grace_period', false) }}">
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
                                    <div class="card">
                                        <div class="card-header text-right">
                                            <h4>إشتراكات المتاجر</h4>
                                        </div>
                                        <div class="card-body">

                                            <form class="update-site-settings form-horizontal text-right" style="direction:rtl;" action="/admin/site-settings/update" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group row">
                                                    <label for="monthly_subscription" class="col-md-3 col-form-label">شهري</label>
                                                    <div class="col-md-9 input-group" dir="ltr">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-dollar"></i></span>
                                                        </div>
                                                        <input type="number" step="0.01" class="form-control" id="monthly_subscription" name="monthly_subscription" value="{{ setting('monthly_subscription', false) }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="half_year_subscription" class="col-md-3 col-form-label">نصف سنوي</label>
                                                    <div class="col-md-9 input-group" dir="ltr">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-dollar"></i></span>
                                                        </div>
                                                        <input type="number" step="0.01" class="form-control" id="half_year_subscription" name="half_year_subscription" value="{{ setting('half_year_subscription', false) }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="yearly_subscription" class="col-md-3 col-form-label">سنوي</label>
                                                    <div class="col-md-9 input-group" dir="ltr">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-dollar"></i></span>
                                                        </div>
                                                        <input type="number" step="0.01" class="form-control" id="yearly_subscription" name="yearly_subscription" value="{{ setting('yearly_subscription', false) }}">
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