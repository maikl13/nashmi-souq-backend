<?php $option = App\Models\Option::find($id); ?>

@if($option)
	@foreach (\App\Models\Category::whereIn('id', $option->categories)->get() as $category)
		<span class="badge bg-gray">{{ $category->name }}</span>
	@endforeach
@endif