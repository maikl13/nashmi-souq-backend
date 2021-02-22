<?php $country = App\Models\Country::find($id); ?>

@if($country)
	<a href="/admin/countries/{{ $country->slug }}/states" class="btn btn-sm btn-info" >
		المدن ({{ $country->states()->count() }})
	</a>
	
	<a href="/admin/countries/{{ $country->slug }}/edit" class="btn btn-sm btn-info" ><i class="fa fa-edit" ></i> </a>
	<button type="button" class="btn btn-sm btn-danger delete" data-id="{{ $country->slug }}"> <i class="fa fa-trash" ></i> </button>
@endif