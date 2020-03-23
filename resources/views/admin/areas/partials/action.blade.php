<?php $area = App\Models\Area::find($id); ?>

@if($area)
	<a href="/admin/areas/{{ $area->slug }}/edit" class="btn btn-sm btn-info" ><i class="fa fa-edit" ></i> </a>
	<button type="button" class="btn btn-sm btn-danger delete" data-id="{{ $area->slug }}"> <i class="fa fa-trash" ></i> </button>
@endif