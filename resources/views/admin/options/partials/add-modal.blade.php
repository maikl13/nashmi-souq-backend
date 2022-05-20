<div class="modal fade" id="add-modal" tabindex="-1" role="dialog"  aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content text-right">
			<div class="modal-header">
				<h5 class="modal-title"> اضافة صفة للمنتجات </h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>


			<form action="/admin/options/" method="POST" enctype="multipart/form-data" class="add">
				@csrf()
				<div class="modal-body" dir="rtl">
					<div class="form-group">
						<label for="name" class="form-control-label"> الاسم :</label>
						<input type="text" class="form-control text-right" id="name" name="name" value="{{ old('name') }}" required>
					</div>
					<div class="form-group">
						<label for="name" class="form-control-label"> الأقسام :</label>
						<select name="categories[]" id="categories" class="select2" style="width: 100%;" required multiple>
							<option value=""> - </option>
							@foreach (App\Models\Category::whereNull('category_id')->get() as $category)
								<option value="{{ $category->id }}">{{ $category->name }}</option>
								@foreach ($category->all_children() as $sub_category)
									<?php 
										$prefix = '';
										for ($i=1; $i < $sub_category->level(); $i++) { $prefix .= '___'; }
									?>
									<option value="{{ $sub_category->id }}">{{ $prefix }}{{ $sub_category->name }}</option>
								@endforeach
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label for="preview_config" class="form-control-label"> طريقة العرض :</label>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text">عرض</span>
							</div>

							@php($selected = old('preview_config'))
							<select name="preview_config" id="preview_config" class="form-control">
								<option value="{{ $preview_config = \App\Models\Option::PREVIEW_NAME }}" 
									{{ $selected == $preview_config ? 'selected' : '' }}>الاسم</option>
								<option value="{{ $preview_config = \App\Models\Option::PREVIEW_NONE }}" 
									{{ $selected == $preview_config ? 'selected' : '' }}>لا شيء</option>
								<option value="{{ $preview_config = \App\Models\Option::PREVIEW_HTML }}" 
									{{ $selected == $preview_config ? 'selected' : '' }}>Html</option>
								<option value="{{ $preview_config = \App\Models\Option::PREVIEW_PRODUCT_IMAGE }}" 
									{{ $selected == $preview_config ? 'selected' : '' }}>صورة المنتج</option>
								<option value="{{ $preview_config = \App\Models\Option::PREVIEW_FIXED_IMAGE }}" 
									{{ $selected == $preview_config ? 'selected' : '' }}>صورة ثابتة</option>
							</select>
						</div>

						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text">اللون </span>
							</div>

							@php($selected = old('color_config'))
							<select name="color_config" id="color_config" class="form-control">
								<option value="{{ $color_config = \App\Models\Option::COLOR_DEFAULT }}" 
									{{ $selected == $color_config ? 'selected' : '' }}>الإفتراضي</option>
								<option value="{{ $color_config = \App\Models\Option::COLOR_CUSTOM }}" 
									{{ $selected == $color_config ? 'selected' : '' }}>مخصص</option>
							</select>
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
