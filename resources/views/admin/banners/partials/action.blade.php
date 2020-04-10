<?php $banner = App\Models\Banner::find($id); ?>

@if($banner)
	@if (!$banner->expires_at->isPast())
		<a href="/admin/bs/{{ $banner->id }}/edit" class="btn btn-sm btn-info" ><i class="fa fa-edit" ></i> </a>
	@endif
	<button type="button" class="btn btn-sm btn-danger delete" data-id="{{ $banner->id }}"> <i class="fa fa-trash" ></i> </button>
@endif