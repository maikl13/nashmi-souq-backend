@extends('admin.layouts.admin')

@section('title', 'الدول')

@section('head')
	<link rel="stylesheet" href="/admin-assets/plugins/country-picker-flags/build/css/countrySelect.min.css">
	<style>
		.country-select {width: 100%;}
		.country-select.inside .flag-dropdown {
		    right: 0;
		    left: auto;
		}
		.country-select.inside input, .country-select.inside input[type=text] {
		    padding-left: 6px;
		    padding-right: 52px;
		    margin-right: 0;
		}
		.country-select .country-list {
			right: 0;
    		direction: rtl;
    		min-width: 360px;
		}
		.country-select .country-list .country {
	    	text-align: right;
		}
		.country-select .country-list .flag {
		    margin-left: 6px;
		    margin-right: auto;
		}
	</style>
@endsection

@section('breadcrumb')
	<li class="breadcrumb-item active">الدول</li>
@endsection

@section('content')
	<div class="card">
		<div class="card-header text-right">
			<h4 class="d-inline float-right">الدول</h4>
			<div class="float-left">
				<a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#add-modal">
		            <i class="fa fa-plus"></i> {{ __('Add New Record') }}
		        </a>
	        </div>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				{!! $dataTable->table(['class' => 'table table-bordered text-center text-nowrap'], true) !!}
			</div>
		</div>
	</div>
@endsection

@section('modals')
	@include('admin.countries.partials.add-modal')
@endsection

@section('scripts')
	<script src="/admin-assets/plugins/country-picker-flags/build/js/countrySelect.min.js" type="text/javascript"r></script>
	<script> 
		$("#country").countrySelect({
			preferredCountries: ['eg','sa','kw','jo','ae','sy','sd','tn','dz','ma','iq','ye','lb','ly','om','mr','qa','so','bh','dj','km','ps'],
			responsiveDropdown: true
		});
	</script>
	<script> $("[type=file]").fileinput(fileInputOptions); </script>
	{!! $dataTable->scripts() !!}
	<script> var records = 'countries'; </script>
	<script src="/admin-assets/js/ajax/crud.js"></script>
@endsection