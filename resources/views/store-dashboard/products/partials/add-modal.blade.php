{{-- Add Category Modal --}}
<div class="modal fade" id="add-modal" tabindex="-1" role="dialog"  aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content text-right">
			<div class="modal-header">
				<h5 class="modal-title"> إضافة منتج جديد </h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
            <form action="/admin/products/" method="POST" enctype="multipart/form-data" class="add">
            	@csrf()
				<div class="modal-body" dir="rtl">
                    <div class="form-group">
						<label for="product_title" class="form-control-label"> الاسم :</label>
						<input type="text" class="form-control text-right" id="product_title" name="product_title" value="{{ old('product_title') }}" required>
					</div>
                    <div class="form-group">
						<label for="price" class="form-control-label"> السعر :</label>
						<div class="input-group mb-3">
							<input type="number" step=".01" class="form-control" name="price" id="price" value="{{ old('price') }}">
							<div class="input-group-prepend">
								<select name="currency" id="currency" class="form-control" style="padding: 6px 15px !important;height: auto;">
									@foreach (App\Models\Currency::get() as $currency)
										<option title="{{ $currency->name }}" value="{{ $currency->id }}">{{ $currency->symbol }}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
                    <div class="form-group">
						<label for="description" class="form-control-label"> وصف المنتج :</label>
						<textarea name="description" class="form-control textarea" id="description" cols="30" rows="8" required>{!! old('description') !!}</textarea>
					</div>
                    <div class="form-group">
						<label for="category" class="form-control-label"> القسم الرئيسي :</label>
						<select name="category" class="category-select categories-select2 form-control @error('category') is-invalid @enderror" required>
							<option value="">- قم باختيار القسم التابع له المنتج</option>
							@foreach( App\Models\Category::whereNull('category_id')->get() as $category )
								<option value="{{ $category->slug }}" {{ old('category') == $category->slug ? 'selected' : '' }}>{{ $category->name }}</option>
							@endforeach
						</select>
					</div>
					@if( old('category') )
						<?php 
							$category = App\Models\Category::where( 'slug', old('category') )->first(); 
							$sub_categories_count = 0;
							if($category) $sub_categories_count = $category->children()->count()
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
									<option value="{{ $sub_category->slug }}" {{ old('sub_category') == $sub_category->slug ? 'selected' : '' }}>{{ $prefix }} {{ $sub_category->name }}</option>
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
				<div class="modal-footer"> 
					<button type="submit" class="btn btn-primary"> حفظ </button>
                    <button type="button" class="btn btn-success" data-dismiss="modal"> تراجع </button>
				</div> 
            </form>
		</div>
	</div>
</div>	