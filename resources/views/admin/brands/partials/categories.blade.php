<?php $brand = App\Models\Brand::find($id); ?>

@if($brand)
	@foreach (\App\Models\Category::whereIn('id', $brand->categories)->get() as $category)
		<span class="badge bg-gray">{{ $category->name }}</span>
	@endforeach
@endif