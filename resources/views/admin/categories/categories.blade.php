@extends('admin.layouts.admin')

@section('head')
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
	<link rel="stylesheet" href="/admin-assets/plugins/fontawesome-iconpicker/dist/css/fontawesome-iconpicker.min.css">
	<style>
		table i {font-size: 16px;}
		.iconpicker-popover {
			box-shadow: 0 0 5px rgba(0, 0, 0, 0.2) !important;
			right: 15px !important;
		}
		.iconpicker-popover.fade.in {opacity: 1; margin-top: -20px !important;}
		.iconpicker-popover .arrow {display: none !important;}
	</style>
@endsection

@section('breadcrumb')
	<li class="breadcrumb-item active">{{ __('Categories') }}</li>
@endsection

@section('content')
	<div class="card">
		<div class="card-header text-right">
			<h4 class="d-inline float-right">{{ __('Categories') }}</h4>
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
	@include('admin.categories.partials.add-modal')
@endsection

@section('scripts')
	<script rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" type="text/javascript"></script>
	<script src="/admin-assets/plugins/fontawesome-iconpicker/dist/js/fontawesome-iconpicker.min.js" type="text/javascript"></script>
	<script> $('.icon').iconpicker(); </script>

	<script> $("[type=file]").fileinput(fileInputOptions); </script>
	{!! $dataTable->scripts() !!}
	<script> var records = 'categories'; </script>
	<script src="/admin-assets/js/ajax/crud.js"></script>
@endsection