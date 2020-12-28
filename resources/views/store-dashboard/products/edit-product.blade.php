@extends('store-dashboard.layouts.store-dashboard')

@section('title', 'تعديل المنتج')

@section('breadcrumb')
	<li class="breadcrumb-item"><a href="/dashboard/products">المنتجات</a></li>
	<li class="breadcrumb-item active">تعديل المنتج</li>
@endsection

@section('content')
    <form action="/dashboard/products/{{ $product->slug }}" method="POST" enctype="multipart/form-data" class="card">
        <div class="card-header text-right">
        <h4 class="d-inline float-right">تعديل المنتج</h4>
        </div>
        <div class="card-body text-right" dir="rtl">
            @csrf()
            @method('put')
            <div class="form-group">
                <label for="product_title" class="form-control-label"> الاسم :</label>
                <input type="text" class="form-control text-right" id="product_title" name="product_title" value="{{ old('product_title') ?? $product->title }}" required>
            </div>
            <div class="form-group">
                <label for="price" class="form-control-label"> السعر :</label>
                <div class="input-group mb-3">
                    <input type="number" step=".01" class="form-control" name="price" id="price" value="{{ old('price') ?? $product->price }}">
                    <div class="input-group-prepend">
                        <select name="currency" id="currency" class="form-control" style="padding: 6px 15px !important;height: auto;">
                            @foreach (App\Models\Currency::get() as $currency)
                                <option title="{{ $currency->name }}" value="{{ $currency->id }}"
                                    {{ $product->currency_id == $currency->id ? 'selected' : '' }}>{{ $currency->symbol }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="description" class="form-control-label"> وصف المنتج :</label>
                <textarea name="description" class="form-control textarea" id="description" cols="30" rows="8" required>{!! old('description') ?? $product->description !!}</textarea>
            </div>
            <?php 
                $cat = old('category') ? old('category') : $product->category->slug;
            ?>
            <div class="form-group">
                <label for="category" class="form-control-label"> القسم الرئيسي :</label>
                <select name="category" class="category-select categories-select2 form-control @error('category') is-invalid @enderror" required>
                    <option value="">- قم باختيار القسم التابع له المنتج</option>
                    @foreach( App\Models\Category::whereNull('category_id')->get() as $category )
                        <option value="{{ $category->slug }}" {{ $cat == $category->slug ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            @if( $cat )
                <?php 
                    $category = App\Models\Category::where('slug', $cat)->first(); 
                    $sub_categories_count = 0;
                    if($category) $sub_categories_count = $category->children()->count();
                    if($product->sub_category) $sub_cat = $product->sub_category->slug;
                    if(old('sub_category')) $sub_cat = old('sub_category');
                ?>
            @endif
            <div class="form-group">
                <label for="product_title" class="form-control-label"> القسم الفرعي :</label>
                <select name="sub_category" class="sub-category-select sub-categories-select2 form-control @error('sub_category') is-invalid @enderror" {{ isset($sub_categories_count) && $sub_categories_count ? '' : 'disabled' }}>
                    <option value="">- إختر القسم الفرعي</option>
                    @if ( isset($sub_categories_count) && $sub_categories_count )
                        @foreach ($category->all_children() as $sub_category)
                            @php
                                $prefix = '';
                                for ($i=2; $i < $sub_category->level(); $i++) { $prefix .= '___'; }
                            @endphp
                            <option value="{{ $sub_category->slug }}" {{ $sub_cat == $sub_category->slug ? 'selected' : '' }}>{{ $prefix }} {{ $sub_category->name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="form-group">
                <label for="images" class="form-control-label"> صور المنتج :</label>
                <div class="img-gallery">
                    <input class="form-control images" id="images" type="file" accept="image/*" name="images[]" multiple>
                    <div class="img-upload-instruction alert alert-danger mt-3" style="opacity: .7;"><small>الحد الأقصى لحجم الصور <span dir="ltr">8 MB</span>.</small></div>
                </div>
            </div>
        </div>
    
        <div class="card-footer"> 
            <button type="submit" class="btn btn-primary"> حفظ </button>
            <button type="button" class="btn btn-success" data-dismiss="modal"> تراجع </button>
        </div> 
    </form>
@endsection

@section('scripts')
    <script>
        @if($product->images && json_decode($product->images))
            var images = {!! json_encode($product->product_images(['size'=>'xs'])) !!};
            var fileInputOptions = $.extend(true,{
                initialPreview: images,
                initialPreviewConfig : [
                    @foreach(json_decode($product->images) as $key => $image)
                        {caption: "Product Image {{ $key+1 }}", key: "{{ $image }}" },
                    @endforeach
                ],
                initialPreviewShowDelete: false,
                deleteUrl: "/dashboard/products/{{ $product->slug }}/delete-image",
                overwriteInitial: false
            },fileInputOptions);
        @endif

        $("[type=file]").fileinput(fileInputOptions);
    </script>

    <script src="/assets/plugins/select2/dependent-select2.js"></script>
    <script src="/assets/plugins/select2/model-matcher.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.categories-select2').select2({ placeholder: "القسم الرئيسي ... *" });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            var CategoriesSelect2Options = { placeholder: "القسم الرئيسي ... *" };
            var subCategoriesSelect2Options = { placeholder: "القسم الفرعي ..." };
            var subCategoriesApiUrl =  '/api/categories/:parentId:/sub-categories';
            $('.sub-categories-select2').select2(subCategoriesSelect2Options);
            var cascadLoadingSubCategories = new Select2Cascade($('.category-select'), $('.sub-category-select'), subCategoriesApiUrl, CategoriesSelect2Options, subCategoriesSelect2Options);
        });
    </script>
@endsection