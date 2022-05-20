@extends('admin.layouts.admin')

@section('title', 'تعديل مدينة')

@section('breadcrumb')
	<li class="breadcrumb-item"><a href="/admin/options">صفات المنتجات</a></li>
	<li class="breadcrumb-item"><a href="/admin/options/{{ $option->slug }}/option_values">الاختيارات</a></li>
	<li class="breadcrumb-item active">تعديل اختيار</li>
@endsection

@section('content')
	<div class="card">
		<div class="card-header text-right" dir="rtl">
			<h4> تعديل اختيار </h4>
		</div>
		<div class="card-body text-right" dir="rtl">
			<form action="/admin/option_values/{{ $option_value->slug }}/" method="POST" enctype="multipart/form-data">
            	@csrf()
            	@method('PUT')
				<div class="modal-body" dir="rtl">
                    <div class="form-group">
						<label for="name" class="form-control-label"> الاسم :</label>
						<input type="text" class="form-control" id="name" name="name" value="{{ old('name') ? old('name') : $option_value->name }}" required>
					</div>

					<div class="form-group">
						<label for="preview_config" class="form-control-label"> طريقة العرض :</label>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text">عرض</span>
							</div>

							@php($selected = old('preview_config', $option_value->preview_config))
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

							@php($selected = old('color_config', $option_value->color_config))
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
					<div class="form-group" style="display: none;">
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text">اللون</span>
							</div>
							
							<input type="color" name="color" class="form-control" style="max-width: 100px;" value="{{ $option_value->color }}">
						</div>
					</div>
					<div class="form-group" style="display: none;">
						<label for="preview" class="form-control-label"> Html :</label>
						<textarea name="html" id="html" rows="3" class="form-control text-left" dir="ltr">{{ $option_value->html }}</textarea>
					</div>
					<div class="form-group" id="image-field" style="display: none;">
						<label for="image" class="form-control-label"> صورة الاختيار :</label>
						<input class="form-control" id="image" type="file" accept="image/*" name="image">
					</div>
				</div>
				<div class="modal-footer"> 
					<button type="submit" class="btn btn-primary"> حفظ </button>
				</div> 
            </form>
		</div>
	</div>
@endsection

@section('scripts')
	@include('admin.option_values.partials.update-fields')

	<script type="text/javascript">
		@if($option_value->image)
			var image = '{{ $option_value->option_value_image() }}';
			var fileInputOptions = $.extend(true,{
				initialPreview: [image],
				initialPreviewConfig : [{caption: "Option Value image"}],
				initialPreviewShowDelete: false,
	        	deleteUrl: "/admin/option_value/{{ $option_value->slug }}/delete-image",
			},fileInputOptions);
		@endif

		$("[type=file]").fileinput(fileInputOptions);
	</script>
@endsection
