<?php $currency = App\Models\Currency::find($id); ?>

@if($currency)
	<a href="/admin/currencies/{{ $currency->slug }}/edit" class="btn btn-sm btn-info" ><i class="fa fa-edit" ></i> </a>
	<button type="button" class="btn btn-sm btn-danger delete" data-id="{{ $currency->slug }}"> <i class="fa fa-trash" ></i> </button>
@endif