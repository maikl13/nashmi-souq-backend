<?php $category = App\Models\Category::find($id); ?>

@if($category)
	<a href="#" data-toggle="modal" data-target="#add-modal" class="btn btn-sm btn-info add-sub-category" data-id="{{ $category->id }}">
		<i class="fa fa-plus"></i>
		الأقسام الفرعية ({{ $category->children()->count() }})
	</a>
	
	<a href="/admin/categories/{{ $category->slug }}/edit" class="btn btn-sm btn-info" ><i class="fa fa-edit" ></i> </a>
	<button type="button" class="btn btn-sm btn-danger delete" data-id="{{ $category->slug }}"> <i class="fa fa-trash" ></i> </button>
@endif