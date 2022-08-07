<div class="card-body">
    <div class="form-group">
        <label class="control-label">البريد الإلكتروني للمتجر</label>
        <input class="form-control" id="store_email" type="text" name="store_email" placeholder="البريد الإلكتروني للمتجر" value="{{ old('store_email') ?? Auth::user()->store_email }}">
    </div>

    <div class="form-group">
        <label class="control-label">رقم الهاتف</label>
        <input class="form-control text-left" style="direction: ltr;" id="store_phone" type="text" name="store_phone" placeholder="رقم الهاتف" value="{{ old('store_phone') ?? Auth::user()->store_phone }}">
    </div>

    <div class="form-group">
        <label class="control-label">رقم الواتساب</label>
        <input class="form-control text-left" style="direction: ltr;" id="store_whatsapp" type="text" name="store_whatsapp" placeholder="رقم الواتساب" value="{{ old('store_whatsapp') ?? Auth::user()->store_whatsapp }}">
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

    <div class="form-group">
        <label class="control-label">عنوان المتجر</label>
        <textarea name="store_address" class="form-control textarea" id="store_address" cols="30" rows="2" placeholder="عنوان المتجر">{{ old('store_address') ?? Auth::user()->store_address }}</textarea>
    </div>
</div>
<div class="card-footer">
    <div class="form-group text-left">
        <button type="submit" class="btn btn-primary">حفظ</button>
    </div>
</div>
