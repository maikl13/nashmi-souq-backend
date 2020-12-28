<?php $product = App\Models\Product::find($id); ?>

@if ($product)
    <a href="{{ $product->url() }}" class="btn btn-sm btn-info" target="_blank"> <i class="fa fa-external-link" ></i> استعراض</a>
    <a href="/dashboard/products/{{ $product->slug }}/edit" class="btn btn-sm btn-primary"> <i class="fa fa-edit" ></i> تعديل</a>
	<button type="button" class="btn btn-sm btn-danger delete" data-id="{{ $product->slug }}"> <i class="fa fa-trash" ></i> حذف</button>
@endif