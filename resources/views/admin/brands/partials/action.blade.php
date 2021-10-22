<?php $brand = App\Models\Brand::find($id); ?>

@if($brand)
	@if (!$brand->brand_id)
		<a href="/admin/brands/{{ $brand->slug }}/models" class="btn btn-sm btn-info" >
			الموديلات ({{ $brand->children()->count() }})
		</a>
	@endif
	
	<a href="/admin/brands/{{ $brand->slug }}/edit" class="btn btn-sm btn-info" ><i class="fa fa-edit" ></i> </a>
	<button type="button" class="btn btn-sm btn-danger delete" data-id="{{ $brand->slug }}"> <i class="fa fa-trash" ></i> </button>
@endif