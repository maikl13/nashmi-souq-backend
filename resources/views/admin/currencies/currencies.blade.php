@extends('admin.layouts.admin')

@section('title', 'العملات')

@section('breadcrumb')
	<li class="breadcrumb-item active">العملات</li>
@endsection

@section('content')
	<div class="card">
		<div class="card-header text-right">
			<h4 class="d-inline float-right">العملات</h4>
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
	@include('admin.currencies.partials.add-modal')
@endsection

@section('scripts')
	{!! $dataTable->scripts() !!}
	<script> var records = 'currencies'; </script>
	<script src="/admin-assets/js/ajax/crud.js"></script>
@endsection