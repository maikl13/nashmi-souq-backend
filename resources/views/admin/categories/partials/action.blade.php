<?php $category = App\Models\category::find($id); ?>

@if($category)
	<a href="/admin/categories/{{ $category->slug }}/edit" class="btn btn-sm btn-info" ><i class="fa fa-edit" ></i> </a>
	<button type="button" class="btn btn-sm btn-danger delete" data-id="{{ $category->slug }}"> <i class="fa fa-trash" ></i> </button>
@endif