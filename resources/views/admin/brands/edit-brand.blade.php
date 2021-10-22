@extends('admin.layouts.admin')

@section('title', 'تعديل علامة تجارية')

@section('breadcrumb')
	<li class="breadcrumb-item"><a href="/admin/brands">العلامات التجارية</a></li>
	<li class="breadcrumb-item active">تعديل علامة تجارية</li>
@endsection

@section('content')
	<div class="card">
		<div class="card-header text-right" dir="rtl">
			<h4> تعديل علامة تجارية </h4>
		</div>
		<div class="card-body text-right" dir="rtl">
			<form action="/admin/brands/{{ $brand->slug }}/" method="POST" enctype="multipart/form-data">
            	@csrf()
            	@method('PUT')
				<div class="modal-body" dir="rtl">
                    <div class="form-group">
						<label for="name" class="form-control-label"> الاسم :</label>
						<input type="text" class="form-control" id="name" name="name" value="{{ old('name') ? old('name') : $brand->name }}" required>
					</div>
					<div class="form-group">
						<label for="name" class="form-control-label"> الأقسام :</label>
						<select name="categories[]" id="categories" class=" select2" style="width: 100%;" required multiple>
							<option value=""> - </option>
							@foreach (App\Models\Category::whereNull('category_id')->get() as $category)
								<option value="{{ $category->id }}" 
									{{ in_array($category->id, $brand->categories) ? 'selected' : '' }}>{{ $category->name }}</option>
								@foreach ($category->all_children() as $sub_category)
									<?php 
										$prefix = '';
										for ($i=1; $i < $sub_category->level(); $i++) { $prefix .= '___'; }
									?>
									<option value="{{ $sub_category->id }}"
										{{ in_array($sub_category->id, $brand->categories) ? 'selected' : '' }}>{{ $prefix }}{{ $sub_category->name }}</option>
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