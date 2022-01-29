<form action="/dashboard/store-settings" method="post" enctype="multipart/form-data" style="margin: -30px;">
    @csrf
    @method('PUT')
    <div class="card-body">
        <div class="form-group">
            <label class="control-label">إسم المتجر <span>*</span></label>
            <input class="form-control" id="store_name" type="text" name="store_name" placeholder="إسم المتجر" value="{{ old('store_name') ?? Auth::user()->store_name }}">
        </div>
        <div class="form-group">
            <label class="control-label">رابط المتجر <span>*</span></label>
            
            <div class="input-group" dir="ltr">
                <input class="form-control text-left" id="store_slug" type="text" name="store_slug" placeholder="رابط المتجر" value="{{ old('store_slug') ?? Auth::user()->store_slug }}">
                <div class="input-group-append bg-gray">
                    <span class="input-group-text" id="basic-addon3" style="padding: 7px 11px;">.{{ config('app.domain') }}</span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label">نبذة مختصرة</label>
            <input class="form-control" id="store_slogan" type="text" name="store_slogan" placeholder="نبذة مختصرة" value="{{ old('store_slogan') ?? Auth::user()->store_slogan }}">
        </div>
        <div class="form-group">
            <label class="control-label">الموقع الإلكتروني للمتجر</label>
            <input class="form-control" id="store_website" type="text" name="store_website" placeholder="الموقع الإلكتروني للمتجر" value="{{ old('store_website') ?? Auth::user()->store_website }}">
        </div>
        <div class="form-group">
            <label class="control-label">البريد الإلكتروني الرسمي للمتجر</label>
            <input class="form-control" id="store_email" type="text" name="store_email" placeholder="البريد الإلكتروني الرسمي للمتجر" value="{{ old('store_email') ?? Auth::user()->store_email }}">
        </div>
        <div class="form-group">
            <label class="control-label">الدولة</label>
            <select name="country" id="country" class="form-control">
                <option value="">-</option>
                @foreach(App\Models\Country::get() as $country)
                    <option value="{{ $country->id }}" {{ Auth::user()->country_id == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label class="control-label">عنوان المتجر</label>
            <textarea name="store_address" class="form-control textarea" id="store_address" cols="30" rows="2" placeholder="عنوان المتجر">{{ old('store_address') ?? Auth::user()->store_address }}</textarea>
        </div>
        <div class="form-group">
            <label class="control-label">وصف المتجر</label>
            <textarea name="store_description" class="form-control textarea" id="store_description" cols="30" rows="4" placeholder="وصف المتجر">{{ old('store_description') ?? Auth::user()->store_description }}</textarea>
        </div>
        <div class="form-group store-social" style="margin-bottom: 1.5rem !important;">
            <label class="control-label">حسابات مواقع التواصل الإجتماعي</label>
            <?php 
                $social_links = is_array( json_decode(Auth::user()->store_social_accounts) ) ? json_decode(Auth::user()->store_social_accounts) : [];
            ?>
            <div class="input-group mb-2">
                <input type="text" class="form-control text-left" name="social[]" value="{{ $social_links[0] ?? '' }}">
                <div class="input-group-append bg-gray" style="padding: 12px 18px;"><i class="fab fa-facebook-f"></i></div>
            </div>
            <div class="input-group mb-2">
                <input type="text" class="form-control text-left" name="social[]" value="{{ $social_links[1] ?? '' }}">
                <div class="input-group-append bg-gray" style="padding: 12px 18px;"><i class="fab fa-twitter"></i></div>
            </div>
            <div class="input-group mb-2">
                <input type="text" class="form-control text-left" name="social[]" value="{{ $social_links[2] ?? '' }}">
                <div class="input-group-append bg-gray" style="padding: 12px 18px;"><i class="fab fa-instagram"></i></div>
            </div>
            <div class="input-group mb-2">
                <input type="text" class="form-control text-left" name="social[]" value="{{ $social_links[3] ?? '' }}">
                <div class="input-group-append bg-gray" style="padding: 12px 18px;"><i class="fab fa-youtube"></i></div>
            </div>
            <div class="input-group mb-2">
                <input type="text" class="form-control text-left" name="social[]" value="{{ $social_links[4] ?? '' }}">
                <div class="input-group-append bg-gray" style="padding: 12px 18px;"><i class="fa fa-globe"></i></div>
            </div>
        </div>
        <div class="form-group store-social" style="margin-bottom: 1.5rem !important;">
            <label class="control-label">أقسام المتجر</label>
            <?php 
                $categories = App\Models\Category::whereNull('category_id')->get();
                $selected = auth()->user()->store_categories;
            ?>
            <select name="categories[]" class="form-control select2" multiple>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ in_array($category->id, $selected) ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label class="control-label">وسائل الدفع</label>
            <div>
                <input type="checkbox" name="store_online_payments" id="store_online_payments" 
                    {{ old('store_online_payments', auth()->user()->store_online_payments) ? 'checked' : '' }}> 
                <label for="store_online_payments">دفع الكتروني</label>

                <input type="checkbox" name="store_cod_payments" id="store_cod_payments" class="mr-3"
                    {{ old('store_cod_payments', auth()->user()->store_cod_payments) ? 'checked' : '' }}> 
                <label for="store_cod_payments">الدفع عند الاستلام</label>
            </div>
        </div>
        <div class="form-group text-right">
            <label class="control-label">صورة غلاف المتجر</label>
            <input class="form-control store-banner" id="store_banner" type="file" accept="image/*" name="store_banner">
        </div>
        <div class="form-group text-right">
            <label class="control-label">شعار المتجر</label>
            <input class="form-control store-logo" id="store_logo" type="file" accept="image/*" name="store_logo">
        </div>
    </div>
    <div class="card-footer">
        <div class="form-group text-left">
            <button type="submit" class="btn btn-primary">حفظ</button>
        </div>
    </div>
</form>