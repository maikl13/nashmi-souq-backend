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
        <label class="control-label">الدولة</label>
        <select name="country" id="country" class="form-control">
            <option value="">-</option>
            @foreach(App\Models\Country::get() as $country)
                <option value="{{ $country->id }}" {{ Auth::user()->country_id == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label class="control-label">وصف المتجر</label>
        <textarea name="store_description" class="form-control textarea" id="store_description" placeholder="وصف المتجر">{{ old('store_description') ?? Auth::user()->store_description }}</textarea>
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
    <div class="row">
        <div class="col-12 col-xl-6">
            <div class="form-group text-right">
                <label class="control-label">صورة غلاف المتجر</label>
                <input class="form-control store-banner" id="store_banner" type="file" accept="image/*" name="store_banner">
            </div>
        </div>
        <div class="col-12 col-xl-6">
            <div class="form-group text-right">
                <label class="control-label">شعار المتجر</label>
                <input class="form-control store-logo" id="store_logo" type="file" accept="image/*" name="store_logo">
            </div>
        </div>
    </div>
</div>
<div class="card-footer">
    <div class="form-group text-left">
        <button type="submit" class="btn btn-primary">حفظ</button>
    </div>
</div>
