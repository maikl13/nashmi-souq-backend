<?php $sub_category = App\Models\SubCategory::find($id); ?>

@if($sub_category)
	<a href="/admin/sub-categories/{{ $sub_category->slug }}/edit" class="btn btn-sm btn-info" ><i class="fa fa-edit" ></i> </a>
	<button type="button" class="btn btn-sm btn-danger delete" data-id="{{ $sub_category->slug }}"> <i class="fa fa-trash" ></i> </button>
@endif