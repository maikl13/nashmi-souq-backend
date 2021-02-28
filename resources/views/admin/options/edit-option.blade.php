@extends('admin.layouts.admin')

@section('title', 'تعديل صفة')

@section('head')

@endsection

@section('breadcrumb')
	<li class="breadcrumb-item"><a href="/admin/options">الدول</a></li>
	<li class="breadcrumb-item active">تعديل دولة</li>
@endsection

@section('content')
	<div class="card">
		<div class="card-header text-right" dir="rtl">
			<h4> تعديل صفة </h4>
		</div>
		<div class="card-body text-right" dir="rtl">
			<form action="/admin/options/{{ $option->slug }}/" method="POST" enctype="multipart/form-data">
            	@csrf()
            	@method('PUT')
				<div class="modal-body" dir="rtl">
                    <div class="form-group">
						<label for="name" class="form-control-label"> الاسم :</label>
						<input type="text" class="form-control" id="name" name="name" value="{{ old('name') ? old('name') : $option->name }}" required>
					</div>
					<div class="form-group">
						<label for="name" class="form-control-label"> الأقسام :</label>
						<select name="categories[]" id="categories" class=" select2" style="width: 100%;" required multiple>
							<option value=""> - </option>
							@foreach (App\Models\Category::whereNull('category_id')->get() as $category)
								<option value="{{ $category->id }}" 
									{{ in_array($category->id, $option->categories) ? 'selected' : '' }}>{{ $category->name }}</option>
								@foreach ($category->all_children() as $sub_category)
									<?php 
										$prefix = '';
										for ($i=1; $i < $sub_category->level(); $i++) { $prefix .= '___'; }
									?>
									<option value="{{ $sub_category->id }}"
										{{ in_array($sub_category->id, $option->categories) ? 'selected' : '' }}>{{ $prefix }}{{ $sub_category->name }}</option>
								@endforeach
							@endforeach
						</select>
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
	<script src="/admin-assets/plugins/option-picker-flags/build/js/optionSelect.min.js" type="text/javascript"r></script>
	<script> 
		$("#option").optionSelect({
			defaultOption: "{{ $option->code }}",
			preferredOptions: ['eg','sa','kw','jo','ae','sy','sd','tn','dz','ma','iq','ye','lb','ly','om','mr','qa','so','bh','dj','km','ps'],
			responsiveDropdown: true
		});
	</script>
@endsection