@extends('admin.layouts.admin')

@section('title', __('Categories'))

@section('head')
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
	<link rel="stylesheet" href="/admin-assets/plugins/fontawesome-iconpicker/dist/css/fontawesome-iconpicker.min.css">
	<style>
		table i {font-size: 16px;}
		table {border: none;}
		.table-bordered td, .table-bordered th { border: none; }
		.iconpicker-popover {
			box-shadow: 0 0 5px rgba(0, 0, 0, 0.2) !important;
			right: 15px !important;
		}
		.iconpicker-popover.fade.in {opacity: 1; margin-top: -20px !important;}
		.iconpicker-popover .arrow {display: none !important;}
		.hidden, .dataTables_length {display: none !important;}

		/* Cheap Solution :) I will replace it with a prober one later ISA */
		tr[data-level="1"] {background: #f7f7f7;}
		tr[data-level="2"] {background: #f1f1f1;}
		tr[data-level="3"] {background: #eee;}
		tr[data-level="4"] {background: #e5e5e5;}
		tr[data-level="5"] {background: #e1e1e1;}
		tr[data-level="6"] {background: #afafaf;}
		tr[data-level="7"] {background: #aeaeae;}
		tr[data-level="8"] {background: #aaa;}
		tr[data-level="9"] {background: #a8a8a8;}
		tr[data-level="10"] {background: #a5a5a5;}
		tr[data-level="1"] td:first-child,
		tr[data-level="2"] td:first-child, tr[data-level="3"] td:first-child, tr[data-level="4"] td:first-child,
		tr[data-level="5"] td:first-child, tr[data-level="6"] td:first-child, tr[data-level="7"] td:first-child,
		tr[data-level="8"] td:first-child, tr[data-level="9"] td:first-child, tr[data-level="10"] td:first-child {
			position: relative;
			border-left: 1px solid rgba(0, 0, 200, .3);
		}

		tr[data-level="2"] td:first-child {left: 10px;}
		tr[data-level="3"] td:first-child {left: 20px;}
		tr[data-level="4"] td:first-child {left: 27px;}
		tr[data-level="5"] td:first-child {left: 34px;}
		tr[data-level="6"] td:first-child {left: 40px;}
		tr[data-level="7"] td:first-child {left: 45px;}
		tr[data-level="8"] td:first-child {left: 50px;}
		tr[data-level="9"] td:first-child {left: 55px;}
		tr[data-level="10"] td:first-child {left: 60px;}

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