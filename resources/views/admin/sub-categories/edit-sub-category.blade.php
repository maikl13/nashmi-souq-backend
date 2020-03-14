@extends('admin.layouts.admin')

@section('breadcrumb')
	<li class="breadcrumb-item"><a href="/admin/categories">الأقسام</a></li>
	<li class="breadcrumb-item"><a href="/admin/categories/{{ $category->slug }}/sub-categories">الأقسام الفرعية</a></li>
	<li class="breadcrumb-item active">تعديل قسم فرعي</li>
@endsection

@section('content')
	<div class="card">
		<div class="card-header text-right" dir="rtl">
			<h4> تعديل القسم الفرعي </h4>
		</div>
		<div class="card-body text-right" dir="rtl">
			<form action="/admin/sub-categories/{{ $sub_category->slug }}/" method="POST" enctype="multipart/form-data">
            	@csrf()
            	@method('PUT')
				<div class="modal-body" dir="rtl">
                    <div class="form-group">
						<label for="name" class="form-control-label"> الاسم :</label>
						<input type="text" class="form-control" id="name" name="name" value="{{ old('name') ? old('name') : $sub_category->name }}" required>
					</div>
                    <div class="form-group">
						<label for="image" class="form-control-label"> الصورة :</label>
						<input type="file" id="image" name="image" value="{{ old('image') }}">
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
	<script type="text/javascript">
		@if($sub_category->image)
			var image = '{{ $sub_category->category_image() }}';
			var fileInputOptions = $.extend(true,{
				initialPreview: [image],
				initialPreviewConfig : [{caption: "sub category image"}],
				initialPreviewShowDelete: false,
	        	deleteUrl: "/admin/sub-categories/{{ $sub_category->slug }}/delete-image",
			},fileInputOptions);
		@endif

		$("[type=file]").fileinput(fileInputOptions);
	</script>
@endsection