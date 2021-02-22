<?php $option = App\Models\Option::find($id); ?>

@if($option)
	<a href="/admin/options/{{ $option->slug }}/option_values" class="btn btn-sm btn-info" >
		الاختيارات ({{ $option->option_values()->count() }})
	</a>
	
	<a href="/admin/options/{{ $option->slug }}/edit" class="btn btn-sm btn-info" ><i class="fa fa-edit" ></i> </a>
	<button type="button" class="btn btn-sm btn-danger delete" data-id="{{ $option->slug }}"> <i class="fa fa-trash" ></i> </button>
@endif