<?php $state = App\Models\State::find($id); ?>

@if($state)
	<a href="/admin/states/{{ $state->slug }}/areas" class="btn btn-sm btn-info" >
		المناطق ({{ $state->areas()->count() }})
	</a>
	
	<a href="/admin/states/{{ $state->slug }}/edit" class="btn btn-sm btn-info" ><i class="fa fa-edit" ></i> </a>
	<button type="button" class="btn btn-sm btn-danger delete" data-id="{{ $state->slug }}"> <i class="fa fa-trash" ></i> </button>
@endif