{{-- Add Category Modal --}}
<div class="modal fade" id="add-modal" tabindex="-1" role="dialog"  aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content text-right">
			<div class="modal-header">
				<h5 class="modal-title"> اضافة إختيار جديد </h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
            <form action="/admin/option_values/" method="POST" enctype="multipart/form-data" class="add">
            	@csrf()
            	<input type="hidden" name="option_id" value="{{ $option->id }}">
				<div class="modal-body" dir="rtl">
                    <div class="form-group">
						<label for="name" class="form-control-label"> الاسم :</label>
						<input type="text" class="form-control text-right" id="name" name="name" value="{{ old('name') }}" required>
					</div>
					<div class="form-group">
						<label for="preview_config" class="form-control-label"> طريقة العرض :</label>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text">عرض</span>
							</div>

							@php($selected = old('preview_config', $option->preview_config))
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

							@php($selected = old('color_config', $option->color_config))
							<select name="color_config" id="color_config" class="form-control">
								<option value="{{ $color_config = \App\Models\Option::COLOR_DEFAULT }}" 
									{{ $selected == $color_config ? 'selected' : '' }}>الإفتراضي</option>
								<option value="{{ $color_config = \App\Models\Option::COLOR_CUSTOM }}" 
									{{ $selected == $color_config ? 'selected' : '' }}>مخصص</option>
							</select>
						</div>
					</div>
				</div>
				<div class="modal-body py-0" dir="rtl">
					<div class="form-group my-1" style="display: none;">
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text">اللون</span>
							</div>
							
							<input type="color" name="color" class="form-control" style="max-width: 100px;">
						</div>
					</div>
					<div class="form-group my-1" style="display: none;">
						<label for="preview" class="form-control-label"> Html :</label>
						<textarea name="html" id="html" rows="3" class="form-control text-left" dir="ltr" style="direction: ltr;"></textarea>
					</div>
					<div class="form-group my-1" id="image-field" style="display: none;">
						<label for="image" class="form-control-label"> صورة الاختيار :</label>
						<input class="form-control" id="image" type="file" accept="image/*" name="image">
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