@extends('main.layouts.main')

@section('title', 'تعديل اعلان')

@section('head')
    <link href="/assets/plugins/select2/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    <!--=====================================-->
    <!--=        Inner Banner Start         =-->
    <!--=====================================-->
    <section class="inner-page-banner" data-bg-image="/assets/images/banner/banner1.jpg">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumbs-area">
                        <h1>تعديل اعلان - {{ $listing->title }}</h1>
                        <ul>
                            <li> <a href="/">الرئيسية</a> </li>
                            <li> <a href="/listings">الإعلانات</a> </li>
                            <li>تعديل اعلان</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!--=====================================-->
    <!--=        Post Add Start             =-->
    <!--=====================================-->
    <section class="section-padding-equal-70">
        <div class="container">
            <div class="post-ad-box-layout1 light-shadow-bg">
                <div class="post-ad-form light-box-content">
                    <form action="{{ $listing->url() }}" method="post" enctype="multipart/form-data" class="ajax">
                        @csrf
                        @method('PUT')
                        <div class="post-section post-information">
                            <div class="post-ad-title">
                                <i class="fas fa-folder-open"></i>
                                <h3 class="item-title">معلومات الإعلان الأساسية</h3>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <label class="control-label">إسم الإعلان <span>*</span></label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="title" id="post-title" value="{{ old('title') ? old('title') : $listing->title }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <label class="control-label">نوع الإعلان <span>*</span></label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <select name="type" id="type" class="form-control">
                                            <option value="{{ App\Models\Listing::TYPE_SELL }}" {{ $listing->type == App\Models\Listing::TYPE_SELL ? 'selected' : '' }}>بيع</option>
                                            <option value="{{ App\Models\Listing::TYPE_BUY }}" {{ $listing->type == App\Models\Listing::TYPE_BUY ? 'selected' : '' }}>شراء</option>
                                            <option value="{{ App\Models\Listing::TYPE_EXCHANGE }}" {{ $listing->type == App\Models\Listing::TYPE_EXCHANGE ? 'selected' : '' }}>استبدال</option>
                                            <option value="{{ App\Models\Listing::TYPE_JOB }}" {{ $listing->type == App\Models\Listing::TYPE_JOB ? 'selected' : '' }}>وظيفة</option>
                                            <option value="{{ App\Models\Listing::TYPE_RENT }}" {{ $listing->type == App\Models\Listing::TYPE_RENT ? 'selected' : '' }}>تأجير</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <label class="control-label">وصف الإعلان <span>*</span></label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <textarea name="description" class="form-control textarea" id="description" cols="30" rows="8" required>{!! old('description') ? old('description') : $listing->description !!}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="post-section post-category mb-4">
                            <div class="post-ad-title">
                                <i class="fas fa-tags"></i>
                                <h3 class="item-title">القسم</h3>
                            </div>
                            <?php 
                                $cat = old('category') ? old('category') : $listing->category->slug;
                            ?>
                            <div class="row">
                                <div class="col-sm-3">
                                    <label class="control-label">القسم الرئيسي <span>*</span></label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <select name="category" class="category-select categories-select2 form-control @error('category') is-invalid @enderror" required>
                                            <option value="">- قم باختيار القسم التابع له الاعلان</option>
                                            @foreach( App\Models\Category::get() as $category )
                                                <option value="{{ $category->slug }}" {{ $cat == $category->slug ? 'selected' : '' }}>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @if( $cat )
                                <?php 
                                    $category = App\Models\Category::where('slug', $cat)->first(); 
                                    $sub_categories_count = 0;
                                    if($category) $sub_categories_count = $category->sub_categories()->count();
                                    if($listing->sub_category) $sub_cat = $listing->sub_category->slug;
                                    if(old('sub_category')) $sub_cat = old('sub_category');
                                ?>
                            @endif
                            <div class="row">
                                <div class="col-sm-3">
                                    <label class="control-label">القسم الفرعي <span>*</span></label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <select name="sub_category" class="sub-category-select sub-categories-select2 form-control @error('sub_category') is-invalid @enderror" {{ isset($sub_categories_count) && $sub_categories_count ? '' : 'disabled' }}>
                                            <option value="">- إختر القسم الفرعي</option>
                                            @if ( isset($sub_categories_count) && $sub_categories_count )
                                                @foreach ($category->sub_categories()->get() as $sub_category)
                                                    <option value="{{ $sub_category->slug }}" {{ $sub_cat == $sub_category->slug ? 'selected' : '' }}>{{ $sub_category->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="post-section post-category mb-4">
                            <div class="post-ad-title">
                                <i class="fas fa-tags"></i>
                                <h3 class="item-title">الموقع</h3>
                            </div>
                            <?php 
                                $s = old('state') ? old('state') : $listing->state->slug;
                            ?>
                            <div class="row">
                                <div class="col-sm-3">
                                    <label class="control-label">المحافظة</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <select name="state" class="state-select states-select2 form-control @error('state') is-invalid @enderror" required>
                                            <option value="">- اختر المحافظة <span>*</span></option>
                                            @if (country() && country()->id != $listing->country_id)
                                                <option value="{{ $listing->state->slug }}" selected>{{ $listing->state->name }}</option>
                                            @endif
                                            @if (country())
                                                @foreach( country()->states as $state)
                                                    <option value="{{ $state->slug }}" {{ $s == $state->slug ? 'selected' : '' }}>{{ $state->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @if( $s )
                                <?php 
                                    $state = App\Models\State::where('slug', $s)->first(); 
                                    $areas_count = 0;
                                    if($state) $areas_count = $state->areas()->count();
                                    if($listing->area) $a = $listing->area->slug;
                                    if(old('area')) $a = old('area');
                                ?>
                            @endif
                            <div class="row">
                                <div class="col-sm-3">
                                    <label class="control-label">المنطقة <span>*</span></label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <select name="area" class="area-select areas-select2 form-control @error('area') is-invalid @enderror" {{ isset($areas_count) && $areas_count ? '' : 'disabled' }}>
                                            <option value="">- إختر المنطقة</option>
                                            @if ( isset($areas_count) && $areas_count )
                                                @foreach ($state->areas()->get() as $area)
                                                    <option value="{{ $area->slug }}" {{ $a == $area->slug ? 'selected' : '' }}>{{ $area->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <label class="control-label">العنوان تفصيلي</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="address" id="post-address" value="{{ old('address') ? old('address') : $listing->address }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="post-section post-img mb-4">
                            <div class="post-ad-title">
                                <i class="far fa-image"></i>
                                <h3 class="item-title">صور الإعلان</h3>
                            </div>
                            <div class="form-group">
                                <div class="img-gallery">
                                    <input class="form-control images" id="images" type="file" accept="image/*" name="images[]" multiple>
                                    <div class="img-upload-instruction alert alert-danger mt-3"><small>الحد الأقصى لحجم الصور <span dir="ltr">8 MB</span>.</small></div>
                                </div>
                            </div>
                        </div>
                        <div class="post-section">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group text-left">
                                        <button type="submit" class="submit-btn">نشر الإعلان</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="/assets/plugins/select2/select2.min.js"></script>
    <script src="/assets/plugins/select2/dependent-select2.js"></script>
    <script src="/assets/plugins/select2/model-matcher.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.categories-select2').select2({ placeholder: "القسم الرئيسي ... *", allowClear: true });
            $('.states-select2').select2({
                placeholder: "موقع الإعلان ... *", matcher: modelMatcher, allowClear: true
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            var CategoriesSelect2Options = { placeholder: "القسم الرئيسي ... *", allowClear: true };
            var subCategoriesSelect2Options = { placeholder: "القسم الفرعي ...", allowClear: true };
            var subCategoriesApiUrl =  '/api/categories/:parentId:/sub-categories';
            $('.sub-categories-select2').select2(subCategoriesSelect2Options);
            var cascadLoadingSubCategories = new Select2Cascade($('.category-select'), $('.sub-category-select'), subCategoriesApiUrl, CategoriesSelect2Options, subCategoriesSelect2Options);


            var StatesSelect2Options = { placeholder: "اختر المحافظة ... *", allowClear: true };
            var AreasSelect2Options = { placeholder: "اختر المنطقة ...", allowClear: true };
            var AreasApiUrl =  '/api/states/:parentId:/areas';
            $('.areas-select2').select2(AreasSelect2Options);
            var cascadLoadingSubCategories = new Select2Cascade($('.state-select'), $('.area-select'), AreasApiUrl, StatesSelect2Options, AreasSelect2Options);
        });
    </script>


    <script src="/assets/js/ajax/ajax.js"></script>

    <script>
        @if($listing->images && json_decode($listing->images))
            var images = {!! json_encode($listing->listing_images()) !!};
            var fileInputOptions = $.extend(true,{
                initialPreview: images,
                initialPreviewConfig : [
                    @foreach(json_decode($listing->images) as $key => $image)
                        {caption: "Listing Image {{ $key+1 }}", key: "{{ $image }}" },
                    @endforeach
                ],
                initialPreviewShowDelete: false,
                deleteUrl: "/listings/{{ $listing->slug }}/delete-image",
                overwriteInitial: false
            },fileInputOptions);
        @endif

        $("[type=file]").fileinput(fileInputOptions);
    </script>
@endsection