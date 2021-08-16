<div class="form-group">
    <label for="initial_price" class="form-control-label"> السعر :</label>
    <div class="input-group mb-3">
        <input type="number" step=".01" class="form-control" name="initial_price" id="initial_price" value="{{ old('initial_price') }}">
        <div class="input-group-prepend">
            <select name="currency" id="currency" class="form-control" style="padding: 6px 15px !important;height: auto; border-radius: 0;">
                @foreach (App\Models\Currency::get() as $currency)
                    <option title="{{ $currency->name }}" value="{{ $currency->id }}">{{ $currency->symbol }}</option>
                @endforeach
            </select>
            <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" style="border-radius: 5px 0 0 5px; opacity: .8;">
                إضافة خصم
            </a>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="collapse" id="collapseExample">
        <div class="card card-body">
            <label for="price" class="form-control-label"> السعر بعد الخصم :</label>
            <input type="number" step=".01" class="form-control" name="price" id="price" value="{{ old('price') }}">
        </div>
    </div>
</div>

<div class="form-group options-container" style="display: none">
    <label for="images" class="form-control-label"> الصفات العامة للمنتج :</label>
    <div class="options form-group mb-0" dir="ltr">
        <button class="btn btn-primary btn-sm add-option" data-option-value-name="option_values[]" data-option-name="options[]">
            <i class="fa fa-plus py-2"></i> إضافة صفة للمنتج
        </button>
    </div>
</div>

<div class="form-group mb-0">
    <label for="images" class="form-control-label"> صور المنتج :</label>
    <div class="img-gallery">
        <input class="form-control images" id="images" type="file" accept="image/*" name="images[]" multiple>
    </div>
</div>