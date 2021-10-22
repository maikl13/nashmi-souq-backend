@extends('main.layouts.main')

@section('title', 'نشر اعلان جديد')

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
                        <h1>نشر اعلان جديد</h1>
                        <ul>
                            <li> <a href="/">الرئيسية</a> </li>
                            <li> <a href="/listings">الإعلانات</a> </li>
                            <li>اعلان جديد</li>
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
                    <form action="/listings" method="post" enctype="multipart/form-data" class="ajax ashould-reset">
                        @csrf
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
                                        <input type="text" class="form-control" name="listing_title" id="post-title" value="{{ old('listing_title') ? old('listing_title') : '' }}" required>
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
                                            <option value="{{ App\Models\Listing::TYPE_SELL }}">بيع</option>
                                            <option value="{{ App\Models\Listing::TYPE_BUY }}">شراء</option>
                                            <option value="{{ App\Models\Listing::TYPE_EXCHANGE }}">استبدال</option>
                                            <option value="{{ App\Models\Listing::TYPE_RENT }}">تأجير</option>
                                            <option value="{{ App\Models\Listing::TYPE_JOB }}">عرض وظيفة</option>
                                            <option value="{{ App\Models\Listing::TYPE_JOB_REQUEST }}">طلب وظيفة</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <label class="control-label">السعر</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <div class="input-group mb-3">
                                            <input type="number" step=".01" class="form-control" name="price" id="price" value="{{ old('price') ? old('price') : '' }}">
                                            <div class="input-group-prepend">
                                                <select name="currency" id="currency" class="form-control">
                                                    @foreach (App\Models\Currency::get() as $currency)
                                                        <option title="{{ $currency->name }}" value="{{ $currency->id }}">{{ $currency->symbol }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="display: none;">
                                <div class="col-sm-3">
                                    <label class="control-label">السن</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <input type="number" class="form-control" name="age" id="age" value="{{ old('age') ? old('age') : '' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="display: none;">
                                <div class="col-sm-3">
                                    <label class="control-label">الجنس</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <select name="gender" id="gender" class="form-control">
                                            <option value="male">ذكر</option>
                                            <option value="female">أنثى</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="display: none;">
                                <div class="col-sm-3">
                                    <label class="control-label">المؤهل</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="qualification" id="qualification" value="{{ old('qualification') ? old('qualification') : '' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="display: none;">
                                <div class="col-sm-3">
                                    <label class="control-label">المهارات</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <textarea class="form-control" name="skills" id="skills">{{ old('skills') ? old('skills') : '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <label class="control-label">وصف الإعلان <span>*</span></label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <textarea name="description" class="form-control textarea" id="description" cols="30" rows="4" required>{!! old('description') ? old('description') : '' !!}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="post-section post-category mb-4">
                            <div class="post-ad-title">
                                <i class="fas fa-tags"></i>
                                <h3 class="item-title">القسم</h3>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <label class="control-label">القسم الرئيسي <span>*</span></label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <select name="category" class="category-select categories-select2 form-control @error('category') is-invalid @enderror" required>
                                            <option value="">- قم باختيار القسم التابع له الاعلان</option>
                                            @foreach( App\Models\Category::whereNull('category_id')->get() as $category )
                                                <option value="{{ $category->slug }}" {{ old('category') == $category->slug ? 'selected' : '' }}>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @if( old('category') )
                                <?php 
                                    $category = App\Models\Category::where( 'slug', old('category') )->first(); 
                                    $sub_categories_count = 0;
                                    if($category) $sub_categories_count = $category->children()->count()
                                ?>
                            @endif
                            <div class="row">
                                <div class="col-sm-3">
                                    <label class="control-label">القسم الفرعي <span>*</span></label>
                                </div>
                                <div class=" col-sm-9">
                                    <div class="form-group">
                                        <select name="sub_category" class="sub-category-select sub-categories-select2 form-control @error('sub_category') is-invalid @enderror" {{ isset($sub_categories_count) && $sub_categories_count ? '' : 'disabled' }}>
                                            <option value="">- إختر القسم الفرعي</option>
                                            @if ( isset($sub_categories_count) && $sub_categories_count )
                                                @foreach ($category->all_children() as $sub_category)
                                                    @php
                                                        $prefix = '';
                                                        for ($i=2; $i < $sub_category->level(); $i++) { $prefix .= '___'; }
                                                    @endphp
                                                    <option value="{{ $sub_category->slug }}" {{ old('sub_category') == $sub_category->slug ? 'selected' : '' }}>{{ $prefix }} {{ $sub_category->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row brands-container" style="display: none;">
                                <div class="col-sm-3">
                                    <label class="control-label">العلامة التجارية</label>
                                </div>
                                <div class=" col-sm-9">
                                    <div class="form-group brand-select-container">
                                    </div>
                                </div>
                            </div>

                            <div class="row models-container" style="display: none;">
                                <div class="col-sm-3">
                                    <label class="control-label">الموديل</label>
                                </div>
                                <div class=" col-sm-9">
                                    <div class="form-group models-select-container">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="post-section post-category mb-4 options-container" style="display: none;">
                            <div class="post-ad-title">
                                <i class="fas fa-tags"></i>
                                <h3 class="item-title" style="flex: auto;">صفات المنتج</h3>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">                                    
                                    <div class="options form-group mb-0" dir="ltr">
                                        <div class="option input-group mb-2 d-none" dir="rtl">
                                            <div class="col-sm-3">
                                                <label class="option-name"></label>
                                            </div>
                                            <div class="col-sm-9">
                                                <div class="form-group mb-3">
                                                    <select class="form-control option-value" name="option_values[]" dir="rtl" disabled>
                                                        <option value="">-</option>
                                                        @foreach (App\Models\OptionValue::orderBy('name')->get() as $option_value)
                                                            <option value="{{ $option_value->id }}" class="d-none"
                                                                data-option="{{ $option_value->option->id }}">{{ $option_value->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="post-section post-category mb-4">
                            <div class="post-ad-title">
                                <i class="fas fa-map-marker-alt"></i>
                                <h3 class="item-title">الموقع</h3>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <label class="control-label">المحافظة</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <select name="state" class="state-select states-select2 form-control @error('state') is-invalid @enderror" required>
                                            <option value="">- اختر المحافظة <span>*</span></option>
                                            @if (country())
                                                @foreach( country()->states as $state)
                                                    <option value="{{ $state->slug }}" {{ old('state') == $state->slug ? 'selected' : '' }}>{{ $state->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @if( old('state') )
                                <?php 
                                    $state = App\Models\State::where( 'slug', old('state') )->first(); 
                                    $areas_count = 0;
                                    if($state) $areas_count = $state->areas()->count()
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
                                                    <option value="{{ $area->slug }}" {{ old('area') == $area->slug ? 'selected' : '' }}>{{ $area->name }}</option>
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
                                        <input type="text" class="form-control" name="address" id="post-address" value="{{ old('address') ? old('address') : '' }}">
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
                        <div class="progress d-none" dir="ltr">
                            <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
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
        $("[type=file]").fileinput(fileInputOptions);
    </script>

    <script>
        $(document).on('change', '#type', function(e){
            var type = $('#type').val();
            if(type == {{ App\Models\Listing::TYPE_SELL }} || type == {{ App\Models\Listing::TYPE_BUY }} || type == {{ App\Models\Listing::TYPE_RENT }}){
                $('#price').parents('.row').show()
            } else {
                $('#price').parents('.row').hide()
            }
            if(type == {{ App\Models\Listing::TYPE_JOB }} || type == {{ App\Models\Listing::TYPE_JOB_REQUEST }} ){
                $('#age').parents('.row').show();
                $('#gender').parents('.row').show();
                $('#qualification').parents('.row').show();
                $('#skills').parents('.row').show();
            } else {
                $('#age').parents('.row').hide();
                $('#gender').parents('.row').hide();
                $('#qualification').parents('.row').hide();
                $('#skills').parents('.row').hide();
            }
        })
    </script>

    <script>
        $(document).on('change', '.category-select', function(){
			$('sub-category-select').val('');
		});

        $(document).on('change', '.category-select, .sub-category-select', function(){
            setTimeout(function(){
    			load_options();
    			load_brands();
            }, 100);
		});

		function load_options() {
			var subCategorySlug = $('.sub-category-select').val();
			var categorySlug = $('.category-select').val();
			var categorySlug = subCategorySlug ? subCategorySlug : categorySlug;

			$.get({
				url: '/api/categories/'+categorySlug+'/options-list',
				success: function(data) {
					if (data) {
                        $(".option:not('.d-none')").remove();
						$('.options-container').show();
                        $.each(data, function (index, value) {
                            var option = $(".option.d-none").clone().removeClass('d-none');
                            option.find('.option-name').text(value.name)
                            option.find('select').each(function (index, element) {
                                $(element).attr('disabled', false);
                            });
                            option.insertBefore($('.option.d-none'));
                            option.find('.option-value option[data-option='+value.id+']').removeClass('d-none');
                        });

					} else {
						$('.options-container').hide();
					}
				}
			})
		}

		function load_brands() {
            $('.models-container').hide();
            $('.models-select-container').html('');

			var subCategorySlug = $('.sub-category-select').val();
			var categorySlug = $('.category-select').val();
			var categorySlug = subCategorySlug ? subCategorySlug : categorySlug;

			$.get({
				url: '/api/categories/'+categorySlug+'/brands',
				success: function(data) {
					if (data) {
						$('.brands-container').show();
                        $('.brand-select-container').html(data);
                        $('.brand-select-container select').select2();
					} else {
                        $('.brands-container').hide();
                        $('.brand-select-container').html('');
                    }
				}
			})
		}

        $(document).on('change', '.brands-container .brand-select', function(){
            setTimeout(function(){
                load_models();
            }, 100);
        });

		function load_models() {
			var brand = $('.brand-select').val();

			$.get({
				url: '/api/brands/'+brand+'/models',
				success: function(data) {
					if (data) {
						$('.models-container').show();
                        $('.models-select-container').html(data);
                        $('.models-select-container select').select2();
					} else {
                        $('.models-container').hide();
                        $('.models-select-container').html('');
                    }
				}
			})
		}

		$(document).on('change', '.option-name', function(){
			var option = $(this).val(),
				optionValue = $(this).parents('.option').find('.option-value');
			optionValue.find('option:selected').removeAttr('selected');
			optionValue.find('option:selected').prop('selected', false);
			optionValue.find('option:not(:first-child)').addClass('d-none');
            if(option)
                optionValue.find('option[data-option='+option+']').removeClass('d-none');
		});
	</script>
@endsection