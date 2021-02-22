<?php $option_value = App\Models\OptionValue::find($id); ?>

@if($option_value)
	<a href="/admin/option_values/{{ $option_value->slug }}/edit" class="btn btn-sm btn-info" ><i class="fa fa-edit" ></i> </a>
	<button type="button" class="btn btn-sm btn-danger delete" data-id="{{ $option_value->slug }}"> <i class="fa fa-trash" ></i> </button>
@endif