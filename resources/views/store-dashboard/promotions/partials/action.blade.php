<?php $promotion = App\Models\Promotion::find($id); ?>

@if ($promotion)
    <a href="{{ $promotion->url }}" class="btn btn-sm btn-info" target="_blank"> <i class="fa fa-external-link" ></i> استعراض المنتج</a>
	<button type="button" class="btn btn-sm btn-danger delete" data-id="{{ $promotion->id }}"> <i class="fa fa-trash" ></i> حذف</button>
@endif