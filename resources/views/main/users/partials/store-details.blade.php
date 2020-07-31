
<div class="tab-pane fade" id="store" role="tabpanel">
    <div class="light-shadow-bg post-ad-box-layout1 myaccount-store-settings">
        <div class="light-box-content">
            <form action="/account/update-store" method="post" enctype="multipart/form-data" class="ajax">
                @csrf
                @method('PUT')
                <div class="post-section store-information">
                    <div class="post-ad-title">
                        <i class="fas fa-folder-open"></i>
                        <h3 class="item-title">بيانات المتجر</h3>
                    </div>
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
                            <label class="control-label">نبذة مختصرة</label>
                        </div>
                        <div class="col-sm-9">
                            <div class="form-group">
                                <div class="input-group">
                                    <input class="form-control" id="store_slogan" type="text" name="store_slogan" placeholder="نبذة مختصرة" value="{{ old('store_slogan') ? old('store_slogan') : Auth::user()->store_slogan }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="control-label">الموقع الإلكتروني للمتجر</label>
                        </div>
                        <div class="col-sm-9">
                            <div class="form-group">
                                <div class="input-group">
                                    <input class="form-control" id="store_website" type="text" name="store_website" placeholder="الموقع الإلكتروني للمتجر" value="{{ old('store_website') ? old('store_website') : Auth::user()->store_website }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="control-label">البريد الإلكتروني الرسمي للمتجر</label>
                        </div>
                        <div class="col-sm-9">
                            <div class="form-group">
                                <div class="input-group">
                                    <input class="form-control" id="store_email" type="text" name="store_email" placeholder="البريد الإلكتروني الرسمي للمتجر" value="{{ old('store_email') ? old('store_email') : Auth::user()->store_email }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="control-label">الدولة</label>
                        </div>
                        <div class="col-sm-9">
                            <div class="form-group">
                                <div class="input-group">
                                    <select name="country" id="country" class="form-control">
                                        <option value="">-</option>
                                        @foreach(App\Models\Country::get() as $country)
                                            <option value="{{ $country->id }}" {{ Auth::user()->country_id == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="control-label">عنوان المتجر</label>
                        </div>
                        <div class="col-sm-9">
                            <div class="form-group">
                                <div class="input-group">
                                    <textarea name="store_address" class="form-control textarea" id="store_address" cols="30" rows="2" placeholder="عنوان المتجر">{{ old('store_address') ? old('store_address') : Auth::user()->store_address }}</textarea>
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
                            <label class="control-label">حسابات مواقع التواصل الإجتماعي</label>
                        </div>
                        <div class="col-sm-9">
                            <div class="form-group store-social" style="margin-bottom: 1.5rem !important;">
                                <?php 
                                    $social_links = is_array( json_decode(Auth::user()->store_social_accounts) ) ? json_decode(Auth::user()->store_social_accounts) : [];
                                ?>
                                <input type="text" class="form-control" name="social[]" value="{{ isset($social_links[0]) ? $social_links[0] : '' }}">
                                <input type="text" class="form-control" name="social[]" value="{{ isset($social_links[1]) ? $social_links[1] : '' }}">
                                <input type="text" class="form-control" name="social[]" value="{{ isset($social_links[2]) ? $social_links[2] : '' }}">
                                <input type="text" class="form-control" name="social[]" value="{{ isset($social_links[3]) ? $social_links[3] : '' }}">
                                <input type="text" class="form-control" name="social[]" value="{{ isset($social_links[4]) ? $social_links[4] : '' }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="post-section store-banner">
                    <div class="post-ad-title">
                        <i class="far fa-image"></i>
                        <h3 class="item-title">صور المتجر</h3>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="control-label">صورة غلاف المتجر</label>
                        </div>
                        <div class="col-sm-9">
                            <div class="form-group text-right">
                                <input class="form-control store-banner" id="store_banner" type="file" accept="image/*" name="store_banner">
                                <div class="alert alert-danger text-right mt-2"><small>يفضل أن تكون أبعاد الصوره <span dir="ltr">1180x300 px</span>, الحد الأقصى لحجم الملف <span dir="ltr">8 MB</span>.</small></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="control-label">شعار المتجر</label>
                        </div>
                        <div class="col-sm-9">
                            <div class="form-group text-right">
                                <input class="form-control store-logo" id="store_logo" type="file" accept="image/*" name="store_logo">
                                <div class="alert alert-danger text-right mt-2"><small>يفضل أن تكون أبعاد الصوره <span dir="ltr">512x512 px</span>, الحد الأقصى لحجم الملف <span dir="ltr">8 MB</span>.</small></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-9">
                            <div class="form-group">
                                <button type="submit" class="submit-btn">تحديث</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>