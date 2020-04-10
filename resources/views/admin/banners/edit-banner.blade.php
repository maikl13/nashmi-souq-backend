@extends('admin.layouts.admin')

@section('head')
	<style> .kv-file-remove {display: none;} </style>
@endsection

@section('breadcrumb')
	<li class="breadcrumb-item"><a href="/admin/banners">البانرات الإعلانية</a></li>
	<li class="breadcrumb-item active">تعديل بانر إعلاني</li>
@endsection

@section('content')
	<div class="card">
		<div class="card-header text-right" dir="rtl">
			<h4> تعديل القسم </h4>
		</div>
		<div class="card-body text-right" dir="rtl">
			<form action="/admin/bs/{{ $banner->id }}/" method="POST" enctype="multipart/form-data">
            	@csrf()
            	@method('PUT')
				<div class="modal-body" dir="rtl">
                    <div class="form-group">
						<label for="type" class="form-control-label"> النوع :</label>
						<select name="type" id="type" class="form-control" required dir="ltr">
							<option value="{{ App\Models\Banner::TYPE_LARGE_RECTANGLE }}" {{ $banner->type == App\Models\Banner::TYPE_LARGE_RECTANGLE ? 'selected' : '' }}>
								Large Rectangle - 336x280
							</option>
							<option value="{{ App\Models\Banner::TYPE_LEADERBOARD }}" {{ $banner->type == App\Models\Banner::TYPE_LEADERBOARD ? 'selected' : '' }}>
								Leaderboard - 728x90
							</option>
							<option value="{{ App\Models\Banner::TYPE_LARGE_LEADERBOARD }}" {{ $banner->type == App\Models\Banner::TYPE_LARGE_LEADERBOARD ? 'selected' : '' }}>
								Large Leaderboard - 970x90
							</option>
							<option value="{{ App\Models\Banner::TYPE_MOBILE_BANNER }}" {{ $banner->type == App\Models\Banner::TYPE_MOBILE_BANNER ? 'selected' : '' }}>
								Mobile Banner - 320x50
							</option>
						</select>
					</div>
                    <div class="form-group">
						<label for="url" class="form-control-label"> الرابط :</label>
						<input type="text" class="form-control text-right" id="url" name="url" value="{{ old('url') ? old('url') : $banner->url }}" required>
					</div>
                    <div class="form-group">
						<label for="period" class="form-control-label"> المدة (بالأيام) :</label>
						<input type="number" class="form-control text-right" id="period" name="period" value="{{ old('period') ? old('period') : $banner->period }}" required>
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
		@if($banner->image)
			var image = '{{ $banner->banner_image() }}';
			var fileInputOptions = $.extend(true,{
				initialPreview: [image],
				initialPreviewConfig : [{caption: "banner image"}],
			},fileInputOptions);
		@endif

		$("[type=file]").fileinput(fileInputOptions);
	</script>
@endsection